<?php

namespace App\Filament\Resources\ExtraCostResource\Pages;

use App\Filament\Resources\ExtraCostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExtraCosts extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = ExtraCostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
