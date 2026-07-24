<?php

namespace App\Services;

use App\Exceptions\BookingRuleException;
use App\Models\Discount;
use App\Models\ExtraCost;
use App\Models\House;
use App\Models\PricingTier;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class PriceCalculator
{
    public function calculate(
        House $house,
        CarbonInterface|string $checkIn,
        CarbonInterface|string $checkOut,
        int $adults = 1,
        int $children = 0,
        ?string $promoCode = null,
    ): PriceBreakdown {
        $checkIn = Carbon::parse($checkIn)->startOfDay();
        $checkOut = Carbon::parse($checkOut)->startOfDay();
        $nights = $checkIn->diffInDays($checkOut);

        if ($nights < 1) {
            throw new BookingRuleException('Check-out must be after check-in.');
        }

        $this->assertStayRulesSatisfied($house, $checkIn, $checkOut, $nights);

        $accommodationSubtotal = $this->accommodationSubtotal($house, $checkIn, $nights, $adults + $children);
        [$extraCosts, $extraCostsTotal] = $this->extraCosts($house, $nights, $adults, $children);
        [$discount, $discountAmount] = $this->bestDiscount($house, $checkIn, $nights, $accommodationSubtotal, $promoCode);

        $total = max(0, $accommodationSubtotal - $discountAmount) + $extraCostsTotal;

        return new PriceBreakdown(
            nights: $nights,
            accommodationSubtotal: $accommodationSubtotal,
            extraCosts: $extraCosts,
            extraCostsTotal: $extraCostsTotal,
            discount: $discount,
            discountAmount: $discountAmount,
            total: round($total, 2),
        );
    }

    private function assertStayRulesSatisfied(House $house, Carbon $checkIn, Carbon $checkOut, int $nights): void
    {
        $stayRule = $house->stayRules()
            ->where(fn ($q) => $q->whereNull('date_from')->orWhere('date_from', '<=', $checkIn))
            ->where(fn ($q) => $q->whereNull('date_to')->orWhere('date_to', '>=', $checkIn))
            ->orderByRaw('date_from IS NULL')
            ->first();

        if (! $stayRule) {
            return;
        }

        if ($nights < $stayRule->min_nights) {
            throw new BookingRuleException("Minimum stay is {$stayRule->min_nights} nights.");
        }

        if ($stayRule->max_nights && $nights > $stayRule->max_nights) {
            throw new BookingRuleException("Maximum stay is {$stayRule->max_nights} nights.");
        }

        if (! empty($stayRule->allowed_arrival_days) && ! in_array(strtolower($checkIn->englishDayOfWeek), $stayRule->allowed_arrival_days)) {
            throw new BookingRuleException('Arrival is not allowed on '.$checkIn->englishDayOfWeek.'.');
        }

        if (! empty($stayRule->allowed_departure_days) && ! in_array(strtolower($checkOut->englishDayOfWeek), $stayRule->allowed_departure_days)) {
            throw new BookingRuleException('Departure is not allowed on '.$checkOut->englishDayOfWeek.'.');
        }
    }

    private function accommodationSubtotal(House $house, Carbon $checkIn, int $nights, int $guests): float
    {
        $pricingRules = $house->pricingRules()->get();
        $tiersByRule = PricingTier::query()->orderBy('guests')->get()->groupBy('pricing_rule_id');

        $total = 0.0;

        for ($i = 0; $i < $nights; $i++) {
            $date = $checkIn->copy()->addDays($i);

            $rule = $pricingRules->first(fn ($rule) => $rule->type === 'date' && $date->between($rule->date_from, $rule->date_to))
                ?? $pricingRules->first(fn ($rule) => $rule->type === 'season' && $date->between($rule->date_from, $rule->date_to));

            $tiers = $tiersByRule->get($rule?->id);

            if ($tiers && $tiers->isNotEmpty()) {
                $tier = $tiers->first(fn (PricingTier $tier) => $tier->guests >= $guests);

                if (! $tier) {
                    throw new BookingRuleException("This house sleeps a maximum of {$tiers->last()->guests} guests.");
                }

                $total += (float) $tier->price_per_night;
            } else {
                $total += $rule ? (float) $rule->price_per_night : (float) $house->base_price_per_night;
            }
        }

        return round($total, 2);
    }

    private function extraCosts(House $house, int $nights, int $adults, int $children): array
    {
        $guests = $adults + $children;

        $costs = ExtraCost::query()
            ->where('is_active', true)
            ->where(fn ($q) => $q->where('house_id', $house->id)->orWhereNull('house_id'))
            ->get();

        $breakdown = [];
        $total = 0.0;

        foreach ($costs as $cost) {
            $amount = match ($cost->unit) {
                'one_time' => (float) $cost->amount,
                'per_night' => (float) $cost->amount * $nights,
                'per_person' => (float) $cost->amount * $guests,
                'per_person_per_night' => (float) $cost->amount * $guests * $nights,
            };

            $breakdown[] = [
                'name' => $cost->getTranslation('name', app()->getLocale(), useFallbackLocale: true),
                'amount' => round($amount, 2),
            ];

            $total += $amount;
        }

        return [$breakdown, round($total, 2)];
    }

    private function bestDiscount(House $house, Carbon $checkIn, int $nights, float $accommodationSubtotal, ?string $promoCode): array
    {
        $today = Carbon::today();
        $daysUntilCheckIn = $today->diffInDays($checkIn, false);

        $discounts = Discount::query()
            ->where('is_active', true)
            ->where(fn ($q) => $q->where('house_id', $house->id)->orWhereNull('house_id'))
            ->get()
            ->filter(function ($discount) use ($today) {
                if ($discount->active_from && $today->lt($discount->active_from)) {
                    return false;
                }

                return ! ($discount->active_until && $today->gt($discount->active_until));
            })
            ->filter(function ($discount) use ($nights, $daysUntilCheckIn, $promoCode) {
                return match ($discount->type) {
                    'long_stay' => $nights >= ($discount->min_nights ?? 0),
                    'early_bird' => $discount->threshold_days !== null && $daysUntilCheckIn >= $discount->threshold_days,
                    'last_minute' => $discount->threshold_days !== null && $daysUntilCheckIn >= 0 && $daysUntilCheckIn <= $discount->threshold_days,
                    'promo_code' => $promoCode !== null && $discount->code !== null && strcasecmp($promoCode, $discount->code) === 0,
                    default => false,
                };
            });

        $best = null;
        $bestAmount = 0.0;

        foreach ($discounts as $discount) {
            $amount = $discount->value_type === 'percent'
                ? $accommodationSubtotal * ((float) $discount->value / 100)
                : (float) $discount->value;

            $amount = min($amount, $accommodationSubtotal);

            if ($amount > $bestAmount) {
                $best = $discount;
                $bestAmount = $amount;
            }
        }

        if (! $best) {
            return [null, 0.0];
        }

        return [
            [
                'type' => $best->type,
                'label' => $best->getTranslation('label', app()->getLocale(), useFallbackLocale: true) ?: $best->type,
            ],
            round($bestAmount, 2),
        ];
    }
}
