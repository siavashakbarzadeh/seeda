<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Projects';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::active()->count() ?: null;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Project Info')->schema([
                Forms\Components\TextInput::make('name')
                    ->required()->maxLength(255)
                    ->reactive()
                    ->afterStateUpdated(fn($state, $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->required()->unique(ignoreRecord: true),
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->searchable()->preload(),
                Forms\Components\Select::make('status')
                    ->options([
                        'planning' => '📋 Planning',
                        'in_progress' => '🔄 In Progress',
                        'review' => '👀 Review',
                        'completed' => '✅ Completed',
                        'on_hold' => '⏸️ On Hold',
                        'cancelled' => '❌ Cancelled',
                    ])->default('planning')->required(),
                Forms\Components\Select::make('priority')
                    ->options([
                        'low' => '🟢 Low',
                        'medium' => '🟡 Medium',
                        'high' => '🟠 High',
                        'critical' => '🔴 Critical',
                    ])->default('medium')->required(),
                Forms\Components\Textarea::make('description')
                    ->rows(3)->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Budget & Timeline')->schema([
                Forms\Components\TextInput::make('budget')
                    ->numeric()->prefix('€'),
                Forms\Components\TextInput::make('hourly_rate')
                    ->numeric()->prefix('€/h')
                    ->placeholder('50.00'),
                Forms\Components\DatePicker::make('start_date'),
                Forms\Components\DatePicker::make('deadline'),
                Forms\Components\TextInput::make('progress')
                    ->numeric()->suffix('%')
                    ->minValue(0)->maxValue(100)
                    ->default(0),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('client.name')->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'planning',
                        'primary' => 'in_progress',
                        'info' => 'review',
                        'success' => 'completed',
                        'warning' => 'on_hold',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('priority')
                    ->badge()
                    ->colors([
                        'success' => 'low',
                        'warning' => 'medium',
                        'orange' => 'high',
                        'danger' => 'critical',
                    ]),
                Tables\Columns\TextColumn::make('progress')
                    ->suffix('%')->sortable(),
                Tables\Columns\TextColumn::make('budget')->money('EUR'),
                Tables\Columns\TextColumn::make('deadline')
                    ->date()
                    ->color(fn($record) => $record->is_overdue ? 'danger' : null),
                Tables\Columns\TextColumn::make('tasks_count')
                    ->counts('tasks')->label('Tasks')->badge()->color('gray'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'planning' => 'Planning',
                        'in_progress' => 'In Progress',
                        'review' => 'Review',
                        'completed' => 'Completed',
                        'on_hold' => 'On Hold',
                    ]),
                Tables\Filters\SelectFilter::make('client')
                    ->relationship('client', 'name'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
