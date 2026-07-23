<?php

namespace Tests\Feature;

use App\Filament\Pages\ReservationsCalendarPage;
use App\Filament\Widgets\ReservationsCalendarWidget;
use App\Models\House;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ReservationsCalendarTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_load_the_calendar_page(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(ReservationsCalendarPage::class)->assertSuccessful();
    }

    public function test_calendar_widget_returns_reservations_in_range_and_respects_filters(): void
    {
        $this->actingAs(User::factory()->create());

        $houseA = House::create(['slug' => 'a', 'name' => ['hr' => 'Kucica A'], 'base_price_per_night' => 50]);
        $houseB = House::create(['slug' => 'b', 'name' => ['hr' => 'Kucica B'], 'base_price_per_night' => 60]);

        $inRange = Reservation::create([
            'house_id' => $houseA->id,
            'check_in' => '2026-11-05',
            'check_out' => '2026-11-10',
            'status' => 'confirmed',
        ]);

        $outOfRange = Reservation::create([
            'house_id' => $houseA->id,
            'check_in' => '2027-01-05',
            'check_out' => '2027-01-10',
            'status' => 'confirmed',
        ]);

        $otherHouse = Reservation::create([
            'house_id' => $houseB->id,
            'check_in' => '2026-11-06',
            'check_out' => '2026-11-08',
            'status' => 'confirmed',
        ]);

        $widget = Livewire::test(ReservationsCalendarWidget::class);

        $events = $widget->instance()->fetchEvents([
            'start' => '2026-11-01',
            'end' => '2026-11-30',
        ]);

        $ids = collect($events)->pluck('id');

        $this->assertTrue($ids->contains($inRange->id));
        $this->assertTrue($ids->contains($otherHouse->id));
        $this->assertFalse($ids->contains($outOfRange->id));

        $widget->set('houseFilter', $houseA->id);

        $filteredEvents = $widget->instance()->fetchEvents([
            'start' => '2026-11-01',
            'end' => '2026-11-30',
        ]);

        $filteredIds = collect($filteredEvents)->pluck('id');

        $this->assertTrue($filteredIds->contains($inRange->id));
        $this->assertFalse($filteredIds->contains($otherHouse->id));
    }
}
