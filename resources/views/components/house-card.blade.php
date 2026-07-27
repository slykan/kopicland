@props(['house'])
@php
    $cover = $house->photos->firstWhere('is_cover', true) ?? $house->photos->first();
    [$priceFrom, $priceTo] = $house->basePriceRange();
    preg_match('/(\d+)/', $house->getTranslation('name', app()->getLocale()), $houseNumberMatch);
    $houseNumber = $houseNumberMatch[1] ?? null;
@endphp
<a href="{{ route('houses.show', ['locale' => app()->getLocale(), 'house' => $house->slug]) }}" class="group block overflow-hidden rounded-2xl border border-brand-100 bg-white shadow-sm transition hover:shadow-md">
    <div class="relative aspect-[4/3] overflow-hidden bg-brand-100">
        @if ($cover)
            <img src="{{ Storage::url($cover->path) }}" alt="{{ $cover->getTranslation('alt_text', app()->getLocale(), useFallbackLocale: true) ?: $house->getTranslation('name', app()->getLocale()) }}" class="h-full w-full object-cover transition group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center text-brand-300">{{ config('site.name') }}</div>
        @endif

        @if ($houseNumber)
            <div class="absolute left-3 top-3 flex h-10 w-10 items-center justify-center rounded-full border border-white/40 bg-brand-900/80 font-display text-base font-semibold text-white shadow-md backdrop-blur-sm">
                {{ $houseNumber }}
            </div>
        @endif
    </div>

    <div class="p-4">
        <h3 class="text-lg font-semibold text-brand-900">{{ $house->getTranslation('name', app()->getLocale()) }}</h3>
        <p class="mt-1 line-clamp-2 text-sm text-brand-600">{{ $house->getTranslation('short_description', app()->getLocale(), useFallbackLocale: true) }}</p>

        <div class="mt-3 flex items-center justify-between">
            <span class="text-sm text-brand-500">{{ $house->capacity_adults + $house->capacity_children }} {{ __('site.common.guests') }}</span>
            <span class="text-sm font-semibold text-brand-800">
                @if ($priceFrom < $priceTo)
                    {{ __('site.common.from') }} {{ number_format($priceFrom, 0) }} € {{ __('site.common.to') }} {{ number_format($priceTo, 0) }} € {{ __('site.common.per_night') }}
                @else
                    {{ __('site.common.from') }} {{ number_format($priceFrom, 0) }} € {{ __('site.common.per_night') }}
                @endif
            </span>
        </div>
    </div>
</a>
