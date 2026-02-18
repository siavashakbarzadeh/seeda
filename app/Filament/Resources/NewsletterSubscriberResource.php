<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsletterSubscriberResource\Pages;
use App\Models\NewsletterSubscriber;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NewsletterSubscriberResource extends Resource
{
    protected static ?string $model = NewsletterSubscriber::class;
    protected static ?string $navigationIcon = 'heroicon-o-envelope-open';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $navigationLabel = 'Subscribers';
    protected static ?int $navigationSort = 5;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::active()->count() ?: null;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->searchable()->sortable()->copyable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->default('—'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()->label('Active'),
                Tables\Columns\TextColumn::make('subscribed_at')
                    ->date()->sortable(),
            ])
            ->defaultSort('subscribed_at', 'desc')
            ->actions([
                Tables\Actions\Action::make('unsubscribe')
                    ->label('Unsubscribe')
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->action(fn(NewsletterSubscriber $record) => $record->update([
                        'is_active' => false,
                        'unsubscribed_at' => now(),
                    ]))
                    ->hidden(fn(NewsletterSubscriber $record) => !$record->is_active)
                    ->requiresConfirmation(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNewsletterSubscribers::route('/'),
        ];
    }
}
