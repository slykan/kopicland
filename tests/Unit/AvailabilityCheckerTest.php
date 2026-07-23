<?php

namespace Tests\Unit;

use App\Models\House;
use App\Models\Reservation;
use App\Services\AvailabilityChecker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AvailabilityCheckerTest extends TestCase
{
    use RefreshDatabase;

    private AvailabilityChecker $checker;

    private House $house;

    protected function setUp(): void
    {
        parent::setUp();

        $this->checker = new AvailabilityChecker;
        $this->house = House::create([
            'slug' => 'test-house',
            'name' => ['hr' => 'Test kućica'],
            'base_price_per_night' => 50,
        ]);
    }

    public function test_house_is_available_when_no_reservations_exist(): void
    {
        $this->assertTrue($this->checker->isAvailable($this->house->id, '2026-08-01', '2026-08-05'));
    }

    public function test_overlapping_confirmed_reservation_blocks_availability(): void
    {
        Reservation::create([
            'house_id' => $this->house->id,
            'check_in' => '2026-08-01',
            'check_out' => '2026-08-05',
            'status' => 'confirmed',
        ]);

        $this->assertFalse($this->checker->isAvailable($this->house->id, '2026-08-03', '2026-08-07'));
        $this->assertFalse($this->checker->isAvailable($this->house->id, '2026-07-30', '2026-08-02'));
        $this->assertFalse($this->checker->isAvailable($this->house->id, '2026-08-02', '2026-08-03'));
    }

    public function test_back_to_back_reservations_do_not_overlap(): void
    {
        Reservation::create([
            'house_id' => $this->house->id,
            'check_in' => '2026-08-01',
            'check_out' => '2026-08-05',
            'status' => 'confirmed',
        ]);

        $this->assertTrue($this->checker->isAvailable($this->house->id, '2026-08-05', '2026-08-10'));
        $this->assertTrue($this->checker->isAvailable($this->house->id, '2026-07-25', '2026-08-01'));
    }

    public function test_rejected_and_cancelled_reservations_do_not_block(): void
    {
        Reservation::create([
            'house_id' => $this->house->id,
            'check_in' => '2026-08-01',
            'check_out' => '2026-08-05',
            'status' => 'rejected',
        ]);

        Reservation::create([
            'house_id' => $this->house->id,
            'check_in' => '2026-08-01',
            'check_out' => '2026-08-05',
            'status' => 'cancelled',
        ]);

        $this->assertTrue($this->checker->isAvailable($this->house->id, '2026-08-01', '2026-08-05'));
    }

    public function test_hold_and_blocked_statuses_do_block(): void
    {
        Reservation::create([
            'house_id' => $this->house->id,
            'check_in' => '2026-08-01',
            'check_out' => '2026-08-05',
            'status' => 'hold',
        ]);

        $this->assertFalse($this->checker->isAvailable($this->house->id, '2026-08-02', '2026-08-03'));
    }

    public function test_excluding_a_reservation_id_allows_editing_it_without_self_conflict(): void
    {
        $reservation = Reservation::create([
            'house_id' => $this->house->id,
            'check_in' => '2026-08-01',
            'check_out' => '2026-08-05',
            'status' => 'confirmed',
        ]);

        $this->assertFalse($this->checker->isAvailable($this->house->id, '2026-08-01', '2026-08-05'));
        $this->assertTrue($this->checker->isAvailable($this->house->id, '2026-08-01', '2026-08-05', $reservation->id));
    }

    public function test_different_house_is_unaffected(): void
    {
        $otherHouse = House::create([
            'slug' => 'other-house',
            'name' => ['hr' => 'Druga kućica'],
            'base_price_per_night' => 60,
        ]);

        Reservation::create([
            'house_id' => $this->house->id,
            'check_in' => '2026-08-01',
            'check_out' => '2026-08-05',
            'status' => 'confirmed',
        ]);

        $this->assertTrue($this->checker->isAvailable($otherHouse->id, '2026-08-01', '2026-08-05'));
    }
}
