@php $contact = config('site.contact'); @endphp
<x-layouts.app :title="__('site.pages.location_title').' — '.config('site.name')">
    <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
        <h1 class="text-3xl font-semibold text-brand-900">{{ __('site.pages.location_title') }}</h1>
        <p class="mt-4 text-brand-600">{{ $contact['address'] }}</p>

        <div class="mt-8 aspect-video overflow-hidden rounded-xl border border-brand-100">
            <iframe
                class="h-full w-full"
                loading="lazy"
                src="https://maps.google.com/maps?q={{ $contact['lat'] }},{{ $contact['lng'] }}&z=15&output=embed"
            ></iframe>
        </div>

        <p class="mt-8 text-brand-600">{{ __('site.pages.content_pending') }}</p>
    </div>
</x-layouts.app>
