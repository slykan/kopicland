<?php

namespace App\Livewire\Public;

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

        return view('livewire.public.home-page', [
            'featuredHouses' => $featuredHouses,
        ]);
    }
}
