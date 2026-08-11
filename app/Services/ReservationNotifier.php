<?php

namespace App\Services;

use App\Mail\ReservationStatusMail;
use App\Models\EmailTemplate;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;

class ReservationNotifier
{
    public function notify(Reservation $reservation, string $templateKey): void
    {
        $template = EmailTemplate::where('key', $templateKey)->where('is_active', true)->first();

        if (! $template) {
            return;
        }

        $recipientEmail = $template->recipient === 'admin'
            ? config('mail.admin_address')
            : $reservation->guest?->email;

        if (! $recipientEmail) {
            return;
        }

        $locale = $template->recipient === 'admin' ? 'hr' : ($reservation->locale ?? 'en');

        $placeholders = $this->placeholders($reservation, $locale);

        $subject = "#{$reservation->id} - ".$this->render($template->getTranslation('subject', $locale, useFallbackLocale: true), $placeholders);
        $body = $this->render($template->getTranslation('body', $locale, useFallbackLocale: true), $placeholders);

        Mail::to($recipientEmail)->send(new ReservationStatusMail($subject, $body));
    }

    private function placeholders(Reservation $reservation, string $locale): array
    {
        $house = $reservation->house;

        return [
            '{{guest_name}}' => $reservation->guest
                ? "{$reservation->guest->first_name} {$reservation->guest->last_name}"
                : '',
            '{{house_name}}' => $house ? $house->getTranslation('name', $locale, useFallbackLocale: true) : '',
            '{{check_in}}' => optional($reservation->check_in)->format('d.m.Y'),
            '{{check_out}}' => optional($reservation->check_out)->format('d.m.Y'),
            '{{reservation_id}}' => (string) $reservation->id,
            '{{total_price}}' => number_format((float) $reservation->total_price, 2).' EUR',
        ];
    }

    private function render(string $template, array $placeholders): string
    {
        return strtr($template, $placeholders);
    }
}
