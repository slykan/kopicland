<?php

namespace App\Livewire\Public;

use App\Models\House;
use App\Services\AvailabilityChecker;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class HouseListPage extends Component
{
    public function render(AvailabilityChecker $availabilityChecker)
    {
        $checkIn = Request::query('check_in');
        $checkOut = Request::query('check_out');
        $adults = (int) Request::query('adults', 0);
        $children = (int) Request::query('children', 0);

        $houses = House::query()
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->with('photos')
            ->get();

        if ($checkIn && $checkOut) {
            $houses = $houses->filter(fn (House $house) => $availabilityChecker->isAvailable($house->id, $checkIn, $checkOut));
        }

        if ($adults + $children > 0) {
            $houses = $houses->filter(fn (House $house) => ($house->capacity_adults + $house->capacity_children) >= ($adults + $children));
        }

        return view('livewire.public.house-list-page', [
            'houses' => $houses,
        ])->title(__('site.nav.houses').' — '.config('site.name'));
    }
}
