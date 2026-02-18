<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppNotificationResource\Pages;
use App\Models\AppNotification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AppNotificationResource extends Resource
{
    protected static ?string $model = AppNotification::class;
    protected static ?string $navigationIcon = 'heroicon-o-bell';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Notifications';
    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::unread()
            ->where('user_id', auth()->id())
            ->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                AppNotification::query()
                    ->where('user_id', auth()->id())
            )
            ->columns([
                Tables\Columns\IconColumn::make('is_read')
                    ->boolean()
                    ->trueIcon('heroicon-o-envelope-open')
                    ->falseIcon('heroicon-o-envelope')
                    ->trueColor('gray')
                    ->falseColor('primary')
                    ->label(''),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->colors([
                        'info' => 'ticket_reply',
                        'success' => 'invoice_paid',
                        'primary' => 'project_assigned',
                        'warning' => 'task_assigned',
                        'danger' => 'deadline_approaching',
                    ]),
                Tables\Columns\TextColumn::make('title')
                    ->weight(fn($record) => $record->is_read ? 'normal' : 'bold')
                    ->searchable(),
                Tables\Columns\TextColumn::make('body')
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\Action::make('read')
                    ->label('Mark Read')
                    ->icon('heroicon-o-check')
                    ->action(fn(AppNotification $record) => $record->markAsRead())
                    ->hidden(fn(AppNotification $record) => $record->is_read),
                Tables\Actions\Action::make('open')
                    ->label('Open')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn(AppNotification $record) => $record->link)
                    ->hidden(fn(AppNotification $record) => !$record->link)
                    ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('markAllRead')
                    ->label('Mark All Read')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn($records) => $records->each->markAsRead()),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppNotifications::route('/'),
        ];
    }
}
