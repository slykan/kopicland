<?php

namespace Tests\Feature;

use App\Filament\Pages\BookingSettingsPage;
use App\Livewire\Public\BookingForm;
use App\Mail\BookingInquiryMail;
use App\Models\BookingSetting;
use App\Models\House;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class BookingInquiryTest extends TestCase
{
    use RefreshDatabase;

    private function house(): House
    {
        return House::create(['slug' => 'kucica-1', 'name' => ['hr' => 'Kućica 1'], 'base_price_per_night' => 60, 'status' => 'published']);
    }

    public function test_booking_is_enabled_by_default(): void
    {
        $this->assertTrue(BookingSetting::onlineBookingEnabled());

        $this->get('/hr/houses/'.$this->house()->slug)
            ->assertSuccessful()
            ->assertSee('Rezerviraj')
            ->assertDontSee('Upit za odabrane datume');
    }

    public function test_disabled_booking_shows_inquiry_form_and_sends_mail_without_reservation(): void
    {
        Mail::fake();
        BookingSetting::current()->update(['online_booking' => false]);
        $house = $this->house();

        $this->get('/hr/houses/'.$house->slug)
            ->assertSuccessful()
            ->assertSee('Upit za odabrane datume')
            ->assertSee('Pošalji upit');

        $in = now()->addDays(10);
        $out = now()->addDays(13);

        Livewire::test(BookingForm::class, ['house' => $house])
            ->assertSet('inquiryMode', true)
            ->set('checkIn', $in->format('d.m.Y'))
            ->set('checkOut', $out->format('d.m.Y'))
            ->set('adults', 2)
            ->set('children', 1)
            ->set('firstName', 'Ana')
            ->set('lastName', 'Anić')
            ->set('email', 'ana@example.com')
            ->set('guestNote', 'Dolazimo s psom?')
            ->set('acceptPrivacy', true)
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('submitted', true);

        $this->assertDatabaseCount('reservations', 0);
        $this->assertDatabaseCount('guests', 0);

        Mail::assertSent(BookingInquiryMail::class, function (BookingInquiryMail $mail) use ($in, $out) {
            return $mail->hasTo(config('site.contact.email'))
                && $mail->inquiry['house'] === 'Kućica 1'
                && $mail->inquiry['check_in'] === $in->format('d.m.Y.')
                && $mail->inquiry['check_out'] === $out->format('d.m.Y.')
                && $mail->inquiry['nights'] === 3
                && $mail->inquiry['name'] === 'Ana Anić';
        });
    }

    public function test_inquiry_requires_dates_contact_and_privacy(): void
    {
        Mail::fake();
        BookingSetting::current()->update(['online_booking' => false]);

        Livewire::test(BookingForm::class, ['house' => $this->house()])
            ->call('submit')
            ->assertHasErrors(['checkIn', 'checkOut', 'firstName', 'lastName', 'email', 'acceptPrivacy'])
            ->assertHasNoErrors(['address', 'country', 'acceptRules', 'phone']);

        Mail::assertNothingSent();
    }

    public function test_form_opened_before_switch_off_cannot_create_reservation(): void
    {
        Mail::fake();
        $house = $this->house();

        $component = Livewire::test(BookingForm::class, ['house' => $house])->assertSet('inquiryMode', false);

        BookingSetting::current()->update(['online_booking' => false]);

        $component
            ->set('checkIn', now()->addDays(10)->toDateString())
            ->set('checkOut', now()->addDays(12)->toDateString())
            ->set('firstName', 'Ana')
            ->set('lastName', 'Anić')
            ->set('email', 'ana@example.com')
            ->set('acceptPrivacy', true)
            ->call('submit')
            ->assertSet('submitted', true);

        $this->assertDatabaseCount('reservations', 0);
        Mail::assertSent(BookingInquiryMail::class);
    }

    public function test_admin_can_switch_booking_off_and_staff_without_rights_cannot(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $this->get('/admin/online-booking')->assertSuccessful();

        Livewire::test(BookingSettingsPage::class)
            ->assertSet('data.online_booking', true)
            ->set('data.online_booking', false)
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertFalse(BookingSetting::current()->online_booking);

        $this->actingAs(User::factory()->create(['role' => 'content_editor']));
        $this->get('/admin/online-booking')->assertForbidden();
    }
}
