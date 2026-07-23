<?php

namespace App\Filament\Widgets;

use App\Models\Reservation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReservationStatsOverview extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()?->canManageReservations() ?? false;
    }

    protected function getStats(): array
    {
        $newRequests = Reservation::where('status', 'new_request')->count();
        $pending = Reservation::where('status', 'pending')->count();
        $confirmed = Reservation::where('status', 'confirmed')->count();

        $arrivalsThisWeek = Reservation::where('status', 'confirmed')
            ->whereBetween('check_in', [now()->startOfDay(), now()->addDays(7)->endOfDay()])
            ->count();

        $departuresThisWeek = Reservation::where('status', 'confirmed')
            ->whereBetween('check_out', [now()->startOfDay(), now()->addDays(7)->endOfDay()])
            ->count();

        $confirmedValue = Reservation::where('status', 'confirmed')->sum('total_price');

        return [
            Stat::make('New requests', $newRequests)
                ->color($newRequests > 0 ? 'warning' : 'gray'),
            Stat::make('Pending confirmation', $pending)
                ->color($pending > 0 ? 'warning' : 'gray'),
            Stat::make('Confirmed reservations', $confirmed)
                ->color('success'),
            Stat::make('Arrivals (next 7 days)', $arrivalsThisWeek),
            Stat::make('Departures (next 7 days)', $departuresThisWeek),
            Stat::make('Confirmed value', number_format((float) $confirmedValue, 2).' EUR'),
        ];
    }
}
