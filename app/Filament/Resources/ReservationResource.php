<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Models\House;
use App\Models\Reservation;
use App\Rules\HouseIsAvailable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Reservations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Booking')
                    ->schema([
                        Forms\Components\Select::make('house_id')
                            ->label('House')
                            ->relationship('house', 'id')
                            ->getOptionLabelFromRecordUsing(fn (House $record) => $record->getTranslation('name', app()->getLocale()))
                            ->required()
                            ->searchable()
                            ->live(),
                        Forms\Components\Select::make('guest_id')
                            ->label('Guest')
                            ->relationship('guest', 'id')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->first_name} {$record->last_name} ({$record->email})")
                            ->searchable(['first_name', 'last_name', 'email'])
                            ->createOptionForm([
                                Forms\Components\TextInput::make('first_name')->required(),
                                Forms\Components\TextInput::make('last_name')->required(),
                                Forms\Components\TextInput::make('email')->email()->required(),
                                Forms\Components\TextInput::make('phone')->tel(),
                            ]),
                        Forms\Components\DatePicker::make('check_in')
                            ->required()
                            ->live(),
                        Forms\Components\DatePicker::make('check_out')
                            ->required()
                            ->live()
                            ->afterOrEqual('check_in')
                            ->rule(fn (Get $get, ?Reservation $record) => new HouseIsAvailable(
                                $get('house_id') ? (int) $get('house_id') : null,
                                $get('check_in'),
                                $record?->id,
                            )),
                        Forms\Components\TextInput::make('adults')
                            ->required()
                            ->numeric()
                            ->default(1),
                        Forms\Components\TextInput::make('children')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('pets')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'new_request' => 'New request',
                                'pending' => 'Pending confirmation',
                                'confirmed' => 'Confirmed',
                                'rejected' => 'Rejected',
                                'cancelled' => 'Cancelled',
                                'completed' => 'Completed',
                                'no_show' => 'Guest did not show up',
                                'hold' => 'Temporary hold',
                                'blocked' => 'Blocked',
                            ])
                            ->required()
                            ->default('new_request'),
                        Forms\Components\Select::make('source')
                            ->options([
                                'website' => 'Website',
                                'booking_com' => 'Booking.com',
                                'airbnb' => 'Airbnb',
                                'phone' => 'Phone',
                                'email' => 'Email',
                                'agency' => 'Agency',
                                'other' => 'Other',
                            ])
                            ->required()
                            ->default('website'),
                        Forms\Components\Select::make('locale')
                            ->label('Guest language')
                            ->options(['hr' => 'Croatian', 'en' => 'English', 'de' => 'German'])
                            ->required()
                            ->default('hr'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Pricing')
                    ->schema([
                        Forms\Components\TextInput::make('total_price')
                            ->label('Total price (EUR)')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('discount_amount')
                            ->label('Discount (EUR)')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Notes')
                    ->schema([
                        Forms\Components\Textarea::make('guest_note')
                            ->label('Guest note'),
                        Forms\Components\Textarea::make('internal_note')
                            ->label('Internal note (not visible to guest)'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('check_in')
            ->columns([
                Tables\Columns\TextColumn::make('house.name')
                    ->label('House'),
                Tables\Columns\TextColumn::make('guest.last_name')
                    ->label('Guest')
                    ->formatStateUsing(fn ($record) => $record->guest ? "{$record->guest->first_name} {$record->guest->last_name}" : '—'),
                Tables\Columns\TextColumn::make('check_in')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('check_out')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'confirmed' => 'success',
                        'new_request', 'pending' => 'warning',
                        'rejected', 'cancelled', 'no_show' => 'danger',
                        'blocked' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('source'),
                Tables\Columns\TextColumn::make('total_price')
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('house_id')
                    ->label('House')
                    ->relationship('house', 'slug'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new_request' => 'New request',
                        'pending' => 'Pending confirmation',
                        'confirmed' => 'Confirmed',
                        'rejected' => 'Rejected',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                        'no_show' => 'Guest did not show up',
                        'hold' => 'Temporary hold',
                        'blocked' => 'Blocked',
                    ]),
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
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}
