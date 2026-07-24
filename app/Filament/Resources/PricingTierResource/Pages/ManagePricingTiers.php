<?php

namespace App\Filament\Resources\PricingTierResource\Pages;

use App\Filament\Resources\PricingTierResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePricingTiers extends ManageRecords
{
    protected static string $resource = PricingTierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
