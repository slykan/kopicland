<?php

namespace App\Filament\Pages;

use App\Models\PopupSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class PopupSettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationLabel = 'Popup';

    protected static ?string $title = 'Popup';

    protected static ?string $slug = 'popup';

    protected static string $view = 'filament.pages.popup-settings-page';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->canManageContent() ?? false;
    }

    public function mount(): void
    {
        $this->form->fill(PopupSetting::current()->only(['is_active', 'image_path', 'link_url', 'alt_text']));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Toggle::make('is_active')
                    ->label('Online')
                    ->helperText('On: visitors see the popup once per visit. Off: popup is hidden.')
                    ->onColor('success'),
                Forms\Components\FileUpload::make('image_path')
                    ->label('Image')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('popup')
                    ->maxSize(8192)
                    ->helperText('Poster or announcement (portrait works best, e.g. 1024×1536).')
                    ->required(fn (Forms\Get $get): bool => (bool) $get('is_active'))
                    ->validationMessages(['required' => 'Choose an image before putting the popup online.'])
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('link_url')
                    ->label('Link when image is clicked (optional)')
                    ->placeholder('https://… or /hr/kontakt')
                    ->maxLength(255),
                Forms\Components\TextInput::make('alt_text')
                    ->label('Short description (for screen readers / SEO)')
                    ->placeholder('Doček Nove godine u Kopićlandu')
                    ->maxLength(255),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        PopupSetting::current()->update($this->form->getState());

        Notification::make()
            ->title('Saved')
            ->success()
            ->send();
    }
}
