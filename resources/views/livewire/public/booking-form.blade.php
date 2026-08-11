<div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-sm">
    @if ($submitted)
        <div class="text-center">
            <h3 class="text-lg font-semibold text-brand-900">{{ __('Thank you!') }}</h3>
            <p class="mt-2 text-sm text-brand-600">{{ __('Your reservation request has been sent. We will confirm availability shortly by email.') }}</p>
        </div>
    @else
        <form wire:submit="submit" class="space-y-4">
            <div class="grid grid-cols-2 gap-3">
                <div x-data="datePicker({ minDate: 'today' })">
                    <label class="block text-xs font-medium text-brand-600">{{ __('site.common.check_in') }}</label>
                    <input type="text" x-ref="input" placeholder="dd.mm.gggg" wire:model.live="checkIn" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900">
                    @error('checkIn') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div x-data="datePicker({ minDate: 'today' })">
                    <label class="block text-xs font-medium text-brand-600">{{ __('site.common.check_out') }}</label>
                    <input type="text" x-ref="input" placeholder="dd.mm.gggg" wire:model.live="checkOut" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900">
                    @error('checkOut') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-medium text-brand-600">{{ __('site.common.adults') }}</label>
                    <input type="number" min="1" wire:model.live="adults" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900">
                </div>
                <div>
                    <label class="block text-xs font-medium text-brand-600">{{ __('site.common.children') }}</label>
                    <input type="number" min="0" wire:model.live="children" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900">
                    @error('children') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-brand-600">{{ __('site.common.pets') }}</label>
                    <input type="number" min="0" wire:model="pets" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900">
                    @error('pets') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            @if ($priceError)
                <p class="rounded-lg bg-red-50 px-3 py-2 text-sm text-red-700">{{ $priceError }}</p>
            @elseif ($priceBreakdown)
                <div class="rounded-lg bg-brand-50 px-3 py-3 text-sm text-brand-700">
                    <div class="flex justify-between"><span>{{ $priceBreakdown['nights'] }} {{ __('site.common.nights') }}</span><span>{{ number_format($priceBreakdown['accommodation_subtotal'], 2) }} €</span></div>
                    @foreach ($priceBreakdown['extra_costs'] as $extra)
                        <div class="flex justify-between text-brand-500"><span>{{ $extra['name'] }}</span><span>{{ number_format($extra['amount'], 2) }} €</span></div>
                    @endforeach
                    @if ($priceBreakdown['discount'])
                        <div class="flex justify-between text-green-700"><span>{{ $priceBreakdown['discount']['label'] }}</span><span>-{{ number_format($priceBreakdown['discount_amount'], 2) }} €</span></div>
                    @endif
                    <div class="mt-2 flex justify-between border-t border-brand-200 pt-2 font-semibold text-brand-900">
                        <span>{{ __('Total') }}</span><span>{{ number_format($priceBreakdown['total'], 2) }} €</span>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-brand-600">{{ __('First name') }}</label>
                    <input type="text" wire:model="firstName" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900">
                    @error('firstName') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-brand-600">{{ __('Last name') }}</label>
                    <input type="text" wire:model="lastName" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900">
                    @error('lastName') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-brand-600">{{ __('Email') }}</label>
                <input type="email" wire:model="email" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900">
                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-brand-600">{{ __('Phone') }}</label>
                    <input type="text" wire:model="phone" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900">
                    @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-brand-600">{{ __('Country') }}</label>
                    <select wire:model="country" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900">
                        <option value="">—</option>
                        @foreach ($this->countries as $code => $name)
                            <option value="{{ $code }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('country') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-brand-600">{{ __('Address') }}</label>
                <input type="text" wire:model="address" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900">
                @error('address') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-medium text-brand-600">{{ __('Note') }}</label>
                <textarea wire:model="guestNote" rows="2" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900"></textarea>
            </div>

            <div>
                <label class="block text-xs font-medium text-brand-600">{{ __('Promo code') }}</label>
                <input type="text" wire:model.live="promoCode" class="mt-1 w-full rounded-lg border border-brand-200 px-3 py-2 text-sm text-brand-900">
            </div>

            <div class="space-y-2 text-sm text-brand-600">
                <label class="flex items-start gap-2">
                    <input type="checkbox" wire:model="acceptRules" class="mt-0.5 rounded border-brand-300">
                    <span>{{ __('site.footer.booking_rules') }}</span>
                </label>
                @error('acceptRules') <p class="text-xs text-red-600">{{ $message }}</p> @enderror

                <label class="flex items-start gap-2">
                    <input type="checkbox" wire:model="acceptPrivacy" class="mt-0.5 rounded border-brand-300">
                    <span>{{ __('site.footer.privacy') }}</span>
                </label>
                @error('acceptPrivacy') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-700">
                {{ __('site.common.book_now') }}
            </button>
        </form>
    @endif
</div>
