<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class AdminGuidePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationLabel = 'Vodič kroz admin';

    protected static ?string $title = 'Vodič kroz admin';

    protected static ?string $slug = 'guide';

    protected static ?string $navigationGroup = 'Help';

    protected static ?int $navigationSort = 100;

    protected static string $view = 'filament.pages.admin-guide-page';
}
