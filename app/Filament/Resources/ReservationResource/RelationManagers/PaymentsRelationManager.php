<?php

namespace App\Filament\Resources\ReservationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->options([
                        'deposit' => 'Deposit',
                        'balance' => 'Balance',
                        'refund' => 'Refund',
                    ])
                    ->required()
                    ->default('deposit'),
                Forms\Components\TextInput::make('amount')
                    ->label('Amount (EUR)')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'partially_paid' => 'Partially paid',
                        'paid' => 'Paid',
                        'refunded' => 'Refunded',
                    ])
                    ->required()
                    ->default('unpaid'),
                Forms\Components\TextInput::make('method'),
                Forms\Components\DatePicker::make('paid_at'),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('amount')->money('EUR'),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('method'),
                Tables\Columns\TextColumn::make('paid_at')->date(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
