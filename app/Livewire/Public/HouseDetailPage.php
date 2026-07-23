<?php

namespace App\Livewire\Public;

use App\Models\House;
use Livewire\Component;

class HouseDetailPage extends Component
{
    public House $house;

    public function mount(House $house): void
    {
        $house->load(['photos', 'amenities']);

        $this->house = $house;
    }

    public function render()
    {
        $locale = app()->getLocale();

        return view('livewire.public.house-detail-page')
            ->title($this->house->getTranslation('name', $locale).' — '.config('site.name'))
            ->layoutData(['description' => $this->house->getTranslation('short_description', $locale, useFallbackLocale: true)]);
    }
}
