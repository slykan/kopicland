<?php

namespace App\Services;

use App\Models\Reservation;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class AvailabilityChecker
{
    /**
     * Statuses that hold a date range as unavailable for new bookings.
     */
    public const BLOCKING_STATUSES = [
        'new_request', 'pending', 'confirmed', 'hold', 'blocked',
    ];

    public function isAvailable(
        int $houseId,
        CarbonInterface|string $checkIn,
        CarbonInterface|string $checkOut,
        ?int $excludeReservationId = null,
    ): bool {
        return ! $this->overlappingReservations($houseId, $checkIn, $checkOut, $excludeReservationId)->exists();
    }

    public function overlappingReservations(
        int $houseId,
        CarbonInterface|string $checkIn,
        CarbonInterface|string $checkOut,
        ?int $excludeReservationId = null,
    ) {
        // Reservation dates are stored as full datetimes (00:00:00); binding
        // Carbon instances (rather than plain "Y-m-d" strings) lets Laravel
        // format them consistently so the comparison isn't a string mismatch.
        $checkIn = Carbon::parse($checkIn)->startOfDay();
        $checkOut = Carbon::parse($checkOut)->startOfDay();

        return Reservation::query()
            ->where('house_id', $houseId)
            ->whereIn('status', self::BLOCKING_STATUSES)
            ->when($excludeReservationId, fn ($query) => $query->whereKeyNot($excludeReservationId))
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn);
    }
}
