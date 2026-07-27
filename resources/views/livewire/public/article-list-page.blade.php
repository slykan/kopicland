@php $locale = app()->getLocale(); @endphp
<div class="mx-auto max-w-4xl px-4 py-16 sm:px-6">
    <h1 class="text-3xl font-semibold text-brand-900">{{ __('site.pages.explore_heading') }}</h1>
    <p class="mt-2 text-brand-600">{{ __('site.nav.explore_subtitle') }}</p>

    <div class="mt-8 space-y-4">
        @foreach ($articles as $article)
            <div
                id="{{ $article->slug }}"
                x-data="{ open: window.location.hash === '#{{ $article->slug }}' }"
                x-init="if (open) { $nextTick(() => $el.scrollIntoView({ behavior: 'smooth', block: 'start' })) }"
                class="scroll-mt-24 overflow-hidden rounded-2xl border border-brand-100 bg-white shadow-sm"
            >
                <div class="grid gap-0 sm:grid-cols-[280px_1fr]">
                    <div class="aspect-[4/3] overflow-hidden bg-brand-100 sm:aspect-auto">
                        <img src="{{ Storage::url($article->image_path) }}" alt="{{ $article->getTranslation('title', $locale, useFallbackLocale: true) }}" class="h-full w-full object-cover">
                    </div>

                    <div class="p-5 sm:p-6">
                        <h2 class="text-lg font-semibold text-brand-900">{{ $article->getTranslation('title', $locale, useFallbackLocale: true) }}</h2>
                        <p class="mt-2 text-sm text-brand-600">{{ $article->getTranslation('excerpt', $locale, useFallbackLocale: true) }}</p>

                        <button type="button" @click="open = !open" class="mt-3 inline-flex items-center gap-1.5 text-sm font-medium text-brand-700 hover:text-brand-900">
                            <span x-show="!open" class="flex h-5 w-5 items-center justify-center rounded-full border border-brand-300 text-xs leading-none">+</span>
                            <span x-show="open" style="display: none;" class="flex h-5 w-5 items-center justify-center rounded-full border border-brand-300 text-xs leading-none">&minus;</span>
                            <span x-text="open ? '{{ __('site.common.show_less') }}' : '{{ __('site.common.read_more') }}'"></span>
                        </button>

                        <div x-show="open" x-transition style="display: none;" class="prose prose-brand mt-4 max-w-none text-sm">
                            {!! $article->getTranslation('body', $locale, useFallbackLocale: true) !!}

                            @if ($article->photo_credit)
                                <p class="mt-4 text-xs text-brand-400">
                                    Photo:
                                    @if ($article->photo_source_url)
                                        <a href="{{ $article->photo_source_url }}" target="_blank" rel="noopener nofollow" class="underline">{{ $article->photo_credit }}</a>
                                    @else
                                        {{ $article->photo_credit }}
                                    @endif
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
