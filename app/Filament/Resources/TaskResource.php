<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;
    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationGroup = 'Projects';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Task Details')->schema([
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required()->searchable()->preload(),
                Forms\Components\TextInput::make('title')
                    ->required()->maxLength(255),
                Forms\Components\Select::make('assigned_to')
                    ->relationship('assignedUser', 'name')
                    ->searchable()->preload()
                    ->placeholder('Unassigned'),
                Forms\Components\Select::make('status')
                    ->options([
                        'todo' => '📋 To Do',
                        'in_progress' => '🔄 In Progress',
                        'review' => '👀 Review',
                        'done' => '✅ Done',
                    ])->default('todo')->required(),
                Forms\Components\Select::make('priority')
                    ->options([
                        'low' => '🟢 Low',
                        'medium' => '🟡 Medium',
                        'high' => '🟠 High',
                        'urgent' => '🔴 Urgent',
                    ])->default('medium')->required(),
                Forms\Components\DatePicker::make('due_date'),
                Forms\Components\Textarea::make('description')
                    ->rows(3)->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()->sortable()->limit(40),
                Tables\Columns\TextColumn::make('project.name')
                    ->searchable()->badge()->color('gray'),
                Tables\Columns\TextColumn::make('assignedUser.name')
                    ->label('Assigned')->default('—'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'todo',
                        'primary' => 'in_progress',
                        'info' => 'review',
                        'success' => 'done',
                    ]),
                Tables\Columns\TextColumn::make('priority')
                    ->badge()
                    ->colors([
                        'success' => 'low',
                        'warning' => 'medium',
                        'orange' => 'high',
                        'danger' => 'urgent',
                    ]),
                Tables\Columns\TextColumn::make('due_date')->date()->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('complete')
                    ->label('✓ Done')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(fn(Task $record) => $record->update([
                        'status' => 'done',
                        'completed_at' => now(),
                    ]))
                    ->hidden(fn(Task $record) => $record->status === 'done'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'todo' => 'To Do',
                        'in_progress' => 'In Progress',
                        'review' => 'Review',
                        'done' => 'Done',
                    ]),
                Tables\Filters\SelectFilter::make('project')
                    ->relationship('project', 'name'),
                Tables\Filters\SelectFilter::make('assigned_to')
                    ->relationship('assignedUser', 'name')
                    ->label('Assigned To'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
