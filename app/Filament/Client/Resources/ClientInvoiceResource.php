<?php

namespace App\Filament\Client\Resources;

use App\Filament\Client\Resources\ClientInvoiceResource\Pages;
use App\Models\Invoice;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ClientInvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'My Invoices';
    protected static ?string $modelLabel = 'Invoice';
    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $clientId = auth()->user()?->client_id;
        return parent::getEloquentQuery()->where('client_id', $clientId);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('issue_date')->date()->sortable(),
                Tables\Columns\TextColumn::make('due_date')->date()
                    ->color(fn($record) => $record->is_overdue ? 'danger' : null),
                Tables\Columns\TextColumn::make('total')
                    ->money('EUR')->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'info' => 'sent',
                        'success' => 'paid',
                        'danger' => 'overdue',
                        'warning' => 'cancelled',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Invoice Details')->schema([
                Infolists\Components\TextEntry::make('invoice_number')->weight('bold'),
                Infolists\Components\TextEntry::make('issue_date')->date(),
                Infolists\Components\TextEntry::make('due_date')->date(),
                Infolists\Components\TextEntry::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'info' => 'sent',
                        'success' => 'paid',
                        'danger' => 'overdue',
                    ]),
            ])->columns(4),

            Infolists\Components\Section::make('Items')->schema([
                Infolists\Components\RepeatableEntry::make('items')
                    ->schema([
                        Infolists\Components\TextEntry::make('description'),
                        Infolists\Components\TextEntry::make('quantity'),
                        Infolists\Components\TextEntry::make('unit_price')->money('EUR'),
                        Infolists\Components\TextEntry::make('total')->money('EUR')->weight('bold'),
                    ])->columns(4),
            ]),

            Infolists\Components\Section::make('Totals')->schema([
                Infolists\Components\TextEntry::make('subtotal')->money('EUR'),
                Infolists\Components\TextEntry::make('tax_amount')
                    ->label(fn($record) => "Tax ({$record->tax_rate}%)")
                    ->money('EUR'),
                Infolists\Components\TextEntry::make('total')
                    ->money('EUR')
                    ->weight('bold')
                    ->size(Infolists\Components\TextEntry\TextEntrySize::Large),
            ])->columns(3),

            Infolists\Components\Section::make('Notes')->schema([
                Infolists\Components\TextEntry::make('notes')
                    ->default('—')
                    ->columnSpanFull(),
            ])->collapsible(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientInvoices::route('/'),
            'view' => Pages\ViewClientInvoice::route('/{record}'),
        ];
    }
}
