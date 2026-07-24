<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExtraCostResource\Pages;
use App\Models\ExtraCost;
use App\Models\House;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExtraCostResource extends Resource
{
    use Translatable;

    protected static ?string $model = ExtraCost::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

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
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->label('Amount (EUR)')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('unit')
                    ->options([
                        'one_time' => 'One-time',
                        'per_night' => 'Per night',
                        'per_person' => 'Per person',
                        'per_person_per_night' => 'Per person / night',
                    ])
                    ->required()
                    ->default('one_time'),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('house.name')
                    ->label('House')
                    ->placeholder('All houses'),
                Tables\Columns\TextColumn::make('amount')
                    ->money('EUR'),
                Tables\Columns\TextColumn::make('unit'),
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
            'index' => Pages\ListExtraCosts::route('/'),
            'create' => Pages\CreateExtraCost::route('/create'),
            'edit' => Pages\EditExtraCost::route('/{record}/edit'),
        ];
    }
}
