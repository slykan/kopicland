@php
    $contact = config('site.contact');
    $company = config('site.company');
@endphp
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

        <div class="mt-10 rounded-lg border border-brand-100 bg-brand-50 px-5 py-4">
            <h2 class="text-sm font-semibold tracking-wide text-brand-800 uppercase">{{ __('site.pages.company_info_title') }}</h2>
            <dl class="mt-2 space-y-0.5 text-sm text-brand-700">
                <div class="font-medium text-brand-900">{{ $company['name'] }}</div>
                <div>{{ $company['address'] }}</div>
                <div>{{ $company['zip_city'] }}</div>
                <div>OIB: {{ $company['oib'] }}</div>
                <div>
                    Mob: <a href="tel:{{ $company['phone'] }}" class="text-brand-600 hover:text-brand-800">{{ $company['phone'] }}</a>
                </div>
                <div class="mt-2">{{ $company['bank_name'] }}</div>
                <div>IBAN: {{ $company['iban'] }}</div>
            </dl>
        </div>

        <div class="mt-10">
            <livewire:public.contact-form />
        </div>
    </div>
</x-layouts.app>
