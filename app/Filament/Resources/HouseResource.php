<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HouseResource\Pages;
use App\Models\Amenity;
use App\Models\House;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HouseResource extends Resource
{
    use Translatable;

    protected static ?string $model = House::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    public static function canViewAny(): bool
    {
        return auth()->user()?->canManageContent() ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Content')
                    ->schema([
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Used in the public URL, e.g. /houses/slug'),
                        Forms\Components\TextInput::make('name')
                            ->required(),
                        Forms\Components\Textarea::make('short_description')
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('description')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('house_rules')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Capacity & layout')
                    ->schema([
                        Forms\Components\TextInput::make('capacity_adults')
                            ->label('Adults')
                            ->required()
                            ->numeric()
                            ->default(2),
                        Forms\Components\TextInput::make('capacity_children')
                            ->label('Children')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('bedrooms')
                            ->required()
                            ->numeric()
                            ->default(1),
                        Forms\Components\TextInput::make('beds')
                            ->required()
                            ->numeric()
                            ->default(1),
                        Forms\Components\TextInput::make('bathrooms')
                            ->required()
                            ->numeric()
                            ->default(1),
                        Forms\Components\TextInput::make('size_m2')
                            ->label('Size (m²)')
                            ->numeric(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Location')
                    ->schema([
                        Forms\Components\TextInput::make('lat')
                            ->numeric(),
                        Forms\Components\TextInput::make('lng')
                            ->numeric(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Stay details')
                    ->schema([
                        Forms\Components\TimePicker::make('check_in_time'),
                        Forms\Components\TimePicker::make('check_out_time'),
                        Forms\Components\Toggle::make('pets_allowed'),
                        Forms\Components\Toggle::make('parking_available'),
                    ])
                    ->columns(4),

                Forms\Components\Section::make('Amenities')
                    ->schema([
                        Forms\Components\CheckboxList::make('amenities')
                            ->relationship('amenities', 'id')
                            ->getOptionLabelFromRecordUsing(fn (Amenity $record) => $record->getTranslation('name', app()->getLocale()))
                            ->columns(3)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Pricing & status')
                    ->schema([
                        Forms\Components\TextInput::make('base_price_per_night')
                            ->label('Base price / night (EUR)')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'unpublished' => 'Unpublished',
                                'archived' => 'Archived',
                            ])
                            ->required()
                            ->default('draft'),
                        Forms\Components\Toggle::make('is_featured'),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(4),

                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('seo_title'),
                        Forms\Components\Textarea::make('seo_description')
                            ->rows(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('capacity_adults')
                    ->label('Adults')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('capacity_children')
                    ->label('Children')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('base_price_per_night')
                    ->label('Base price')
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'gray',
                        'unpublished' => 'warning',
                        'archived' => 'danger',
                    }),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'unpublished' => 'Unpublished',
                        'archived' => 'Archived',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        $relations = [
            HouseResource\RelationManagers\PhotosRelationManager::class,
            HouseResource\RelationManagers\StayRulesRelationManager::class,
        ];

        // Pricing is financial data; content editors don't get access to it (doc 12).
        if (auth()->user()?->isAdmin()) {
            $relations[] = HouseResource\RelationManagers\PricingRulesRelationManager::class;
        }

        return $relations;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHouses::route('/'),
            'create' => Pages\CreateHouse::route('/create'),
            'view' => Pages\ViewHouse::route('/{record}'),
            'edit' => Pages\EditHouse::route('/{record}/edit'),
        ];
    }
}
