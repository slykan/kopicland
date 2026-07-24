<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PricingTierResource\Pages;
use App\Models\PricingTier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PricingTierResource extends Resource
{
    protected static ?string $model = PricingTier::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Guest Pricing';

    protected static ?string $navigationGroup = 'Pricing';

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereNull('pricing_rule_id');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('guests')
                    ->label('Total guests (up to)')
                    ->helperText('Price applies for this many guests and fewer, down to the next lower tier.')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                Forms\Components\TextInput::make('price_per_night')
                    ->label('Price per night (EUR)')
                    ->required()
                    ->numeric()
                    ->minValue(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('guests')
            ->columns([
                Tables\Columns\TextColumn::make('guests')
                    ->label('Total guests'),
                Tables\Columns\TextColumn::make('price_per_night')
                    ->money('EUR'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePricingTiers::route('/'),
        ];
    }
}
