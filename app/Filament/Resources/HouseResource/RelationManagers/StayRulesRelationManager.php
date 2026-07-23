<?php

namespace App\Filament\Resources\HouseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class StayRulesRelationManager extends RelationManager
{
    protected static string $relationship = 'stayRules';

    protected static ?string $title = 'Stay rules';

    private const DAYS = [
        'monday' => 'Monday',
        'tuesday' => 'Tuesday',
        'wednesday' => 'Wednesday',
        'thursday' => 'Thursday',
        'friday' => 'Friday',
        'saturday' => 'Saturday',
        'sunday' => 'Sunday',
    ];

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date_from')
                    ->helperText('Leave empty for the default rule'),
                Forms\Components\DatePicker::make('date_to')
                    ->afterOrEqual('date_from'),
                Forms\Components\TextInput::make('min_nights')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('max_nights')
                    ->numeric(),
                Forms\Components\CheckboxList::make('allowed_arrival_days')
                    ->options(self::DAYS)
                    ->columns(4)
                    ->columnSpanFull()
                    ->helperText('Leave empty to allow any day'),
                Forms\Components\CheckboxList::make('allowed_departure_days')
                    ->options(self::DAYS)
                    ->columns(4)
                    ->columnSpanFull()
                    ->helperText('Leave empty to allow any day'),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('min_nights')
            ->defaultSort('date_from')
            ->columns([
                Tables\Columns\TextColumn::make('date_from')->date()->placeholder('Default'),
                Tables\Columns\TextColumn::make('date_to')->date(),
                Tables\Columns\TextColumn::make('min_nights'),
                Tables\Columns\TextColumn::make('max_nights')->placeholder('—'),
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
