@php
    $locale = app()->getLocale();
    $contact = config('site.contact');
@endphp
<footer class="mt-24 border-t border-brand-100 bg-brand-50">
    <div class="mx-auto grid max-w-6xl gap-8 px-4 py-12 sm:px-6 md:grid-cols-3">
        <div>
            <p class="text-lg font-semibold text-brand-800">{{ config('site.name') }}</p>
            <p class="mt-2 text-sm text-brand-600">{{ $contact['address'] }}</p>
        </div>

        <div class="text-sm text-brand-600">
            <p><a href="mailto:{{ $contact['email'] }}" class="hover:text-brand-800">{{ $contact['email'] }}</a></p>
            <p class="mt-1"><a href="tel:{{ $contact['phone'] }}" class="hover:text-brand-800">{{ $contact['phone'] }}</a></p>
        </div>

        <div class="text-sm text-brand-600">
            <p class="font-semibold text-brand-800">{{ __('site.footer.legal') }}</p>
            <ul class="mt-2 space-y-1">
                <li><a href="{{ route('pages.booking-rules', ['locale' => $locale]) }}" class="hover:text-brand-800">{{ __('site.footer.booking_rules') }}</a></li>
                <li><a href="{{ route('pages.terms', ['locale' => $locale]) }}" class="hover:text-brand-800">{{ __('site.footer.terms') }}</a></li>
                <li><a href="{{ route('pages.privacy', ['locale' => $locale]) }}" class="hover:text-brand-800">{{ __('site.footer.privacy') }}</a></li>
                <li><a href="{{ route('pages.cookies', ['locale' => $locale]) }}" class="hover:text-brand-800">{{ __('site.footer.cookies') }}</a></li>
            </ul>
        </div>
    </div>

    <div class="border-t border-brand-100 py-4 text-center text-xs text-brand-500">
        &copy; {{ now()->year }} {{ config('site.name') }}. {{ __('site.footer.rights') }}
    </div>
</footer>
