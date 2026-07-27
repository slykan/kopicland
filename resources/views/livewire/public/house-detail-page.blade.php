@php
    $locale = app()->getLocale();
    $galleryPhotos = $house->photos->map(fn ($photo) => [
        'url' => Storage::url($photo->path),
        'alt' => $photo->getTranslation('alt_text', $locale, useFallbackLocale: true),
    ])->values();
@endphp
<div class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
    @if ($galleryPhotos->isNotEmpty())
        <div x-data="{ open: false, index: 0, photos: {{ Illuminate\Support\Js::from($galleryPhotos) }} }">
            <div class="grid grid-cols-2 gap-2 overflow-hidden rounded-2xl sm:grid-cols-4 sm:grid-rows-2">
                @foreach ($galleryPhotos->take(5) as $i => $photo)
                    <button type="button" @click="open = true; index = {{ $i }}" class="{{ $i === 0 ? 'col-span-2 row-span-2' : '' }} group relative block aspect-square cursor-zoom-in overflow-hidden bg-brand-100">
                        <img src="{{ $photo['url'] }}" alt="{{ $photo['alt'] }}" class="h-full w-full object-cover transition group-hover:scale-105">
                        <img src="{{ asset('images/logo-watermark.png') }}" alt="" class="pointer-events-none absolute left-1/2 top-1/2 h-14 w-14 -translate-x-1/2 -translate-y-1/2 object-contain drop-shadow {{ $i === 0 ? 'sm:h-24 sm:w-24' : '' }}">
                    </button>
                @endforeach
            </div>

            <div
                x-show="open"
                x-cloak
                @keydown.escape.window="open = false"
                @keydown.left.window="index = (index - 1 + photos.length) % photos.length"
                @keydown.right.window="index = (index + 1) % photos.length"
                @click.self="open = false"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4"
            >
                <button type="button" @click="open = false" class="absolute right-4 top-4 text-3xl leading-none text-white/80 hover:text-white" aria-label="Close">&times;</button>

                <button type="button" x-show="photos.length > 1" @click="index = (index - 1 + photos.length) % photos.length" class="absolute left-2 top-1/2 -translate-y-1/2 rounded-full bg-black/40 p-2 text-3xl leading-none text-white/80 hover:text-white sm:left-6" aria-label="Previous photo">&#8249;</button>

                <img :src="photos[index]?.url" :alt="photos[index]?.alt" class="max-h-[85vh] max-w-full rounded-lg object-contain" @click.stop>

                <button type="button" x-show="photos.length > 1" @click="index = (index + 1) % photos.length" class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-black/40 p-2 text-3xl leading-none text-white/80 hover:text-white sm:right-6" aria-label="Next photo">&#8250;</button>

                <div x-show="photos.length > 1" class="absolute bottom-4 left-1/2 -translate-x-1/2 text-sm text-white/70" x-text="(index + 1) + ' / ' + photos.length"></div>
            </div>
        </div>
    @endif

    <div class="mt-8 grid gap-10 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <h1 class="text-3xl font-semibold text-brand-900">{{ $house->getTranslation('name', $locale) }}</h1>

            <div class="mt-3 flex flex-wrap gap-4 text-sm text-brand-600">
                <span>{{ $house->capacity_adults + $house->capacity_children }} {{ __('site.common.guests') }}</span>
                <span>{{ $house->bedrooms }} {{ __('Bedrooms') }}</span>
                <span>{{ $house->beds }} {{ __('Beds') }}</span>
                <span>{{ $house->bathrooms }} {{ __('Bathrooms') }}</span>
                @if ($house->size_m2)
                    <span>{{ $house->size_m2 }} m²</span>
                @endif
            </div>

            @if ($house->amenities->isNotEmpty())
                <div class="mt-6">
                    <h2 class="text-lg font-semibold text-brand-900">{{ __('Amenities') }}</h2>
                    <ul class="mt-3 grid grid-cols-2 gap-2 text-sm text-brand-600 sm:grid-cols-3">
                        @foreach ($house->amenities as $amenity)
                            <li class="flex items-center gap-2">
                                <x-dynamic-component :component="'tabler-'.($amenity->icon ?: 'circle')" class="h-5 w-5 shrink-0 text-brand-500" />
                                {{ $amenity->getTranslation('name', $locale) }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="prose prose-brand mt-8 max-w-none text-brand-700">
                {!! $house->getTranslation('description', $locale, useFallbackLocale: true) !!}
            </div>

            @if ($house->house_rules)
                <div class="mt-8">
                    <h2 class="text-lg font-semibold text-brand-900">{{ __('site.footer.booking_rules') }}</h2>
                    <div class="prose prose-brand mt-3 max-w-none text-sm text-brand-600">
                        {!! $house->getTranslation('house_rules', $locale, useFallbackLocale: true) !!}
                    </div>
                </div>
            @endif
        </div>

        <div>
            <div class="sticky top-6 space-y-4">
                <div
                    class="rounded-2xl border border-brand-100 bg-white p-4 shadow-sm"
                    x-data="availabilityCalendar({ disabledRanges: {{ Illuminate\Support\Js::from($bookedRanges) }}, locale: {{ Illuminate\Support\Js::from($locale) }} })"
                >
                    <h2 class="mb-3 text-sm font-semibold text-brand-900">{{ __('site.common.availability') }}</h2>
                    <div x-ref="calendar"></div>
                </div>

                <livewire:public.booking-form :house="$house" :key="$house->id" />
            </div>
        </div>
    </div>
</div>
