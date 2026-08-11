<?php

namespace App\Observers;

use App\Models\Reservation;
use App\Services\ReservationNotifier;
use Illuminate\Support\Facades\Log;
use Throwable;

class ReservationObserver
{
    private const STATUS_TEMPLATES = [
        'pending' => 'guest_pending',
        'confirmed' => 'guest_confirmed',
        'rejected' => 'guest_rejected',
        'cancelled' => 'guest_cancelled',
    ];

    public function __construct(private readonly ReservationNotifier $notifier) {}

    public function created(Reservation $reservation): void
    {
        $reservation->logs()->create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'meta' => ['status' => $reservation->status],
        ]);

        if ($reservation->status === 'new_request') {
            $this->notify($reservation, 'guest_request_received');
            $this->notify($reservation, 'admin_new_request');

            return;
        }

        if ($templateKey = self::STATUS_TEMPLATES[$reservation->status] ?? null) {
            $this->notify($reservation, $templateKey);
        }
    }

    public function updated(Reservation $reservation): void
    {
        $reservation->logs()->create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'meta' => $reservation->getChanges(),
        ]);

        if ($reservation->wasChanged('status')) {
            if ($templateKey = self::STATUS_TEMPLATES[$reservation->status] ?? null) {
                $this->notify($reservation, $templateKey);
            }

            if ($reservation->status === 'cancelled') {
                $this->notify($reservation, 'admin_cancelled');
            }

            return;
        }

        if ($reservation->status === 'confirmed' && ($reservation->wasChanged('check_in') || $reservation->wasChanged('check_out'))) {
            $this->notify($reservation, 'guest_modified');
        }
    }

    /**
     * A failed notification email must not fail the reservation itself — the booking
     * (and its date block) is already committed by the time this runs.
     */
    private function notify(Reservation $reservation, string $templateKey): void
    {
        try {
            $this->notifier->notify($reservation, $templateKey);
        } catch (Throwable $e) {
            Log::error("Failed to send reservation notification [{$templateKey}] for reservation #{$reservation->id}: {$e->getMessage()}");
        }
    }
}
