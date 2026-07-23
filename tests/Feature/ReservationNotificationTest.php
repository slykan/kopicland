<?php

namespace Tests\Feature;

use App\Mail\ReservationStatusMail;
use App\Models\EmailTemplate;
use App\Models\Guest;
use App\Models\House;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ReservationNotificationTest extends TestCase
{
    use RefreshDatabase;

    private House $house;

    private Guest $guest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\EmailTemplateSeeder::class);

        $this->house = House::create([
            'slug' => 'mail-house',
            'name' => ['hr' => 'Kućica za mail test', 'en' => 'Mail test house'],
            'base_price_per_night' => 50,
        ]);

        $this->guest = Guest::create([
            'first_name' => 'Ana',
            'last_name' => 'Anić',
            'email' => 'ana@example.com',
        ]);
    }

    public function test_creating_a_new_request_emails_guest_and_admin(): void
    {
        Mail::fake();

        Reservation::create([
            'house_id' => $this->house->id,
            'guest_id' => $this->guest->id,
            'check_in' => '2026-10-01',
            'check_out' => '2026-10-05',
            'status' => 'new_request',
            'locale' => 'en',
        ]);

        Mail::assertSent(ReservationStatusMail::class, 2);
        Mail::assertSent(ReservationStatusMail::class, function (ReservationStatusMail $mail) {
            return str_contains($mail->renderedSubject, 'Mail test house');
        });
    }

    public function test_confirming_a_reservation_emails_guest_in_their_locale(): void
    {
        $reservation = Reservation::create([
            'house_id' => $this->house->id,
            'guest_id' => $this->guest->id,
            'check_in' => '2026-10-01',
            'check_out' => '2026-10-05',
            'status' => 'new_request',
            'locale' => 'hr',
        ]);

        Mail::fake();

        $reservation->update(['status' => 'confirmed']);

        Mail::assertSent(ReservationStatusMail::class, function (ReservationStatusMail $mail) {
            return str_contains($mail->renderedSubject, 'Kućica za mail test');
        });
    }

    public function test_cancelling_notifies_both_guest_and_admin(): void
    {
        $reservation = Reservation::create([
            'house_id' => $this->house->id,
            'guest_id' => $this->guest->id,
            'check_in' => '2026-10-01',
            'check_out' => '2026-10-05',
            'status' => 'confirmed',
            'locale' => 'en',
        ]);

        Mail::fake();

        $reservation->update(['status' => 'cancelled']);

        Mail::assertSent(ReservationStatusMail::class, 2);
    }

    public function test_inactive_template_is_not_sent(): void
    {
        EmailTemplate::where('key', 'guest_confirmed')->update(['is_active' => false]);

        $reservation = Reservation::create([
            'house_id' => $this->house->id,
            'guest_id' => $this->guest->id,
            'check_in' => '2026-10-01',
            'check_out' => '2026-10-05',
            'status' => 'new_request',
            'locale' => 'en',
        ]);

        Mail::fake();

        $reservation->update(['status' => 'confirmed']);

        Mail::assertNotSent(ReservationStatusMail::class);
    }

    public function test_status_changes_are_logged(): void
    {
        Mail::fake();

        $reservation = Reservation::create([
            'house_id' => $this->house->id,
            'guest_id' => $this->guest->id,
            'check_in' => '2026-10-01',
            'check_out' => '2026-10-05',
            'status' => 'new_request',
            'locale' => 'en',
        ]);

        $reservation->update(['status' => 'confirmed']);

        $this->assertDatabaseHas('reservation_logs', ['reservation_id' => $reservation->id, 'action' => 'created']);
        $this->assertDatabaseHas('reservation_logs', ['reservation_id' => $reservation->id, 'action' => 'updated']);
    }
}
