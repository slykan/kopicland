<?php

namespace App\Livewire\Public;

use App\Exceptions\BookingRuleException;
use App\Models\Guest;
use App\Models\House;
use App\Models\Reservation;
use App\Services\AvailabilityChecker;
use App\Services\PriceCalculator;
use Livewire\Attributes\Validate;
use Livewire\Component;

class BookingForm extends Component
{
    public House $house;

    #[Validate('required|date|after_or_equal:today')]
    public ?string $checkIn = null;

    #[Validate('required|date|after:checkIn')]
    public ?string $checkOut = null;

    #[Validate('required|integer|min:1')]
    public int $adults = 2;

    #[Validate('integer|min:0')]
    public int $children = 0;

    #[Validate('integer|min:0')]
    public int $pets = 0;

    #[Validate('required|string|max:255')]
    public string $firstName = '';

    #[Validate('required|string|max:255')]
    public string $lastName = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('nullable|string|max:50')]
    public string $phone = '';

    #[Validate('nullable|string|max:255')]
    public string $country = '';

    #[Validate('nullable|string|max:2000')]
    public string $guestNote = '';

    public string $promoCode = '';

    #[Validate('accepted')]
    public bool $acceptRules = false;

    #[Validate('accepted')]
    public bool $acceptPrivacy = false;

    public ?array $priceBreakdown = null;

    public ?string $priceError = null;

    public bool $submitted = false;

    public function mount(House $house): void
    {
        $this->house = $house;
    }

    public function updated($property): void
    {
        if (in_array($property, ['checkIn', 'checkOut', 'adults', 'children', 'promoCode'])) {
            $this->calculatePrice();
        }
    }

    public function calculatePrice(): void
    {
        $this->priceError = null;
        $this->priceBreakdown = null;

        if (! $this->checkIn || ! $this->checkOut) {
            return;
        }

        try {
            $this->priceBreakdown = app(PriceCalculator::class)->calculate(
                $this->house,
                $this->checkIn,
                $this->checkOut,
                $this->adults,
                $this->children,
                $this->promoCode ?: null,
            )->toArray();
        } catch (BookingRuleException $e) {
            $this->priceError = $e->getMessage();
        }
    }

    public function submit(AvailabilityChecker $availabilityChecker, PriceCalculator $priceCalculator): void
    {
        $this->validate();

        if (! $availabilityChecker->isAvailable($this->house->id, $this->checkIn, $this->checkOut)) {
            $this->priceError = __('These dates are no longer available for this house.');

            return;
        }

        try {
            $breakdown = $priceCalculator->calculate(
                $this->house,
                $this->checkIn,
                $this->checkOut,
                $this->adults,
                $this->children,
                $this->promoCode ?: null,
            );
        } catch (BookingRuleException $e) {
            $this->priceError = $e->getMessage();

            return;
        }

        $guest = Guest::create([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone ?: null,
            'country' => $this->country ?: null,
            'preferred_locale' => app()->getLocale(),
            'rules_accepted_at' => now(),
            'privacy_accepted_at' => now(),
        ]);

        Reservation::create([
            'house_id' => $this->house->id,
            'guest_id' => $guest->id,
            'check_in' => $this->checkIn,
            'check_out' => $this->checkOut,
            'adults' => $this->adults,
            'children' => $this->children,
            'pets' => $this->pets,
            'status' => 'new_request',
            'source' => 'website',
            'locale' => app()->getLocale(),
            'total_price' => $breakdown->total,
            'discount_amount' => $breakdown->discountAmount,
            'guest_note' => $this->guestNote ?: null,
        ]);

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.public.booking-form');
    }
}
