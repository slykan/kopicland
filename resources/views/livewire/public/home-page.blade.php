<div>
    <section class="relative flex min-h-[70vh] items-center justify-center bg-brand-800 text-white">
        <div class="absolute inset-0 bg-gradient-to-t from-brand-950/70 via-brand-900/30 to-transparent"></div>
        <div class="relative mx-auto max-w-3xl px-4 py-24 text-center">
            <h1 class="text-4xl font-semibold tracking-tight sm:text-5xl">{{ config('site.name') }}</h1>
            <p class="mt-4 text-lg text-brand-100">Marinci, Hrvatska</p>
        </div>
    </section>

    <section class="mx-auto -mt-12 max-w-5xl px-4 sm:px-6">
        <livewire:public.availability-search />
    </section>

    @if ($featuredHouses->isNotEmpty())
        <section class="mx-auto max-w-6xl px-4 py-20 sm:px-6">
            <h2 class="text-2xl font-semibold text-brand-900">{{ __('site.nav.houses') }}</h2>
            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($featuredHouses as $house)
                    <x-house-card :house="$house" />
                @endforeach
            </div>
        </section>
    @endif
</div>
