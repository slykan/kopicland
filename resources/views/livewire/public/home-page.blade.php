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

    <section class="w-full bg-brand-50 px-4 py-16 text-center sm:px-6">
        <h2 class="font-display text-3xl font-semibold text-brand-900 sm:text-4xl">{{ __('site.pages.about_heading') }}</h2>
        <p class="mx-auto mt-4 max-w-5xl text-brand-600">{{ __('site.pages.about_intro') }}</p>
        <p class="mx-auto mt-3 max-w-5xl text-brand-600">{{ __('site.pages.about_body')[0] }}</p>

        <p class="font-display mx-auto mt-8 max-w-3xl text-xl font-semibold text-brand-800">{{ __('site.pages.events_highlight') }}</p>

        <a href="{{ route('pages.contact', ['locale' => app()->getLocale()]) }}" class="mt-6 inline-block rounded-full bg-brand-600 px-6 py-3 text-sm font-medium text-white hover:bg-brand-700">
            {{ __('site.nav.contact') }}
        </a>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        <h2 class="font-display px-4 text-center text-3xl font-semibold text-brand-900 sm:text-4xl">{{ __('site.nav.video') }}</h2>
        <p class="mt-2 px-4 text-center text-brand-600">{{ __('site.nav.video_subtitle') }}</p>

        <div class="mt-8 grid grid-cols-2 gap-2 sm:grid-cols-4 sm:gap-3">
            @foreach (['mosaic-1', 'mosaic-2', 'mosaic-3', 'mosaic-4'] as $clip)
                <div class="aspect-[9/16] overflow-hidden rounded-2xl bg-brand-950 shadow-sm">
                    <video class="h-full w-full object-cover" autoplay muted loop playsinline preload="metadata" src="{{ asset('videos/'.$clip.'.mp4') }}"></video>
                </div>
            @endforeach
        </div>
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
        class="mx-auto max-w-6xl px-4 py-8 sm:px-6"
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

    @if ($amenities->isNotEmpty())
        <section class="w-full bg-brand-50 py-16">
            <h2 class="font-display px-4 text-center text-3xl font-semibold text-brand-900 sm:text-4xl">{{ __('site.nav.features') }}</h2>
            <p class="mt-2 px-4 text-center text-brand-600">{{ __('site.nav.features_subtitle') }}</p>

            <div class="mx-auto mt-10 grid max-w-7xl grid-cols-3 gap-x-4 gap-y-10 px-4 sm:grid-cols-5 sm:px-6 lg:flex lg:flex-nowrap lg:justify-between lg:gap-x-2">
                @foreach ($amenities as $amenity)
                    <div class="group flex flex-col items-center gap-3 text-center lg:flex-1 lg:px-1">
                        <span class="flex h-20 w-20 shrink-0 items-center justify-center rounded-full border border-brand-200 bg-white text-brand-600 transition-all duration-300 ease-out group-hover:-rotate-12 group-hover:scale-110 group-hover:border-brand-500 group-hover:bg-brand-600 group-hover:text-white group-hover:shadow-lg">
                            <x-dynamic-component :component="'tabler-'.($amenity->icon ?: 'circle')" class="h-9 w-9 transition-transform duration-300 group-hover:scale-110" />
                        </span>
                        <span class="text-sm font-medium text-brand-700 transition-colors duration-300 group-hover:text-brand-900">{{ $amenity->getTranslation('name', app()->getLocale()) }}</span>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

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
        <p class="mt-2 px-4 text-center text-brand-600">{{ __('site.nav.gallery_subtitle') }}</p>

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

    @if ($articles->isNotEmpty())
        <section
            class="mx-auto max-w-6xl px-4 py-12 sm:px-6"
            x-data="{
                next() { this.$refs.scroller.scrollBy({ left: this.$refs.scroller.clientWidth, behavior: 'smooth' }) },
                prev() { this.$refs.scroller.scrollBy({ left: -this.$refs.scroller.clientWidth, behavior: 'smooth' }) },
            }"
        >
            <h2 class="font-display text-center text-3xl font-semibold text-brand-900 sm:text-4xl">{{ __('site.nav.explore') }}</h2>
            <p class="mt-2 text-center text-brand-600">{{ __('site.nav.explore_subtitle') }}</p>

            <div class="relative mt-8">
                <div x-ref="scroller" class="flex gap-4 overflow-x-auto pb-4" style="scroll-snap-type: x mandatory;">
                    @foreach ($articles as $article)
                        <a
                            href="{{ route('articles.index', ['locale' => app()->getLocale()]) }}#{{ $article->slug }}"
                            class="group block w-[85%] shrink-0 overflow-hidden rounded-2xl border border-brand-100 bg-white shadow-sm transition hover:shadow-md sm:w-[calc(50%-0.5rem)] lg:w-[calc(25%-0.75rem)]"
                            style="scroll-snap-align: start;"
                        >
                            <div class="aspect-[1/1] overflow-hidden bg-brand-100">
                                <img src="{{ Storage::url($article->image_path) }}" alt="{{ $article->getTranslation('title', app()->getLocale(), useFallbackLocale: true) }}" class="h-full w-full object-cover transition group-hover:scale-105">
                            </div>
                            <div class="p-4">
                                <h3 class="text-sm font-semibold text-brand-900">{{ $article->getTranslation('title', app()->getLocale(), useFallbackLocale: true) }}</h3>
                                <p class="mt-1 line-clamp-2 text-xs text-brand-600">{{ $article->getTranslation('excerpt', app()->getLocale(), useFallbackLocale: true) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <button
                    @click="prev()"
                    type="button"
                    aria-label="Previous"
                    class="absolute -left-4 top-[38%] hidden -translate-y-1/2 rounded-full bg-white p-2 text-brand-700 shadow-md ring-1 ring-brand-100 hover:bg-brand-50 lg:flex"
                >
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <button
                    @click="next()"
                    type="button"
                    aria-label="Next"
                    class="absolute -right-4 top-[38%] hidden -translate-y-1/2 rounded-full bg-white p-2 text-brand-700 shadow-md ring-1 ring-brand-100 hover:bg-brand-50 lg:flex"
                >
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path d="M9 18l6-6-6-6"/></svg>
                </button>
            </div>
        </section>
    @endif

    @php $contact = config('site.contact'); @endphp
    <section class="w-full pt-12">
        <h2 class="font-display px-4 text-center text-3xl font-semibold text-brand-900 sm:text-4xl">{{ __('site.pages.find_us_heading') }}</h2>
        <p class="mt-2 px-4 text-center text-brand-600">{{ $contact['address'] }}</p>

        <div class="mt-8 h-[450px] w-full lg:h-[585px]">
            <iframe
                class="h-full w-full"
                loading="lazy"
                src="https://maps.google.com/maps?q={{ $contact['lat'] }},{{ $contact['lng'] }}&z=11&output=embed"
            ></iframe>
        </div>
    </section>
</div>
