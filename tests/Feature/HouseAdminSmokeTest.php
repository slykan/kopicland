<?php

namespace Tests\Feature;

use App\Filament\Resources\AmenityResource\Pages\ManageAmenities;
use App\Filament\Resources\DiscountResource\Pages\CreateDiscount;
use App\Filament\Resources\DiscountResource\Pages\ListDiscounts;
use App\Filament\Resources\EmailTemplateResource\Pages\ManageEmailTemplates;
use App\Filament\Resources\ExtraCostResource\Pages\CreateExtraCost;
use App\Filament\Resources\ExtraCostResource\Pages\ListExtraCosts;
use App\Filament\Resources\GuestResource\Pages\CreateGuest;
use App\Filament\Resources\GuestResource\Pages\ListGuests;
use App\Filament\Resources\HouseResource\Pages\CreateHouse;
use App\Filament\Resources\HouseResource\Pages\EditHouse;
use App\Filament\Resources\HouseResource\Pages\ListHouses;
use App\Filament\Resources\ReservationResource\Pages\CreateReservation;
use App\Filament\Resources\ReservationResource\Pages\ListReservations;
use App\Models\Guest;
use App\Models\House;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class HouseAdminSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_load_houses_list(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(ListHouses::class)->assertSuccessful();
    }

    public function test_admin_can_load_house_create_form(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreateHouse::class)->assertSuccessful();
    }

    public function test_admin_can_load_amenities_page(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(ManageAmenities::class)->assertSuccessful();
    }

    public function test_admin_can_create_a_house_with_translated_name(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreateHouse::class)
            ->fillForm([
                'slug' => 'planinska-kucica',
                'name' => 'Planinska kućica',
                'base_price_per_night' => 75,
                'status' => 'draft',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $house = \App\Models\House::firstWhere('slug', 'planinska-kucica');

        $this->assertNotNull($house);
        $this->assertSame('Planinska kućica', $house->getTranslation('name', 'hr'));
    }

    public function test_admin_can_add_pricing_and_stay_rules_to_a_house(): void
    {
        $this->actingAs(User::factory()->create());

        $house = House::create([
            'slug' => 'jezerska-kucica',
            'name' => ['hr' => 'Jezerska kućica'],
            'base_price_per_night' => 60,
        ]);

        Livewire::test(EditHouse::class, ['record' => $house->getRouteKey()])
            ->assertSuccessful();

        $house->pricingRules()->create([
            'type' => 'season',
            'label' => ['en' => 'High season'],
            'date_from' => '2026-07-01',
            'date_to' => '2026-08-31',
            'price_per_night' => 95,
        ]);

        $house->stayRules()->create([
            'min_nights' => 3,
            'max_nights' => 14,
            'allowed_arrival_days' => ['friday', 'saturday'],
        ]);

        $this->assertDatabaseHas('pricing_rules', ['house_id' => $house->id, 'price_per_night' => 95]);
        $this->assertDatabaseHas('stay_rules', ['house_id' => $house->id, 'min_nights' => 3]);
    }

    public function test_admin_can_load_extra_costs_and_discounts_pages(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(ListExtraCosts::class)->assertSuccessful();
        Livewire::test(CreateExtraCost::class)->assertSuccessful();
        Livewire::test(ListDiscounts::class)->assertSuccessful();
        Livewire::test(CreateDiscount::class)->assertSuccessful();
    }

    public function test_admin_can_create_a_global_extra_cost_and_a_promo_discount(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreateExtraCost::class)
            ->fillForm([
                'name' => 'Cleaning fee',
                'amount' => 30,
                'unit' => 'one_time',
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('extra_costs', ['house_id' => null, 'amount' => 30]);

        Livewire::test(CreateDiscount::class)
            ->fillForm([
                'type' => 'promo_code',
                'code' => 'SUMMER26',
                'value' => 10,
                'value_type' => 'percent',
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('discounts', ['code' => 'SUMMER26', 'type' => 'promo_code']);
    }

    public function test_admin_can_load_guest_and_reservation_pages(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(ListGuests::class)->assertSuccessful();
        Livewire::test(CreateGuest::class)->assertSuccessful();
        Livewire::test(ListReservations::class)->assertSuccessful();
        Livewire::test(CreateReservation::class)->assertSuccessful();
        Livewire::test(ManageEmailTemplates::class)->assertSuccessful();
    }

    public function test_admin_cannot_create_overlapping_reservation(): void
    {
        $this->actingAs(User::factory()->create());

        $house = House::create([
            'slug' => 'overlap-house',
            'name' => ['hr' => 'Kucica'],
            'base_price_per_night' => 50,
        ]);

        Reservation::create([
            'house_id' => $house->id,
            'check_in' => '2026-09-01',
            'check_out' => '2026-09-05',
            'status' => 'confirmed',
        ]);

        Livewire::test(CreateReservation::class)
            ->fillForm([
                'house_id' => $house->id,
                'check_in' => '2026-09-03',
                'check_out' => '2026-09-07',
                'status' => 'new_request',
                'source' => 'website',
                'locale' => 'hr',
            ])
            ->call('create')
            ->assertHasFormErrors(['check_out']);

        $this->assertDatabaseCount('reservations', 1);
    }

    public function test_admin_can_create_a_non_overlapping_reservation_with_a_new_guest(): void
    {
        $this->actingAs(User::factory()->create());

        $house = House::create([
            'slug' => 'free-house',
            'name' => ['hr' => 'Slobodna kucica'],
            'base_price_per_night' => 50,
        ]);

        Livewire::test(CreateReservation::class)
            ->fillForm([
                'house_id' => $house->id,
                'check_in' => '2026-09-10',
                'check_out' => '2026-09-14',
                'status' => 'confirmed',
                'source' => 'phone',
                'locale' => 'hr',
                'total_price' => 200,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('reservations', [
            'house_id' => $house->id,
            'status' => 'confirmed',
            'source' => 'phone',
        ]);
    }
}
