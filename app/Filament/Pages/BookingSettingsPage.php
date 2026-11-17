<?php

namespace App\Filament\Pages;

use App\Models\BookingSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class BookingSettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Reservations';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationLabel = 'Online booking';

    protected static ?string $title = 'Online booking';

    protected static ?string $slug = 'online-booking';

    protected static string $view = 'filament.pages.popup-settings-page';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->canManageReservations() ?? false;
    }

    public function mount(): void
    {
        $this->form->fill(BookingSetting::current()->only(['online_booking']));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Checkbox::make('online_booking')
                    ->label('Online reservations enabled (Rezervacije uključene)')
                    ->helperText('Ticked: guests book directly on the house page. Unticked: no reservations are created online - the house page shows an inquiry form for the chosen dates and the inquiry arrives by email to '.config('site.contact.email').'.'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        BookingSetting::current()->update($this->form->getState());

        Notification::make()
            ->title('Saved')
            ->success()
            ->send();
    }
}
