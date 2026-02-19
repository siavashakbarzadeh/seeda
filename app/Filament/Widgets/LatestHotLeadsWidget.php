<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestHotLeadsWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Lead::hotLeads()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('score')
                    ->label('🎯 Score')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn($state) => Lead::getStatusOptions()[$state] ?? $state),
                Tables\Columns\TextColumn::make('estimated_value')
                    ->money('EUR')->label('Value'),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()->label('Added'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(fn(Lead $record): string => "/admin/leads/{$record->id}/edit")
                    ->icon('heroicon-o-eye'),
            ]);
    }
}
