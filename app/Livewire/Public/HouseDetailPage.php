<?php

namespace App\Livewire\Public;

use App\Models\House;
use App\Services\AvailabilityChecker;
use Illuminate\Support\Carbon;
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
            ->layoutData(['description' => $seoDescription])
            ->with('bookedRanges', $this->bookedRanges());
    }

    private function bookedRanges(): array
    {
        return $this->house->reservations()
            ->whereIn('status', AvailabilityChecker::BLOCKING_STATUSES)
            ->where('check_out', '>=', Carbon::today())
            ->get(['check_in', 'check_out'])
            ->map(fn ($reservation) => [
                'from' => $reservation->check_in->format('Y-m-d'),
                'to' => $reservation->check_out->copy()->subDay()->format('Y-m-d'),
            ])
            ->values()
            ->all();
    }
}
