<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ActiveProjectsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Project::query()
                    ->with('client')
                    ->active()
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')->weight('bold'),
                Tables\Columns\TextColumn::make('client.name'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'planning',
                        'primary' => 'in_progress',
                        'info' => 'review',
                    ]),
                Tables\Columns\TextColumn::make('progress')->suffix('%'),
                Tables\Columns\TextColumn::make('deadline')
                    ->date()
                    ->color(fn($record) => $record->is_overdue ? 'danger' : null),
                Tables\Columns\TextColumn::make('tasks_count')
                    ->counts('tasks')
                    ->label('Tasks')
                    ->badge()
                    ->color('gray'),
            ])
            ->heading('🚀 Active Projects')
            ->paginated(false);
    }
}
