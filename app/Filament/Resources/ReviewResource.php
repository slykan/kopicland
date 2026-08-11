<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    use Translatable;

    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Google Reviews';

    public static function canViewAny(): bool
    {
        return auth()->user()?->canManageContent() ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('author_name')
                    ->label('Guest name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('rating')
                    ->options([5 => '5 stars', 4 => '4 stars', 3 => '3 stars', 2 => '2 stars', 1 => '1 star'])
                    ->required()
                    ->default(5),
                Forms\Components\Textarea::make('comment')
                    ->label('Review text')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Show on website')
                    ->default(true),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('author_name')
                    ->label('Guest'),
                Tables\Columns\TextColumn::make('rating')
                    ->formatStateUsing(fn (int $state) => str_repeat('★', $state).str_repeat('☆', 5 - $state)),
                Tables\Columns\TextColumn::make('comment')
                    ->limit(60),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Visible')
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
            'index' => Pages\ManageReviews::route('/'),
        ];
    }
}
