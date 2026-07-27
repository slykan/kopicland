<?php

namespace App\Filament\Resources\HouseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PricingRulesRelationManager extends RelationManager
{
    protected static string $relationship = 'pricingRules';

    protected static ?string $title = 'Pricing rules';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->options([
                        'season' => 'Season (date range)',
                        'date' => 'Specific date (takes priority)',
                    ])
                    ->required()
                    ->default('season'),
                Forms\Components\TextInput::make('label')
                    ->placeholder('e.g. High season, New Year'),
                Forms\Components\DatePicker::make('date_from')
                    ->required(),
                Forms\Components\DatePicker::make('date_to')
                    ->required()
                    ->afterOrEqual('date_from'),
                Forms\Components\TextInput::make('price_per_night')
                    ->label('Flat price / night (EUR)')
                    ->helperText('Used only when no per-guest prices are set below.')
                    ->required()
                    ->numeric(),
                Forms\Components\Repeater::make('tiers')
                    ->relationship()
                    ->label('Per-guest prices (optional, overrides flat price above)')
                    ->schema([
                        Forms\Components\TextInput::make('guests')
                            ->label('Total guests (up to)')
                            ->required()
                            ->numeric()
                            ->minValue(1),
                        Forms\Components\TextInput::make('price_per_night')
                            ->label('Price / night (EUR)')
                            ->required()
                            ->numeric()
                            ->minValue(0),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->orderColumn(null)
                    ->addActionLabel('Add guest tier')
                    ->defaultItems(0),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('label')
            ->defaultSort('date_from')
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state) => $state === 'date' ? 'warning' : 'gray'),
                Tables\Columns\TextColumn::make('label'),
                Tables\Columns\TextColumn::make('date_from')->date(),
                Tables\Columns\TextColumn::make('date_to')->date(),
                Tables\Columns\TextColumn::make('price_per_night')
                    ->label('Flat price')
                    ->money('EUR'),
                Tables\Columns\TextColumn::make('tiers_count')
                    ->counts('tiers')
                    ->label('Guest tiers')
                    ->formatStateUsing(fn (int $state) => $state > 0 ? "{$state} tiers" : '—'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
