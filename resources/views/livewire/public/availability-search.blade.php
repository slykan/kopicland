<form wire:submit="search" class="grid gap-3 rounded-2xl bg-white p-4 text-brand-900 shadow-lg sm:grid-cols-2 lg:grid-cols-6 lg:items-end">
    <div class="lg:col-span-2" x-data="datePicker({ minDate: 'today' })">
        <label class="block text-xs font-medium text-brand-600">{{ __('site.common.check_in') }}</label>
        <input type="text" x-ref="input" placeholder="dd.mm.gggg" wire:model="checkIn" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900 focus:border-brand-500 focus:ring-brand-500">
        @error('checkIn') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="lg:col-span-2" x-data="datePicker({ minDate: 'today' })">
        <label class="block text-xs font-medium text-brand-600">{{ __('site.common.check_out') }}</label>
        <input type="text" x-ref="input" placeholder="dd.mm.gggg" wire:model="checkOut" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900 focus:border-brand-500 focus:ring-brand-500">
        @error('checkOut') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-xs font-medium text-brand-600">{{ __('site.common.adults') }}</label>
        <input type="number" min="1" wire:model="adults" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900 focus:border-brand-500 focus:ring-brand-500">
    </div>

    <div>
        <label class="block text-xs font-medium text-brand-600">{{ __('site.common.children') }}</label>
        <input type="number" min="0" wire:model="children" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900 focus:border-brand-500 focus:ring-brand-500">
    </div>

    <div class="sm:col-span-2 lg:col-span-6">
        <button type="submit" class="w-full rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-700">
            {{ __('site.common.check_availability') }}
        </button>
    </div>
</form>
