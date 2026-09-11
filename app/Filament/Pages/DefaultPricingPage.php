<?php

namespace App\Filament\Pages;

use App\Models\PricingSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class DefaultPricingPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Default Pricing';

    protected static ?string $title = 'Default Pricing';

    protected static ?string $slug = 'default-pricing';

    protected static ?string $navigationGroup = 'Pricing';

    protected static ?int $navigationSort = -1;

    protected static string $view = 'filament.pages.default-pricing-page';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function mount(): void
    {
        $this->form->fill(PricingSetting::current()->only(['default_price_per_night']));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('default_price_per_night')
                    ->label('Default price per night (EUR)')
                    ->helperText('Used for every house and date that has no specific override below (see Set Prices to override for a house/date range).')
                    ->required()
                    ->numeric()
                    ->minValue(0),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        PricingSetting::current()->update($this->form->getState());

        Notification::make()
            ->title('Saved')
            ->success()
            ->send();
    }
}
