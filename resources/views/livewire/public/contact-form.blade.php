<div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-sm">
    @if ($submitted)
        <div class="py-8 text-center">
            <h3 class="text-lg font-semibold text-brand-900">{{ __('site.contact_form.sent_title') }}</h3>
            <p class="mt-2 text-sm text-brand-600">{{ __('site.contact_form.sent_body') }}</p>
        </div>
    @else
        <form wire:submit="submit" class="space-y-4">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="block text-xs font-medium text-brand-600">{{ __('site.contact_form.name') }}</label>
                    <input type="text" wire:model="name" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-brand-600">{{ __('site.contact_form.email') }}</label>
                    <input type="email" wire:model="email" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900">
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-brand-600">{{ __('site.contact_form.subject') }}</label>
                <input type="text" wire:model="subject" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900">
                @error('subject') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="block text-xs font-medium text-brand-600">{{ __('site.contact_form.participants') }}</label>
                    <input type="number" min="1" wire:model="participants" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900">
                    @error('participants') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div x-data="datePicker({ minDate: 'today' })">
                    <label class="block text-xs font-medium text-brand-600">{{ __('site.contact_form.event_date') }}</label>
                    <input type="text" x-ref="input" placeholder="dd.mm.gggg" wire:model="eventDate" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900">
                    @error('eventDate') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-brand-600">{{ __('site.contact_form.message') }}</label>
                <textarea wire:model="message" rows="5" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900"></textarea>
                @error('message') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-700">
                {{ __('site.contact_form.send') }}
            </button>
        </form>
    @endif
</div>
