<?php

namespace App\Filament\Resources\HouseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PhotosRelationManager extends RelationManager
{
    protected static string $relationship = 'photos';

    protected static ?string $title = 'Photos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('path')
                    ->image()
                    ->imageEditor()
                    ->directory('houses')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('alt_text')
                    ->helperText('Short description of the photo (for accessibility/SEO)')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_cover'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('alt_text')
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('path')
                    ->square(),
                Tables\Columns\TextColumn::make('alt_text')
                    ->limit(40),
                Tables\Columns\IconColumn::make('is_cover')
                    ->boolean(),
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
