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

        $seoTitle = $this->house->getTranslation('seo_title', $locale, useFallbackLocale: true)
            ?: $this->house->getTranslation('name', $locale);

        $seoDescription = $this->house->getTranslation('seo_description', $locale, useFallbackLocale: true)
            ?: $this->house->getTranslation('short_description', $locale, useFallbackLocale: true);

        return view('livewire.public.house-detail-page')
            ->title($seoTitle.' — '.config('site.name'))
            ->layoutData(['description' => $seoDescription]);
    }
}
