<x-filament-panels::page>
    <form wire:submit="setPrices">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="[
                \Filament\Actions\Action::make('setPrices')->submit('setPrices')->label('Set price for selected dates'),
            ]"
            class="mt-6"
        />
    </form>
</x-filament-panels::page>
