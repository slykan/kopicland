<?php

namespace Tests\Feature;

use App\Filament\Pages\DefaultPricingPage;
use App\Filament\Pages\SetPricesPage;
use App\Models\House;
use App\Models\PricingRule;
use App\Models\PricingSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PricingSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_load_the_default_pricing_page(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(DefaultPricingPage::class)->assertSuccessful();
    }

    public function test_admin_can_save_the_default_price(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(DefaultPricingPage::class)
            ->fillForm(['default_price_per_night' => 123.45])
            ->call('save');

        $this->assertSame('123.45', PricingSetting::current()->default_price_per_night);
    }

    public function test_content_editor_cannot_access_pricing_pages(): void
    {
        $editor = User::factory()->create(['role' => 'content_editor']);
        $this->actingAs($editor);

        $this->get('/admin/default-pricing')->assertForbidden();
        $this->get('/admin/set-prices')->assertForbidden();
    }

    public function test_admin_can_load_the_set_prices_page(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(SetPricesPage::class)->assertSuccessful();
    }

    public function test_setting_a_price_applies_to_every_selected_house_and_replaces_overlapping_overrides(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $houseA = House::create(['slug' => 'a', 'name' => ['hr' => 'Kucica A'], 'base_price_per_night' => 50]);
        $houseB = House::create(['slug' => 'b', 'name' => ['hr' => 'Kucica B'], 'base_price_per_night' => 60]);

        $stale = PricingRule::create([
            'house_id' => $houseA->id,
            'type' => 'date',
            'date_from' => '2026-08-10',
            'date_to' => '2026-08-15',
            'price_per_night' => 999,
        ]);

        Livewire::test(SetPricesPage::class)
            ->fillForm([
                'house_ids' => [$houseA->id, $houseB->id],
                'date_from' => '2026-08-01',
                'date_to' => '2026-08-31',
                'price_per_night' => 150,
                'label' => 'High season',
            ])
            ->call('setPrices');

        $this->assertModelMissing($stale);

        $this->assertDatabaseHas('pricing_rules', [
            'house_id' => $houseA->id,
            'type' => 'date',
            'price_per_night' => 150,
        ]);
        $this->assertDatabaseHas('pricing_rules', [
            'house_id' => $houseB->id,
            'type' => 'date',
            'price_per_night' => 150,
        ]);
        $this->assertSame(1, PricingRule::where('house_id', $houseA->id)->count());
    }

    public function test_recent_price_changes_groups_a_multi_house_batch_into_one_row(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $houseA = House::create(['slug' => 'a', 'name' => ['hr' => 'Kucica A'], 'base_price_per_night' => 50]);
        $houseB = House::create(['slug' => 'b', 'name' => ['hr' => 'Kucica B'], 'base_price_per_night' => 60]);

        $component = Livewire::test(SetPricesPage::class)
            ->fillForm([
                'house_ids' => [$houseA->id, $houseB->id],
                'date_from' => '2026-08-01',
                'date_to' => '2026-08-31',
                'price_per_night' => 150,
                'label' => 'High season',
            ])
            ->call('setPrices');

        $rows = $component->instance()->recentPriceChanges();

        $this->assertCount(1, $rows);
        $this->assertStringContainsString('Kucica A', $rows[0]['houses']);
        $this->assertStringContainsString('Kucica B', $rows[0]['houses']);
        $this->assertSame('150.00', $rows[0]['price']);
    }
}
