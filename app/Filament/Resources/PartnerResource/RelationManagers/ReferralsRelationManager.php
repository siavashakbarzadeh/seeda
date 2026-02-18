<?php

namespace App\Filament\Resources\PartnerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ReferralsRelationManager extends RelationManager
{
    protected static string $relationship = 'referrals';
    protected static ?string $title = 'Referred Leads & Projects';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('lead_id')
                ->relationship('lead', 'name')
                ->searchable()->preload(),
            Forms\Components\Select::make('project_id')
                ->relationship('project', 'name')
                ->searchable()->preload(),
            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'converted' => 'Converted',
                    'payout_pending' => 'Payout Pending',
                    'paid' => 'Paid',
                    'cancelled' => 'Cancelled',
                ])->required(),
            Forms\Components\TextInput::make('payout_amount')
                ->numeric()->prefix('€'),
            Forms\Components\Toggle::make('is_recurring')->label('Recurring Commission'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lead.name')
                    ->label('Lead/Client')->weight('bold'),
                Tables\Columns\TextColumn::make('project.name')
                    ->label('Project')->default('—'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'pending',
                        'info' => 'converted',
                        'warning' => 'payout_pending',
                        'success' => 'paid',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('payout_amount')
                    ->money('EUR')->label('Earned'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('M d, Y'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'converted' => 'Converted',
                        'paid' => 'Paid',
                    ]),
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
