<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentInvoicesWidget extends BaseWidget
{
    protected static ?int $sort = -1;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Invoice::query()
                    ->with('client')
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('client.name'),
                Tables\Columns\TextColumn::make('total')
                    ->money('EUR'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'info' => 'sent',
                        'success' => 'paid',
                        'danger' => 'overdue',
                        'warning' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->color(fn($record) => $record->is_overdue ? 'danger' : null),
            ])
            ->heading('Recent Invoices')
            ->paginated(false);
    }
}
