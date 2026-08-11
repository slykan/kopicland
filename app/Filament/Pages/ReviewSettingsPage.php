<?php

namespace App\Filament\Pages;

use App\Models\ReviewSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ReviewSettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Review Settings';

    protected static ?string $slug = 'review-settings';

    protected static string $view = 'filament.pages.review-settings-page';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->canManageContent() ?? false;
    }

    public function mount(): void
    {
        $this->form->fill(ReviewSetting::current()->only(['overall_rating', 'review_count', 'google_reviews_url']));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('overall_rating')
                    ->label('Overall rating (out of 5)')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(5)
                    ->step(0.1)
                    ->required(),
                Forms\Components\TextInput::make('review_count')
                    ->label('Total number of Google reviews')
                    ->numeric()
                    ->minValue(0),
                Forms\Components\TextInput::make('google_reviews_url')
                    ->label('Link to Google reviews page')
                    ->url(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        ReviewSetting::current()->update($this->form->getState());

        Notification::make()
            ->title('Saved')
            ->success()
            ->send();
    }
}
