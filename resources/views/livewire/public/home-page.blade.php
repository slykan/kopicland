<div>
    <section
        class="relative flex min-h-[80vh] flex-col items-center justify-center bg-brand-800 pb-16 text-white lg:min-h-screen"
        x-data="{
            images: [
                '{{ asset('images/hero-banner-3.jpg') }}',
                '{{ asset('images/hero-banner-4.jpg') }}',
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
            <h1>
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('site.name') }}" class="mx-auto h-40 w-40 object-contain drop-shadow-lg sm:h-56 sm:w-56">
                <span class="sr-only">{{ config('site.name') }}</span>
            </h1>
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

    @php
        $slides = collect(['sports', 'indoor', 'outdoor', 'sustainable', 'events', 'peka'])->map(function ($key) {
            $body = __('site.pages.about_stories.'.$key.'.body');

            return [
                'image' => asset('images/about/'.$key.'.jpg'),
                'title' => __('site.pages.about_stories.'.$key.'.title'),
                'body' => is_array($body) ? $body[0] : $body,
            ];
        })->values()->all();
    @endphp

    <section
        class="mx-auto max-w-5xl px-4 py-8 sm:px-6"
        x-data="{
            slides: {{ Illuminate\Support\Js::from($slides) }},
            active: 0,
            next() { this.active = (this.active + 1) % this.slides.length },
            prev() { this.active = (this.active - 1 + this.slides.length) % this.slides.length },
            init() {
                setInterval(() => { if (!this.paused) this.next() }, 7000)
            },
            paused: false,
        }"
    >
        <div
            class="relative overflow-hidden rounded-2xl bg-brand-950 shadow-lg"
            @mouseenter="paused = true"
            @mouseleave="paused = false"
        >
            <template x-for="(slide, index) in slides" :key="index">
                <div
                    x-show="active === index"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    class="grid md:grid-cols-2"
                >
                    <div class="h-64 md:h-[26rem]">
                        <img :src="slide.image" :alt="slide.title" class="h-full w-full object-cover">
                    </div>
                    <div class="flex flex-col justify-center p-8 text-white sm:p-12">
                        <h3 class="font-display text-2xl font-semibold sm:text-3xl" x-text="slide.title"></h3>
                        <p class="mt-4 text-brand-100" x-text="slide.body"></p>
                    </div>
                </div>
            </template>

            <button
                @click="prev()"
                type="button"
                aria-label="Previous"
                class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-white/20 p-2 text-white hover:bg-white/30"
            >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <button
                @click="next()"
                type="button"
                aria-label="Next"
                class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-white/20 p-2 text-white hover:bg-white/30"
            >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>

        <div class="mt-4 flex justify-center gap-2">
            <template x-for="(slide, index) in slides" :key="index">
                <button
                    @click="active = index"
                    type="button"
                    aria-label="Go to slide"
                    class="h-2 rounded-full transition-all"
                    :class="active === index ? 'w-6 bg-brand-600' : 'w-2 bg-brand-200 hover:bg-brand-300'"
                ></button>
            </template>
        </div>
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

    @php
        $galleryImages = collect(range(1, 24))->map(fn ($n) => asset("images/gallery/{$n}.jpg"))->all();
    @endphp

    <section
        class="w-full py-12"
        x-data="{
            images: {{ Illuminate\Support\Js::from($galleryImages) }},
            open: false,
            active: 0,
            show(index) { this.active = index; this.open = true },
            next() { this.active = (this.active + 1) % this.images.length },
            prev() { this.active = (this.active - 1 + this.images.length) % this.images.length },
        }"
        @keydown.window.escape="open = false"
        @keydown.window.arrow-right="if (open) next()"
        @keydown.window.arrow-left="if (open) prev()"
    >
        <h2 class="font-display px-4 text-center text-3xl font-semibold text-brand-900 sm:text-4xl">{{ __('site.nav.gallery') }}</h2>

        <div class="mt-8 grid grid-cols-3 gap-0.5 sm:grid-cols-4 md:grid-cols-6">
            <template x-for="(image, index) in images" :key="index">
                <button type="button" @click="show(index)" class="group aspect-square overflow-hidden">
                    <img :src="image" :alt="`Kopić Land ${index + 1}`" loading="lazy" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">
                </button>
            </template>
        </div>

        <div
            x-show="open"
            x-transition.opacity
            @click.self="open = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4"
            style="display: none;"
        >
            <button @click="open = false" type="button" aria-label="Close" class="absolute right-4 top-4 rounded-full bg-white/10 p-2 text-white hover:bg-white/20">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-6 w-6"><path d="M6 6l12 12M18 6L6 18"/></svg>
            </button>

            <button @click="prev()" type="button" aria-label="Previous" class="absolute left-2 top-1/2 -translate-y-1/2 rounded-full bg-white/10 p-2 text-white hover:bg-white/20 sm:left-4">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-6 w-6"><path d="M15 18l-6-6 6-6"/></svg>
            </button>

            <img :src="images[active]" alt="" class="max-h-[85vh] max-w-full object-contain">

            <button @click="next()" type="button" aria-label="Next" class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-white/10 p-2 text-white hover:bg-white/20 sm:right-4">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-6 w-6"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>
    </section>
</div>
