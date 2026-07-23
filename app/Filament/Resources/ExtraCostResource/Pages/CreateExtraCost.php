<?php

namespace App\Filament\Resources\ExtraCostResource\Pages;

use App\Filament\Resources\ExtraCostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExtraCost extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = ExtraCostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
