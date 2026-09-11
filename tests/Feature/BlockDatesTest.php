<?php

namespace Tests\Feature;

use App\Filament\Pages\BlockDatesPage;
use App\Models\House;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class BlockDatesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_load_the_block_dates_page(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(BlockDatesPage::class)->assertSuccessful();
    }

    public function test_blocking_creates_a_blocked_reservation_per_selected_house(): void
    {
        $this->actingAs(User::factory()->create());

        $houseA = House::create(['slug' => 'a', 'name' => ['hr' => 'Kucica A'], 'base_price_per_night' => 50]);
        $houseB = House::create(['slug' => 'b', 'name' => ['hr' => 'Kucica B'], 'base_price_per_night' => 60]);

        Livewire::test(BlockDatesPage::class)
            ->fillForm([
                'house_ids' => [$houseA->id, $houseB->id],
                'check_in' => '2026-12-01',
                'check_out' => '2026-12-05',
                'internal_note' => 'Renovation',
            ])
            ->call('block');

        $this->assertDatabaseCount('reservations', 2);
        $this->assertDatabaseHas('reservations', [
            'house_id' => $houseA->id,
            'status' => 'blocked',
            'guest_id' => null,
            'internal_note' => 'Renovation',
        ]);
        $this->assertDatabaseHas('reservations', [
            'house_id' => $houseB->id,
            'status' => 'blocked',
        ]);
    }

    public function test_blocking_skips_a_house_that_already_has_an_overlapping_reservation(): void
    {
        $this->actingAs(User::factory()->create());

        $houseA = House::create(['slug' => 'a', 'name' => ['hr' => 'Kucica A'], 'base_price_per_night' => 50]);
        $houseB = House::create(['slug' => 'b', 'name' => ['hr' => 'Kucica B'], 'base_price_per_night' => 60]);

        Reservation::create([
            'house_id' => $houseA->id,
            'check_in' => '2026-12-02',
            'check_out' => '2026-12-03',
            'status' => 'confirmed',
        ]);

        Livewire::test(BlockDatesPage::class)
            ->fillForm([
                'house_ids' => [$houseA->id, $houseB->id],
                'check_in' => '2026-12-01',
                'check_out' => '2026-12-05',
            ])
            ->call('block');

        // House A already had a confirmed reservation → only House B gets a new blocked entry.
        $this->assertDatabaseCount('reservations', 2);
        $this->assertDatabaseHas('reservations', [
            'house_id' => $houseB->id,
            'status' => 'blocked',
        ]);
    }

    public function test_recent_blocks_groups_a_multi_house_batch_into_one_row(): void
    {
        $this->actingAs(User::factory()->create());

        $houseA = House::create(['slug' => 'a', 'name' => ['hr' => 'Kucica A'], 'base_price_per_night' => 50]);
        $houseB = House::create(['slug' => 'b', 'name' => ['hr' => 'Kucica B'], 'base_price_per_night' => 60]);

        $component = Livewire::test(BlockDatesPage::class)
            ->fillForm([
                'house_ids' => [$houseA->id, $houseB->id],
                'check_in' => '2026-12-01',
                'check_out' => '2026-12-05',
                'internal_note' => 'Renovation',
            ])
            ->call('block');

        $rows = $component->instance()->recentBlocks();

        $this->assertCount(1, $rows);
        $this->assertStringContainsString('Kucica A', $rows[0]['houses']);
        $this->assertStringContainsString('Kucica B', $rows[0]['houses']);
        $this->assertSame('Renovation', $rows[0]['note']);
    }
}
