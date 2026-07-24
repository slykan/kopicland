<div>
    <section
        class="relative flex min-h-[50vh] flex-col items-center justify-center overflow-hidden bg-brand-800 pb-16 text-white"
        x-data="{
            images: [
                '{{ asset('images/hero-banner-3.jpg') }}',
                '{{ asset('images/hero-banner-4.jpg') }}',
                '{{ asset('images/hero-banner.jpg') }}',
                '{{ asset('images/hero-banner-2.jpg') }}',
            ],
            active: 0,
            init() {
                setInterval(() => { this.active = (this.active + 1) % this.images.length }, 6000)
            },
        }"
    >
        <template x-for="(image, index) in images" :key="index">
            <div
                class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 ease-in-out"
                :style="`background-image: url('${image}')`"
                :class="active === index ? 'opacity-100' : 'opacity-0'"
            ></div>
        </template>
        <div class="absolute inset-0 bg-gradient-to-t from-brand-950/80 via-brand-900/50 to-brand-950/20"></div>
        <div class="relative mx-auto max-w-3xl px-4 py-24 text-center">
            <h1 class="text-4xl font-semibold tracking-tight sm:text-5xl">{{ config('site.name') }}</h1>
            <p class="mt-4 text-lg text-brand-100">Marinci, Hrvatska</p>
        </div>

        <div class="relative mx-auto -mb-16 w-full max-w-5xl px-4 sm:px-6">
            <livewire:public.availability-search />
        </div>
    </section>

    <div class="h-16"></div>

    <section class="mx-auto max-w-3xl px-4 py-12 text-center sm:px-6">
        <h2 class="font-display text-3xl font-semibold text-brand-900 sm:text-4xl">{{ __('site.pages.about_heading') }}</h2>
        <p class="mx-auto mt-4 max-w-2xl text-brand-600">{{ __('site.pages.about_intro') }}</p>
        <p class="mx-auto mt-3 max-w-2xl text-brand-600">{{ __('site.pages.about_body')[0] }}</p>
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
