<?php

namespace App\Livewire\Public;

use App\Models\Amenity;
use App\Models\House;
use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        $featuredHouses = House::query()
            ->where('status', 'published')
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->with('photos')
            ->limit(6)
            ->get();

        $amenities = Amenity::query()->orderBy('sort_order')->get();

        return view('livewire.public.home-page', [
            'featuredHouses' => $featuredHouses,
            'amenities' => $amenities,
        ]);
    }
}
