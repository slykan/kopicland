<x-layouts.app :title="__('site.pages.about_title').' — '.config('site.name')">
    <div class="mx-auto max-w-3xl px-4 py-16 text-center sm:px-6">
        <h1 class="text-3xl font-semibold text-brand-900">{{ __('site.pages.about_title') }}</h1>

        <p class="mx-auto mt-6 max-w-2xl text-brand-600">{{ __('site.pages.about_intro') }}</p>

        <h2 class="mt-10 text-xl font-semibold text-brand-800">{{ __('site.pages.about_heading') }}</h2>

        <div class="mx-auto mt-4 max-w-2xl space-y-4 text-brand-600">
            @foreach (__('site.pages.about_body') as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>
    </div>

    @php
        $stories = [
            ['key' => 'sports', 'image' => 'sports.jpg'],
            ['key' => 'indoor', 'image' => 'indoor.jpg'],
            ['key' => 'outdoor', 'image' => 'outdoor.jpg'],
            ['key' => 'sustainable', 'image' => 'sustainable.jpg'],
            ['key' => 'events', 'image' => 'events.jpg'],
            ['key' => 'peka', 'image' => 'peka.jpg'],
        ];
    @endphp

    <div class="mx-auto max-w-5xl space-y-16 px-4 pb-20 sm:px-6">
        @foreach ($stories as $index => $story)
            <div class="grid items-center gap-8 md:grid-cols-2">
                <div class="overflow-hidden rounded-2xl shadow-sm {{ $index % 2 === 1 ? 'md:order-2' : '' }}">
                    <img src="{{ asset('images/about/'.$story['image']) }}" alt="{{ __('site.pages.about_stories.'.$story['key'].'.title') }}" class="h-72 w-full object-cover">
                </div>
                <div>
                    <h3 class="font-display text-2xl font-semibold text-brand-900">{{ __('site.pages.about_stories.'.$story['key'].'.title') }}</h3>
                    <div class="mt-4 space-y-3 text-brand-600">
                        @php $body = __('site.pages.about_stories.'.$story['key'].'.body'); @endphp
                        @foreach ((array) $body as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-layouts.app>
