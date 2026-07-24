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
</x-layouts.app>
