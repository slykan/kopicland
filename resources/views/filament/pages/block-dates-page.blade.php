<x-filament-panels::page>
    <form wire:submit="block">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="[
                \Filament\Actions\Action::make('block')->submit('block')->label('Block selected dates'),
            ]"
            class="mt-6"
        />
    </form>
</x-filament-panels::page>
