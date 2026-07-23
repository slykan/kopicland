<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ReservationsCalendarWidget;
use Filament\Pages\Page;

class ReservationsCalendarPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Calendar';

    protected static ?string $slug = 'calendar';

    protected static ?string $navigationGroup = 'Reservations';

    protected static ?int $navigationSort = -1;

    protected static string $view = 'filament.pages.reservations-calendar-page';

    public static function canAccess(): bool
    {
        return auth()->user()?->canManageReservations() ?? false;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ReservationsCalendarWidget::class,
        ];
    }
}
