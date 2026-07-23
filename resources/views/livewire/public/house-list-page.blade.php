<div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
    <h1 class="text-3xl font-semibold text-brand-900">{{ __('site.nav.houses') }}</h1>

    @if ($checkIn && $checkOut)
        <p class="mt-2 text-sm text-brand-500">{{ $checkIn }} — {{ $checkOut }}</p>
    @endif

    @if ($houses->isEmpty())
        <p class="mt-8 text-brand-600">—</p>
    @else
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($houses as $house)
                <x-house-card :house="$house" />
            @endforeach
        </div>
    @endif
</div>
