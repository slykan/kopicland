<?php

namespace Tests\Unit;

use App\Exceptions\BookingRuleException;
use App\Models\House;
use App\Services\PriceCalculator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PriceCalculatorTest extends TestCase
{
    use RefreshDatabase;

    private PriceCalculator $calculator;

    private House $house;

    protected function setUp(): void
    {
        parent::setUp();

        $this->calculator = new PriceCalculator;
        $this->house = House::create([
            'slug' => 'calc-house',
            'name' => ['hr' => 'Kućica'],
            'base_price_per_night' => 50,
        ]);
    }

    public function test_uses_base_price_when_no_rules_exist(): void
    {
        $breakdown = $this->calculator->calculate($this->house, '2026-06-01', '2026-06-04');

        $this->assertSame(3, $breakdown->nights);
        $this->assertSame(150.0, $breakdown->accommodationSubtotal);
        $this->assertSame(150.0, $breakdown->total);
    }

    public function test_season_pricing_rule_overrides_base_price(): void
    {
        $this->house->pricingRules()->create([
            'type' => 'season',
            'date_from' => '2026-07-01',
            'date_to' => '2026-08-31',
            'price_per_night' => 100,
        ]);

        $breakdown = $this->calculator->calculate($this->house, '2026-07-10', '2026-07-13');

        $this->assertSame(300.0, $breakdown->accommodationSubtotal);
    }

    public function test_date_specific_rule_takes_priority_over_season(): void
    {
        $this->house->pricingRules()->create([
            'type' => 'season',
            'date_from' => '2026-12-01',
            'date_to' => '2026-12-31',
            'price_per_night' => 80,
        ]);

        $this->house->pricingRules()->create([
            'type' => 'date',
            'date_from' => '2026-12-31',
            'date_to' => '2026-12-31',
            'price_per_night' => 200,
        ]);

        $breakdown = $this->calculator->calculate($this->house, '2026-12-30', '2027-01-01');

        // 2026-12-30 -> season price (80), 2026-12-31 -> date-specific price (200)
        $this->assertSame(280.0, $breakdown->accommodationSubtotal);
    }

    public function test_extra_costs_are_summed_per_their_unit(): void
    {
        $this->house->extraCosts()->create(['name' => 'Cleaning', 'amount' => 30, 'unit' => 'one_time', 'is_active' => true]);
        $this->house->extraCosts()->create(['name' => 'Tourist tax', 'amount' => 2, 'unit' => 'per_person_per_night', 'is_active' => true]);
        $this->house->extraCosts()->create(['name' => 'Inactive', 'amount' => 999, 'unit' => 'one_time', 'is_active' => false]);

        $breakdown = $this->calculator->calculate($this->house, '2026-06-01', '2026-06-04', adults: 2, children: 1);

        // cleaning 30 (one-time) + tourist tax 2 * 3 guests * 3 nights = 18 -> total extras 48
        $this->assertSame(48.0, $breakdown->extraCostsTotal);
        $this->assertCount(2, $breakdown->extraCosts);
        $this->assertSame(198.0, $breakdown->total); // 150 accommodation + 48 extras
    }

    public function test_global_extra_cost_applies_to_every_house(): void
    {
        \App\Models\ExtraCost::create(['house_id' => null, 'name' => 'Booking fee', 'amount' => 5, 'unit' => 'one_time', 'is_active' => true]);

        $breakdown = $this->calculator->calculate($this->house, '2026-06-01', '2026-06-02');

        $this->assertSame(5.0, $breakdown->extraCostsTotal);
    }

    public function test_long_stay_discount_applies_when_min_nights_met(): void
    {
        $this->house->discounts()->create([
            'type' => 'long_stay', 'value' => 10, 'value_type' => 'percent', 'min_nights' => 5, 'is_active' => true,
        ]);

        $shortStay = $this->calculator->calculate($this->house, '2026-06-01', '2026-06-04');
        $this->assertNull($shortStay->discount);

        $longStay = $this->calculator->calculate($this->house, '2026-06-01', '2026-06-06');
        $this->assertNotNull($longStay->discount);
        $this->assertSame(25.0, $longStay->discountAmount); // 10% of 250
    }

    public function test_promo_code_discount_requires_matching_code(): void
    {
        $this->house->discounts()->create([
            'type' => 'promo_code', 'code' => 'SUMMER26', 'value' => 20, 'value_type' => 'fixed', 'is_active' => true,
        ]);

        $withoutCode = $this->calculator->calculate($this->house, '2026-06-01', '2026-06-04');
        $this->assertNull($withoutCode->discount);

        $withWrongCode = $this->calculator->calculate($this->house, '2026-06-01', '2026-06-04', promoCode: 'WRONG');
        $this->assertNull($withWrongCode->discount);

        $withCode = $this->calculator->calculate($this->house, '2026-06-01', '2026-06-04', promoCode: 'summer26');
        $this->assertSame(20.0, $withCode->discountAmount);
    }

    public function test_best_discount_is_chosen_among_multiple_applicable(): void
    {
        $this->house->discounts()->create([
            'type' => 'long_stay', 'value' => 5, 'value_type' => 'percent', 'min_nights' => 2, 'is_active' => true,
        ]);
        $this->house->discounts()->create([
            'type' => 'promo_code', 'code' => 'BIG', 'value' => 50, 'value_type' => 'fixed', 'is_active' => true,
        ]);

        $breakdown = $this->calculator->calculate($this->house, '2026-06-01', '2026-06-04', promoCode: 'BIG');

        $this->assertSame('promo_code', $breakdown->discount['type']);
        $this->assertSame(50.0, $breakdown->discountAmount);
    }

    public function test_min_nights_stay_rule_is_enforced(): void
    {
        $this->house->stayRules()->create(['min_nights' => 3]);

        $this->expectException(BookingRuleException::class);
        $this->calculator->calculate($this->house, '2026-06-01', '2026-06-02');
    }

    public function test_max_nights_stay_rule_is_enforced(): void
    {
        $this->house->stayRules()->create(['min_nights' => 1, 'max_nights' => 5]);

        $this->expectException(BookingRuleException::class);
        $this->calculator->calculate($this->house, '2026-06-01', '2026-06-10');
    }

    public function test_allowed_arrival_day_is_enforced(): void
    {
        // 2026-06-01 is a Monday
        $this->house->stayRules()->create(['min_nights' => 1, 'allowed_arrival_days' => ['friday', 'saturday']]);

        $this->expectException(BookingRuleException::class);
        $this->calculator->calculate($this->house, '2026-06-01', '2026-06-03');
    }

    public function test_check_out_before_check_in_is_rejected(): void
    {
        $this->expectException(BookingRuleException::class);
        $this->calculator->calculate($this->house, '2026-06-05', '2026-06-01');
    }

    public function test_guest_pricing_tier_overrides_base_price(): void
    {
        \App\Models\PricingTier::create(['pricing_rule_id' => null, 'guests' => 2, 'price_per_night' => 90]);
        \App\Models\PricingTier::create(['pricing_rule_id' => null, 'guests' => 4, 'price_per_night' => 120]);

        $twoGuests = $this->calculator->calculate($this->house, '2026-06-01', '2026-06-02', adults: 2);
        $this->assertSame(90.0, $twoGuests->accommodationSubtotal);

        $threeGuests = $this->calculator->calculate($this->house, '2026-06-01', '2026-06-02', adults: 3);
        $this->assertSame(120.0, $threeGuests->accommodationSubtotal); // rounds up to the next defined tier

        $fourGuests = $this->calculator->calculate($this->house, '2026-06-01', '2026-06-02', adults: 4);
        $this->assertSame(120.0, $fourGuests->accommodationSubtotal);
    }

    public function test_single_guest_uses_lowest_defined_tier(): void
    {
        \App\Models\PricingTier::create(['pricing_rule_id' => null, 'guests' => 2, 'price_per_night' => 90]);

        $oneGuest = $this->calculator->calculate($this->house, '2026-06-01', '2026-06-02', adults: 1);

        $this->assertSame(90.0, $oneGuest->accommodationSubtotal);
    }

    public function test_exceeding_the_highest_pricing_tier_is_rejected(): void
    {
        \App\Models\PricingTier::create(['pricing_rule_id' => null, 'guests' => 6, 'price_per_night' => 140]);

        $this->expectException(BookingRuleException::class);
        $this->calculator->calculate($this->house, '2026-06-01', '2026-06-02', adults: 7);
    }

    public function test_season_rule_pricing_tiers_take_priority_over_global_tiers(): void
    {
        \App\Models\PricingTier::create(['pricing_rule_id' => null, 'guests' => 2, 'price_per_night' => 90]);

        $rule = $this->house->pricingRules()->create([
            'type' => 'season',
            'date_from' => '2026-07-01',
            'date_to' => '2026-08-31',
            'price_per_night' => 999, // ignored once its own tiers exist
        ]);

        \App\Models\PricingTier::create(['pricing_rule_id' => $rule->id, 'guests' => 2, 'price_per_night' => 150]);

        $breakdown = $this->calculator->calculate($this->house, '2026-07-10', '2026-07-11', adults: 2);

        $this->assertSame(150.0, $breakdown->accommodationSubtotal);
    }
}
