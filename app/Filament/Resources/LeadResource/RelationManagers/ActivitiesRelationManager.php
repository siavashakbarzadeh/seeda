<?php

namespace App\Filament\Resources\LeadResource\RelationManagers;

use App\Models\LeadActivity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ActivitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'activities';
    protected static ?string $title = 'Activity Timeline';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('type')
                ->options(LeadActivity::getTypeOptions())
                ->required(),
            Forms\Components\Textarea::make('description')
                ->required()->rows(3)->columnSpanFull(),
            Forms\Components\DateTimePicker::make('scheduled_at')
                ->label('Follow-up / Reminder'),
            Forms\Components\Toggle::make('is_completed')
                ->label('Completed'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn($state) => LeadActivity::getTypeOptions()[$state] ?? $state)
                    ->colors([
                        'info' => fn($state) => in_array($state, ['note', 'task']),
                        'primary' => fn($state) => in_array($state, ['call', 'email']),
                        'success' => fn($state) => in_array($state, ['meeting', 'demo']),
                        'warning' => fn($state) => in_array($state, ['proposal', 'follow_up']),
                        'gray' => 'status_change',
                    ]),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)->wrap(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('By')->default('System'),
                Tables\Columns\IconColumn::make('is_completed')
                    ->boolean()->label('Done'),
                Tables\Columns\TextColumn::make('scheduled_at')
                    ->dateTime('M d, H:i')->default('—')
                    ->color(
                        fn($record) =>
                        $record->scheduled_at && !$record->is_completed && $record->scheduled_at->isPast()
                        ? 'danger' : null
                    ),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = auth()->id();
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('complete')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(fn(LeadActivity $record) => $record->update(['is_completed' => true]))
                    ->hidden(fn(LeadActivity $record) => $record->is_completed),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
