<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiscountResource\Pages;
use App\Models\Discount;
use App\Models\House;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DiscountResource extends Resource
{
    use Translatable;

    protected static ?string $model = Discount::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    protected static ?string $navigationGroup = 'Pricing';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('house_id')
                    ->label('House')
                    ->relationship('house', 'id')
                    ->getOptionLabelFromRecordUsing(fn (House $record) => $record->getTranslation('name', app()->getLocale()))
                    ->searchable(['name'])
                    ->placeholder('All houses')
                    ->helperText('Leave empty to apply to every house'),
                Forms\Components\Select::make('type')
                    ->options([
                        'long_stay' => 'Long stay',
                        'early_bird' => 'Early bird',
                        'last_minute' => 'Last minute',
                        'promo_code' => 'Promo code',
                        'manual' => 'Manual',
                    ])
                    ->required()
                    ->live(),
                Forms\Components\TextInput::make('label'),
                Forms\Components\TextInput::make('code')
                    ->visible(fn (Forms\Get $get) => $get('type') === 'promo_code')
                    ->required(fn (Forms\Get $get) => $get('type') === 'promo_code'),
                Forms\Components\TextInput::make('value')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('value_type')
                    ->options([
                        'percent' => 'Percent (%)',
                        'fixed' => 'Fixed amount (EUR)',
                    ])
                    ->required()
                    ->default('percent'),
                Forms\Components\TextInput::make('min_nights')
                    ->numeric()
                    ->visible(fn (Forms\Get $get) => $get('type') === 'long_stay'),
                Forms\Components\TextInput::make('threshold_days')
                    ->label('Days before/until check-in')
                    ->numeric()
                    ->visible(fn (Forms\Get $get) => in_array($get('type'), ['early_bird', 'last_minute'])),
                Forms\Components\DatePicker::make('active_from')
                    ->helperText('Campaign validity window (optional)'),
                Forms\Components\DatePicker::make('active_until'),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('type')
                    ->badge(),
                Tables\Columns\TextColumn::make('house.name')
                    ->label('House')
                    ->placeholder('All houses'),
                Tables\Columns\TextColumn::make('code')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('value')
                    ->formatStateUsing(fn ($state, $record) => $record->value_type === 'percent' ? "{$state}%" : number_format($state, 2).' EUR'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
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
            'index' => Pages\ListDiscounts::route('/'),
            'create' => Pages\CreateDiscount::route('/create'),
            'edit' => Pages\EditDiscount::route('/{record}/edit'),
        ];
    }
}
