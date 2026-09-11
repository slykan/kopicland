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

    <x-filament::section heading="Currently blocked">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                        <th class="px-3 py-2">Houses</th>
                        <th class="px-3 py-2">Check-in</th>
                        <th class="px-3 py-2">Check-out</th>
                        <th class="px-3 py-2">Reason</th>
                        <th class="px-3 py-2">Set at</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse ($this->recentBlocks as $row)
                        <tr>
                            <td class="px-3 py-2 font-medium text-gray-950 dark:text-white">{{ $row['houses'] }}</td>
                            <td class="px-3 py-2 text-gray-600 dark:text-gray-300">{{ $row['check_in'] }}</td>
                            <td class="px-3 py-2 text-gray-600 dark:text-gray-300">{{ $row['check_out'] }}</td>
                            <td class="px-3 py-2 text-gray-600 dark:text-gray-300">{{ $row['note'] ?: '—' }}</td>
                            <td class="px-3 py-2 text-gray-400">{{ $row['created_at']->format('d.m.Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 py-6 text-center text-gray-500">No blocked dates yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-panels::page>
