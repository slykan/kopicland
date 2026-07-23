@php
    $locale = app()->getLocale();
@endphp
<header class="border-b border-brand-100">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
        <a href="{{ route('home', ['locale' => $locale]) }}" class="text-xl font-semibold tracking-tight text-brand-800">
            {{ config('site.name') }}
        </a>

        <nav class="hidden items-center gap-6 text-sm font-medium text-brand-700 md:flex">
            <a href="{{ route('home', ['locale' => $locale]) }}" class="hover:text-brand-500">{{ __('site.nav.home') }}</a>
            <a href="{{ route('houses.index', ['locale' => $locale]) }}" class="hover:text-brand-500">{{ __('site.nav.houses') }}</a>
            <a href="{{ route('pages.about', ['locale' => $locale]) }}" class="hover:text-brand-500">{{ __('site.nav.about') }}</a>
            <a href="{{ route('pages.location', ['locale' => $locale]) }}" class="hover:text-brand-500">{{ __('site.nav.location') }}</a>
            <a href="{{ route('pages.faq', ['locale' => $locale]) }}" class="hover:text-brand-500">{{ __('site.nav.faq') }}</a>
            <a href="{{ route('pages.contact', ['locale' => $locale]) }}" class="hover:text-brand-500">{{ __('site.nav.contact') }}</a>
        </nav>

        <div class="flex items-center gap-3">
            <div class="flex items-center gap-1 text-sm">
                @foreach (config('site.locales') as $code => $label)
                    <a
                        href="{{ request()->route() ? route(request()->route()->getName(), array_merge(request()->route()->parameters(), ['locale' => $code])) : route('home', ['locale' => $code]) }}"
                        class="rounded px-2 py-1 uppercase {{ $code === $locale ? 'bg-brand-100 font-semibold text-brand-800' : 'text-brand-500 hover:bg-brand-50' }}"
                    >{{ $code }}</a>
                @endforeach
            </div>
            <a href="{{ route('houses.index', ['locale' => $locale]) }}" class="rounded-full bg-brand-600 px-4 py-2 text-sm font-medium text-white hover:bg-brand-700">
                {{ __('site.common.book_now') }}
            </a>
        </div>
    </div>
</header>
