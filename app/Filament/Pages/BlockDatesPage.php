<?php

namespace App\Filament\Pages;

use App\Models\House;
use App\Models\Reservation;
use App\Services\AvailabilityChecker;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class BlockDatesPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    protected static ?string $navigationLabel = 'Block Dates';

    protected static ?string $title = 'Block Dates';

    protected static ?string $slug = 'block-dates';

    protected static ?string $navigationGroup = 'Reservations';

    protected static ?int $navigationSort = 0;

    protected static string $view = 'filament.pages.block-dates-page';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->canManageReservations() ?? false;
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\CheckboxList::make('house_ids')
                    ->label('Houses')
                    ->options(fn () => House::query()
                        ->orderBy('sort_order')
                        ->get()
                        ->mapWithKeys(fn (House $house) => [$house->id => $house->getTranslation('name', app()->getLocale())]))
                    ->required()
                    ->bulkToggleable()
                    ->columns(2),
                Forms\Components\DatePicker::make('check_in')
                    ->label('Check-in')
                    ->required()
                    ->native(false),
                Forms\Components\DatePicker::make('check_out')
                    ->label('Check-out')
                    ->required()
                    ->native(false)
                    ->afterOrEqual('check_in'),
                Forms\Components\Textarea::make('internal_note')
                    ->label('Reason (internal note)')
                    ->rows(2)
                    ->columnSpanFull(),
            ])
            ->columns(2)
            ->statePath('data');
    }

    /**
     * Creates one "blocked" reservation per selected house. Houses that already
     * have an overlapping reservation/block for the range are skipped (not failed)
     * so blocking five houses doesn't abort because one of them is already taken.
     */
    public function block(): void
    {
        $state = $this->form->getState();

        $checker = app(AvailabilityChecker::class);
        $locale = app()->getLocale();

        $blockedNames = [];
        $skippedNames = [];

        foreach ($state['house_ids'] as $houseId) {
            $house = House::find($houseId);
            $name = $house?->getTranslation('name', $locale) ?? "#{$houseId}";

            if (! $checker->isAvailable((int) $houseId, $state['check_in'], $state['check_out'])) {
                $skippedNames[] = $name;

                continue;
            }

            Reservation::create([
                'house_id' => $houseId,
                'check_in' => $state['check_in'],
                'check_out' => $state['check_out'],
                'adults' => 0,
                'children' => 0,
                'pets' => 0,
                'status' => 'blocked',
                'source' => 'other',
                'internal_note' => $state['internal_note'] ?? null,
                'created_by' => auth()->id(),
            ]);

            $blockedNames[] = $name;
        }

        if ($blockedNames) {
            Notification::make()
                ->title('Dates blocked')
                ->body(implode(', ', $blockedNames))
                ->success()
                ->send();
        }

        if ($skippedNames) {
            Notification::make()
                ->title('Skipped — already reserved or blocked')
                ->body(implode(', ', $skippedNames))
                ->warning()
                ->send();
        }

        $this->form->fill();
    }
}
