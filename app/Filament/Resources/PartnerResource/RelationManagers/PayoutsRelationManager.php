<?php

namespace App\Filament\Resources\PartnerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PayoutsRelationManager extends RelationManager
{
    protected static string $relationship = 'payouts';
    protected static ?string $title = 'Payout History';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('amount')
                ->numeric()->prefix('€')->required(),
            Forms\Components\Select::make('method')
                ->options(['bank' => 'Bank Transfer', 'paypal' => 'PayPal', 'crypto' => 'Crypto'])
                ->required(),
            Forms\Components\TextInput::make('reference_no')->label('Reference Number'),
            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'processing' => 'Processing',
                    'completed' => 'Completed',
                    'failed' => 'Failed',
                ])->required(),
            Forms\Components\DateTimePicker::make('processed_at'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('amount')->money('EUR'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'processing',
                        'success' => 'completed',
                        'danger' => 'failed',
                    ]),
                Tables\Columns\TextColumn::make('method')->badge()->color('gray'),
                Tables\Columns\TextColumn::make('reference_no')->label('Ref'),
                Tables\Columns\TextColumn::make('processed_at')->dateTime('M d, Y H:i'),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }
}
