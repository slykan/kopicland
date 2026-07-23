<?php

namespace Tests\Feature;

use App\Filament\Resources\AmenityResource\Pages\ManageAmenities;
use App\Filament\Resources\DiscountResource\Pages\CreateDiscount;
use App\Filament\Resources\DiscountResource\Pages\ListDiscounts;
use App\Filament\Resources\ExtraCostResource\Pages\CreateExtraCost;
use App\Filament\Resources\ExtraCostResource\Pages\ListExtraCosts;
use App\Filament\Resources\HouseResource\Pages\CreateHouse;
use App\Filament\Resources\HouseResource\Pages\EditHouse;
use App\Filament\Resources\HouseResource\Pages\ListHouses;
use App\Models\House;
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
}
