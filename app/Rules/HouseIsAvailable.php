<?php

namespace App\Rules;

use App\Services\AvailabilityChecker;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HouseIsAvailable implements ValidationRule
{
    public function __construct(
        private readonly ?int $houseId,
        private readonly mixed $checkIn,
        private readonly ?int $excludeReservationId = null,
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $this->houseId || ! $this->checkIn || ! $value) {
            return;
        }

        $available = app(AvailabilityChecker::class)->isAvailable(
            $this->houseId,
            $this->checkIn,
            $value,
            $this->excludeReservationId,
        );

        if (! $available) {
            $fail('This house is already reserved or blocked for part of the selected dates.');
        }
    }
}
