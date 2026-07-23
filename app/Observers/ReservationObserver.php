<?php

namespace App\Observers;

use App\Models\Reservation;
use App\Services\ReservationNotifier;

class ReservationObserver
{
    private const STATUS_TEMPLATES = [
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
            $this->notifier->notify($reservation, 'guest_request_received');
            $this->notifier->notify($reservation, 'admin_new_request');

            return;
        }

        if ($templateKey = self::STATUS_TEMPLATES[$reservation->status] ?? null) {
            $this->notifier->notify($reservation, $templateKey);
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
                $this->notifier->notify($reservation, $templateKey);
            }

            if ($reservation->status === 'cancelled') {
                $this->notifier->notify($reservation, 'admin_cancelled');
            }

            return;
        }

        if ($reservation->status === 'confirmed' && ($reservation->wasChanged('check_in') || $reservation->wasChanged('check_out'))) {
            $this->notifier->notify($reservation, 'guest_modified');
        }
    }
}
