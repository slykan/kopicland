@php
    $locale = app()->getLocale();
    $contact = config('site.contact');
@endphp
<footer class="border-t border-brand-100 bg-brand-50">
    <div class="mx-auto grid max-w-6xl gap-8 px-4 py-12 sm:px-6 md:grid-cols-3">
        <div>
            <p class="text-lg font-semibold text-brand-800">{{ config('site.name') }}</p>
            <p class="mt-2 text-sm text-brand-600">{{ $contact['address'] }}</p>

            <div class="mt-4 flex items-center gap-3">
                <a href="https://www.facebook.com/kopicland/" target="_blank" rel="noopener" aria-label="Facebook" class="text-brand-500 hover:text-brand-800">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14C17.17 2.1 15.95 2 14.66 2 11.98 2 10 3.66 10 6.7v2.8H7v4h3V22h4v-8.5Z"/></svg>
                </a>
                <a href="https://www.instagram.com/kopicland/" target="_blank" rel="noopener" aria-label="Instagram" class="text-brand-500 hover:text-brand-800">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg>
                </a>
                <a href="https://www.google.hr/maps/place/Kopi%C4%87land/@45.3274029,18.8829071,17z/data=!4m9!3m8!1s0x475c8dc46c0f72a5:0xf8f77d8f20f6b993!5m2!4m1!1i2!8m2!3d45.3274029!4d18.885482!16s%2Fg%2F11q25t4h_m" target="_blank" rel="noopener" aria-label="Google Maps" class="text-brand-500 hover:text-brand-800">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path d="M12 2C7.6 2 4 5.6 4 10c0 5.4 7 11.5 7.3 11.8.4.3 1 .3 1.4 0C13 21.5 20 15.4 20 10c0-4.4-3.6-8-8-8Zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/></svg>
                </a>
                <a href="https://www.tripadvisor.com/Restaurant_Review-g1026898-d27740770-Reviews-Kopicland-Vinkovci_Vukovar_Syrmia_County_Slavonia.html" target="_blank" rel="noopener" aria-label="TripAdvisor" class="text-brand-500 hover:text-brand-800">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-5 w-5"><circle cx="12" cy="12" r="10"/><circle cx="8.5" cy="12" r="2.5"/><circle cx="15.5" cy="12" r="2.5"/><path d="M9.5 9.5 12 7l2.5 2.5"/></svg>
                </a>
            </div>
        </div>

        <div class="text-sm text-brand-600">
            <p><a href="mailto:{{ $contact['email'] }}" class="hover:text-brand-800">{{ $contact['email'] }}</a></p>
            <p class="mt-1"><a href="tel:{{ $contact['phone'] }}" class="hover:text-brand-800">{{ $contact['phone'] }}</a></p>
        </div>

        <div class="text-sm text-brand-600">
            <p class="font-semibold text-brand-800">{{ __('site.footer.legal') }}</p>
            <ul class="mt-2 space-y-1">
                <li><a href="{{ route('pages.legal', ['locale' => $locale]) }}#booking-rules" class="hover:text-brand-800">{{ __('site.footer.booking_rules') }}</a></li>
                <li><a href="{{ route('pages.legal', ['locale' => $locale]) }}#terms" class="hover:text-brand-800">{{ __('site.footer.terms') }}</a></li>
                <li><a href="{{ route('pages.legal', ['locale' => $locale]) }}#privacy" class="hover:text-brand-800">{{ __('site.footer.privacy') }}</a></li>
                <li><a href="{{ route('pages.legal', ['locale' => $locale]) }}#cookies" class="hover:text-brand-800">{{ __('site.footer.cookies') }}</a></li>
            </ul>
        </div>
    </div>

    <div class="border-t border-brand-100 py-8 text-center">
        <p class="font-display text-lg font-semibold text-brand-800">{{ __('site.footer.payments_title') }}</p>
        <div class="mx-auto mt-4 flex max-w-2xl flex-wrap items-start justify-center gap-x-8 gap-y-4">
            @foreach ([
                ['icon' => 'cash', 'label' => __('site.footer.payments.cash')],
                ['icon' => 'nfc', 'label' => __('site.footer.payments.contactless')],
                ['icon' => 'brand-mastercard', 'label' => __('site.footer.payments.mastercard')],
                ['icon' => 'brand-visa', 'label' => __('site.footer.payments.visa')],
                ['icon' => 'credit-card', 'label' => __('site.footer.payments.debit')],
                ['icon' => 'credit-card', 'label' => __('site.footer.payments.diners')],
                ['icon' => 'credit-card', 'label' => __('site.footer.payments.maestro')],
            ] as $payment)
                <div class="flex w-16 flex-col items-center gap-1.5 text-xs text-brand-600">
                    <x-dynamic-component :component="'tabler-'.$payment['icon']" class="h-7 w-7 text-brand-500" />
                    <span>{{ $payment['label'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="border-t border-brand-100 py-4 text-center text-xs text-brand-500">
        &copy; {{ now()->year }} {{ config('site.name') }}. {{ __('site.footer.rights') }}
    </div>
</footer>
