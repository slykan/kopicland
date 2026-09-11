<?php

namespace App\Filament\Pages;

use App\Models\House;
use App\Models\PricingRule;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SetPricesPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Set Prices';

    protected static ?string $title = 'Set Prices';

    protected static ?string $slug = 'set-prices';

    protected static ?string $navigationGroup = 'Pricing';

    protected static ?int $navigationSort = 0;

    protected static string $view = 'filament.pages.set-prices-page';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
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
                Forms\Components\DatePicker::make('date_from')
                    ->required()
                    ->native(false),
                Forms\Components\DatePicker::make('date_to')
                    ->required()
                    ->native(false)
                    ->afterOrEqual('date_from'),
                Forms\Components\TextInput::make('price_per_night')
                    ->label('Price per night (EUR)')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                Forms\Components\TextInput::make('label')
                    ->label('Label (optional)')
                    ->placeholder('e.g. High season, New Year')
                    ->columnSpanFull(),
            ])
            ->columns(2)
            ->statePath('data');
    }

    /**
     * Sets one "date"-type pricing rule per selected house for the range,
     * replacing any of that house's existing date-type rules that overlap it
     * so the new price unambiguously wins (an overlap left in place would
     * make PriceCalculator's rule lookup pick whichever rule came first).
     * Any un-overlapped part of a replaced rule's range is not preserved —
     * re-set it separately afterwards if it still needs its own price.
     */
    public function setPrices(): void
    {
        $state = $this->form->getState();
        $locale = app()->getLocale();

        $names = [];

        foreach ($state['house_ids'] as $houseId) {
            $house = House::find($houseId);

            PricingRule::query()
                ->where('house_id', $houseId)
                ->where('type', 'date')
                ->where('date_from', '<=', $state['date_to'])
                ->where('date_to', '>=', $state['date_from'])
                ->delete();

            PricingRule::create([
                'house_id' => $houseId,
                'type' => 'date',
                'label' => $state['label'] ?: null,
                'date_from' => $state['date_from'],
                'date_to' => $state['date_to'],
                'price_per_night' => $state['price_per_night'],
            ]);

            $names[] = $house?->getTranslation('name', $locale) ?? "#{$houseId}";
        }

        Notification::make()
            ->title('Prices updated')
            ->body(implode(', ', $names))
            ->success()
            ->send();

        $this->form->fill();
    }
}
