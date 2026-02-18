<?php

namespace App\Filament\Client\Resources;

use App\Filament\Client\Resources\ClientWebsiteResource\Pages;
use App\Models\Website;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClientWebsiteResource extends Resource
{
    protected static ?string $model = Website::class;
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationLabel = 'My Websites';
    protected static ?string $modelLabel = 'Website';
    protected static ?int $navigationSort = 3;

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $clientId = auth()->user()?->client_id;
        return parent::getEloquentQuery()->where('client_id', $clientId);
    }

    public static function canCreate(): bool
    {
        return false;
    }
    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }
    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('domain')
                    ->url(fn($record) => $record->domain ? "https://{$record->domain}" : null, true)
                    ->color('primary'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'active',
                        'warning' => 'maintenance',
                        'info' => 'development',
                        'danger' => 'suspended',
                        'gray' => 'archived',
                    ]),
                Tables\Columns\TextColumn::make('hosting_expiry')->date(),
                Tables\Columns\TextColumn::make('domain_expiry')->date(),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientWebsites::route('/'),
        ];
    }
}
