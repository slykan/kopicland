@php $locale = app()->getLocale(); @endphp
<div class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
    @if ($house->photos->isNotEmpty())
        <div class="grid grid-cols-2 gap-2 overflow-hidden rounded-2xl sm:grid-cols-4 sm:grid-rows-2">
            @foreach ($house->photos->take(5) as $i => $photo)
                <div class="{{ $i === 0 ? 'col-span-2 row-span-2' : '' }} aspect-square overflow-hidden bg-brand-100">
                    <img src="{{ Storage::url($photo->path) }}" alt="{{ $photo->getTranslation('alt_text', $locale, useFallbackLocale: true) }}" class="h-full w-full object-cover">
                </div>
            @endforeach
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
            <div class="sticky top-6">
                <livewire:public.booking-form :house="$house" :key="$house->id" />
            </div>
        </div>
    </div>
</div>
