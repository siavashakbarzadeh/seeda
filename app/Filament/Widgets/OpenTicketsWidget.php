<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class OpenTicketsWidget extends BaseWidget
{
    protected static ?int $sort = 0;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Ticket::query()
                    ->with(['client', 'assignedUser'])
                    ->open()
                    ->orderByRaw("CASE priority WHEN 'urgent' THEN 1 WHEN 'high' THEN 2 WHEN 'medium' THEN 3 ELSE 4 END")
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('ticket_number')
                    ->weight('bold')
                    ->url(fn($record) => route('filament.admin.resources.tickets.view', $record)),
                Tables\Columns\TextColumn::make('subject')
                    ->limit(30),
                Tables\Columns\TextColumn::make('client.name'),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? ucfirst($state) : '—')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('priority')
                    ->badge()
                    ->colors([
                        'success' => 'low',
                        'warning' => 'medium',
                        'orange' => 'high',
                        'danger' => 'urgent',
                    ]),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'info' => 'open',
                        'primary' => 'in_progress',
                        'warning' => 'waiting',
                    ]),
                Tables\Columns\TextColumn::make('assignedUser.name')
                    ->label('Assigned')
                    ->default('—'),
                Tables\Columns\TextColumn::make('sla_status')
                    ->label('SLA')
                    ->getStateUsing(fn($record) => match ($record->sla_status) {
                        'overdue' => '🔴 Overdue',
                        'active' => '⏳ ' . $record->sla_hours . 'h',
                        'met' => '✅',
                        'breached' => '⚠️',
                        default => '—',
                    })
                    ->color(fn($record) => $record->isSlaBreached() ? 'danger' : null),
                Tables\Columns\TextColumn::make('created_at')
                    ->since(),
            ])
            ->heading('🎫 Open Tickets')
            ->description(
                fn() => Ticket::open()->where('priority', 'urgent')->count() > 0
                ? '🔴 ' . Ticket::open()->where('priority', 'urgent')->count() . ' urgent ticket(s)!'
                : null
            )
            ->paginated(false);
    }
}
