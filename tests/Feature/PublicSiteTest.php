<?php

namespace Tests\Feature;

use App\Livewire\Public\BookingForm;
use App\Models\House;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_to_default_locale(): void
    {
        $this->get('/')->assertRedirect('/hr');
    }

    public function test_home_page_loads_for_each_supported_locale(): void
    {
        foreach (['hr', 'en', 'de'] as $locale) {
            $this->get("/{$locale}")->assertSuccessful();
        }
    }

    public function test_unsupported_locale_is_not_found(): void
    {
        $this->get('/fr')->assertNotFound();
    }

    public function test_house_list_shows_only_published_houses(): void
    {
        House::create(['slug' => 'published', 'name' => ['hr' => 'Objavljena'], 'base_price_per_night' => 50, 'status' => 'published']);
        House::create(['slug' => 'draft', 'name' => ['hr' => 'Skica'], 'base_price_per_night' => 50, 'status' => 'draft']);

        $response = $this->get('/hr/houses');

        $response->assertSuccessful();
        $response->assertSee('Objavljena');
        $response->assertDontSee('Skica');
    }

    public function test_house_list_filters_by_availability_dates(): void
    {
        $house = House::create(['slug' => 'busy-house', 'name' => ['hr' => 'Zauzeta'], 'base_price_per_night' => 50, 'status' => 'published']);

        Reservation::create([
            'house_id' => $house->id,
            'check_in' => '2026-08-01',
            'check_out' => '2026-08-05',
            'status' => 'confirmed',
        ]);

        $response = $this->get('/hr/houses?check_in=2026-08-02&check_out=2026-08-04');

        $response->assertSuccessful();
        $response->assertDontSee('Zauzeta');
    }

    public function test_house_detail_page_shows_translated_content(): void
    {
        $house = House::create([
            'slug' => 'detail-house',
            'name' => ['hr' => 'Detaljna kućica', 'en' => 'Detail house'],
            'base_price_per_night' => 70,
            'status' => 'published',
        ]);

        $this->get('/hr/houses/detail-house')->assertSee('Detaljna kućica');
        $this->get('/en/houses/detail-house')->assertSee('Detail house');
    }

    public function test_guest_can_submit_a_booking_request(): void
    {
        $house = House::create([
            'slug' => 'booking-house',
            'name' => ['hr' => 'Booking kućica'],
            'base_price_per_night' => 60,
            'status' => 'published',
        ]);

        Livewire::test(BookingForm::class, ['house' => $house])
            ->set('checkIn', now()->addDays(10)->toDateString())
            ->set('checkOut', now()->addDays(13)->toDateString())
            ->set('adults', 2)
            ->set('children', 0)
            ->set('firstName', 'Ana')
            ->set('lastName', 'Anić')
            ->set('email', 'ana@example.com')
            ->set('acceptRules', true)
            ->set('acceptPrivacy', true)
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('submitted', true);

        $this->assertDatabaseHas('guests', ['email' => 'ana@example.com']);
        $this->assertDatabaseHas('reservations', [
            'house_id' => $house->id,
            'status' => 'new_request',
            'source' => 'website',
            'total_price' => 180.0,
        ]);
    }

    public function test_booking_form_rejects_already_taken_dates(): void
    {
        $house = House::create([
            'slug' => 'taken-house',
            'name' => ['hr' => 'Zauzeta kućica'],
            'base_price_per_night' => 60,
            'status' => 'published',
        ]);

        Reservation::create([
            'house_id' => $house->id,
            'check_in' => now()->addDays(10)->toDateString(),
            'check_out' => now()->addDays(13)->toDateString(),
            'status' => 'confirmed',
        ]);

        Livewire::test(BookingForm::class, ['house' => $house])
            ->set('checkIn', now()->addDays(11)->toDateString())
            ->set('checkOut', now()->addDays(12)->toDateString())
            ->set('firstName', 'Ana')
            ->set('lastName', 'Anić')
            ->set('email', 'ana@example.com')
            ->set('acceptRules', true)
            ->set('acceptPrivacy', true)
            ->call('submit')
            ->assertSet('submitted', false);

        $this->assertDatabaseCount('reservations', 1);
    }

    public function test_booking_form_requires_rule_and_privacy_acceptance(): void
    {
        $house = House::create([
            'slug' => 'consent-house',
            'name' => ['hr' => 'Kućica'],
            'base_price_per_night' => 60,
            'status' => 'published',
        ]);

        Livewire::test(BookingForm::class, ['house' => $house])
            ->set('checkIn', now()->addDays(10)->toDateString())
            ->set('checkOut', now()->addDays(13)->toDateString())
            ->set('firstName', 'Ana')
            ->set('lastName', 'Anić')
            ->set('email', 'ana@example.com')
            ->call('submit')
            ->assertHasErrors(['acceptRules', 'acceptPrivacy']);

        $this->assertDatabaseCount('reservations', 0);
    }
}
