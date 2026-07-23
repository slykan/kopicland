<?php

namespace Tests\Feature;

use App\Filament\Resources\AmenityResource\Pages\ManageAmenities;
use App\Filament\Resources\HouseResource\Pages\CreateHouse;
use App\Filament\Resources\HouseResource\Pages\ListHouses;
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
}
