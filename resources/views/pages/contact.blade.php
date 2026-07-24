@php $contact = config('site.contact'); @endphp
<x-layouts.app :title="__('site.pages.contact_title').' — '.config('site.name')">
    <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
        <h1 class="text-3xl font-semibold text-brand-900">{{ __('site.pages.contact_title') }}</h1>

        <dl class="mt-6 space-y-2 text-brand-700">
            <div>
                <a href="mailto:{{ $contact['email'] }}" class="text-brand-600 hover:text-brand-800">{{ $contact['email'] }}</a>
            </div>
            <div>
                <a href="tel:{{ $contact['phone'] }}" class="text-brand-600 hover:text-brand-800">{{ $contact['phone'] }}</a>
            </div>
            <div class="text-brand-600">{{ $contact['address'] }}</div>
        </dl>

        <div class="mt-10">
            <livewire:public.contact-form />
        </div>
    </div>
</x-layouts.app>
