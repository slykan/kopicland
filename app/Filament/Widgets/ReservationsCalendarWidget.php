<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ReservationResource;
use App\Models\House;
use App\Models\Reservation;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Actions;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class ReservationsCalendarWidget extends FullCalendarWidget
{
    public Model|string|null $model = Reservation::class;

    protected static ?string $heading = 'Reservations calendar';

    public ?int $houseFilter = null;

    public ?string $statusFilter = null;

    public function config(): array
    {
        return [
            'firstDay' => 1,
            'headerToolbar' => [
                'left' => 'dayGridMonth,dayGridWeek,dayGridDay',
                'center' => 'title',
                'right' => 'prev,next today',
            ],
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        return Reservation::query()
            ->with(['house', 'guest'])
            ->when($this->houseFilter, fn ($query) => $query->where('house_id', $this->houseFilter))
            ->when($this->statusFilter, fn ($query) => $query->where('status', $this->statusFilter))
            ->where('check_in', '<', $fetchInfo['end'])
            ->where('check_out', '>', $fetchInfo['start'])
            ->get()
            ->map(fn (Reservation $reservation) => EventData::make()
                ->id($reservation->id)
                ->title($this->eventTitle($reservation))
                ->start($reservation->check_in)
                ->end($reservation->check_out)
                ->backgroundColor($this->colorForStatus($reservation->status))
                ->borderColor($this->colorForStatus($reservation->status)))
            ->toArray();
    }

    private function eventTitle(Reservation $reservation): string
    {
        $houseName = $reservation->house?->getTranslation('name', app()->getLocale()) ?? 'Unknown house';
        $guestName = $reservation->guest
            ? "{$reservation->guest->first_name} {$reservation->guest->last_name}"
            : ucfirst(str_replace('_', ' ', $reservation->status));

        return "{$houseName} — {$guestName}";
    }

    private function colorForStatus(string $status): string
    {
        return match ($status) {
            'confirmed' => '#16a34a',
            'new_request', 'pending' => '#f59e0b',
            'rejected', 'cancelled', 'no_show' => '#dc2626',
            'hold' => '#a855f7',
            'blocked' => '#6b7280',
            default => '#6b7280',
        };
    }

    protected function headerActions(): array
    {
        return [
            \Filament\Actions\Action::make('filter')
                ->label('Filter')
                ->icon('heroicon-o-funnel')
                ->form([
                    Forms\Components\Select::make('house_id')
                        ->label('House')
                        ->options(fn () => House::query()->get()->mapWithKeys(fn (House $house) => [$house->id => $house->getTranslation('name', app()->getLocale())]))
                        ->default($this->houseFilter),
                    Forms\Components\Select::make('status')
                        ->options([
                            'new_request' => 'New request',
                            'pending' => 'Pending confirmation',
                            'confirmed' => 'Confirmed',
                            'rejected' => 'Rejected',
                            'cancelled' => 'Cancelled',
                            'completed' => 'Completed',
                            'no_show' => 'Guest did not show up',
                            'hold' => 'Temporary hold',
                            'blocked' => 'Blocked',
                        ])
                        ->default($this->statusFilter),
                ])
                ->action(function (array $data): void {
                    $this->houseFilter = $data['house_id'] ?? null;
                    $this->statusFilter = $data['status'] ?? null;
                    $this->refreshRecords();
                }),
            Actions\CreateAction::make()
                ->mountUsing(function (Forms\Form $form, array $arguments) {
                    $form->fill([
                        'check_in' => $arguments['start'] ?? null,
                        'check_out' => $arguments['end'] ?? null,
                        'status' => 'new_request',
                        'source' => 'website',
                        'locale' => 'hr',
                    ]);
                }),
        ];
    }

    protected function modalActions(): array
    {
        return [
            Actions\EditAction::make()
                ->mountUsing(function (Reservation $record, Forms\Form $form, array $arguments) {
                    $form->fill([
                        ...$record->toArray(),
                        'check_in' => $arguments['event']['start'] ?? $record->check_in,
                        'check_out' => $arguments['event']['end'] ?? $record->check_out,
                    ]);
                }),
            Actions\DeleteAction::make(),
        ];
    }

    public function getFormSchema(): array
    {
        return ReservationResource::formSchema();
    }
}
