@php
    $locale = app()->getLocale();
@endphp
<header class="border-b border-brand-100 bg-brand-50" x-data="{ open: false }">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
        <a href="{{ route('home', ['locale' => $locale]) }}" class="flex items-center gap-2 text-xl font-semibold tracking-tight text-brand-800">
            <img src="{{ asset('images/logo.png') }}" alt="{{ config('site.name') }}" class="h-10 w-10 object-contain">
            <span class="hidden sm:inline">{{ config('site.name') }}</span>
        </a>

        <nav class="hidden items-center gap-6 text-sm font-medium text-brand-700 md:flex">
            <a href="{{ route('home', ['locale' => $locale]) }}" class="hover:text-brand-500">{{ __('site.nav.home') }}</a>
            <a href="{{ route('houses.index', ['locale' => $locale]) }}" class="hover:text-brand-500">{{ __('site.nav.houses') }}</a>
            <a href="{{ route('pages.about', ['locale' => $locale]) }}" class="hover:text-brand-500">{{ __('site.nav.about') }}</a>
            <a href="{{ route('pages.faq', ['locale' => $locale]) }}" class="hover:text-brand-500">{{ __('site.nav.faq') }}</a>
            <a href="{{ route('pages.contact', ['locale' => $locale]) }}" class="hover:text-brand-500">{{ __('site.nav.contact') }}</a>
        </nav>

        <div class="hidden items-center gap-3 md:flex">
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

        <button type="button" @click="open = !open" aria-label="Menu" class="text-brand-700 md:hidden">
            <svg x-show="!open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-7 w-7"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
            <svg x-show="open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-7 w-7" style="display: none;"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
        </button>
    </div>

    <div x-show="open" x-transition style="display: none;" class="border-t border-brand-100 px-4 py-4 md:hidden">
        <nav class="flex flex-col gap-1 text-sm font-medium text-brand-700">
            <a href="{{ route('home', ['locale' => $locale]) }}" class="rounded-lg px-3 py-2 hover:bg-brand-100">{{ __('site.nav.home') }}</a>
            <a href="{{ route('houses.index', ['locale' => $locale]) }}" class="rounded-lg px-3 py-2 hover:bg-brand-100">{{ __('site.nav.houses') }}</a>
            <a href="{{ route('pages.about', ['locale' => $locale]) }}" class="rounded-lg px-3 py-2 hover:bg-brand-100">{{ __('site.nav.about') }}</a>
            <a href="{{ route('pages.faq', ['locale' => $locale]) }}" class="rounded-lg px-3 py-2 hover:bg-brand-100">{{ __('site.nav.faq') }}</a>
            <a href="{{ route('pages.contact', ['locale' => $locale]) }}" class="rounded-lg px-3 py-2 hover:bg-brand-100">{{ __('site.nav.contact') }}</a>
        </nav>

        <div class="mt-4 flex items-center gap-1 border-t border-brand-100 pt-4 text-sm">
            @foreach (config('site.locales') as $code => $label)
                <a
                    href="{{ request()->route() ? route(request()->route()->getName(), array_merge(request()->route()->parameters(), ['locale' => $code])) : route('home', ['locale' => $code]) }}"
                    class="rounded px-2 py-1 uppercase {{ $code === $locale ? 'bg-brand-100 font-semibold text-brand-800' : 'text-brand-500 hover:bg-brand-100' }}"
                >{{ $code }}</a>
            @endforeach
        </div>

        <a href="{{ route('houses.index', ['locale' => $locale]) }}" class="mt-4 block rounded-full bg-brand-600 px-4 py-2 text-center text-sm font-medium text-white hover:bg-brand-700">
            {{ __('site.common.book_now') }}
        </a>
    </div>
</header>
