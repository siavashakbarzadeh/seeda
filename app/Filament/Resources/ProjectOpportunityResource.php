<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectOpportunityResource\Pages;
use App\Models\ProjectOpportunity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectOpportunityResource extends Resource
{
    protected static ?string $model = ProjectOpportunity::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $navigationLabel = '🎯 Project Finder';
    protected static ?int $navigationSort = 16;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::active()->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Project Details')->schema([
                Forms\Components\TextInput::make('title')
                    ->required()->maxLength(255)
                    ->placeholder('e.g. E-commerce Platform with Laravel + React')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description')
                    ->rows(3)->columnSpanFull()
                    ->placeholder('Describe the project requirements, scope, and expectations...'),
                Forms\Components\Select::make('source')
                    ->options(ProjectOpportunity::getSourceOptions())
                    ->required()->searchable(),
                Forms\Components\TextInput::make('source_url')
                    ->label('Source URL')
                    ->url()->prefix('https://')
                    ->placeholder('Link to the project posting'),
                Forms\Components\Select::make('status')
                    ->options(ProjectOpportunity::getStatusOptions())
                    ->default('found')->required(),
                Forms\Components\Select::make('priority')
                    ->options(ProjectOpportunity::getPriorityOptions())
                    ->default('medium')->required(),
            ])->columns(2),

            Forms\Components\Section::make('Client Info')->schema([
                Forms\Components\TextInput::make('client_name')
                    ->placeholder('Client or company name'),
                Forms\Components\TextInput::make('client_email')
                    ->email()->placeholder('client@example.com'),
            ])->columns(2)->collapsible(),

            Forms\Components\Section::make('Budget & Timeline')->schema([
                Forms\Components\Select::make('budget_type')
                    ->options(ProjectOpportunity::getBudgetTypeOptions())
                    ->default('unknown'),
                Forms\Components\Select::make('currency')
                    ->options(['EUR' => '€ EUR', 'USD' => '$ USD', 'GBP' => '£ GBP', 'CAD' => '$ CAD'])
                    ->default('EUR'),
                Forms\Components\TextInput::make('budget_min')
                    ->numeric()->prefix('Min')->placeholder('0'),
                Forms\Components\TextInput::make('budget_max')
                    ->numeric()->prefix('Max')->placeholder('0'),
                Forms\Components\TextInput::make('estimated_hours')
                    ->numeric()->suffix('hours'),
                Forms\Components\DatePicker::make('deadline')
                    ->label('Project Deadline'),
            ])->columns(3),

            Forms\Components\Section::make('Technical')->schema([
                Forms\Components\CheckboxList::make('technologies')
                    ->options(ProjectOpportunity::getTechOptions())
                    ->columns(4)
                    ->searchable(),
            ]),

            Forms\Components\Section::make('Tracking')->schema([
                Forms\Components\Select::make('assigned_to')
                    ->relationship('assignedUser', 'name')
                    ->searchable()->preload()
                    ->placeholder('Who is handling this?'),
                Forms\Components\DateTimePicker::make('applied_at')
                    ->label('Applied On'),
                Forms\Components\DateTimePicker::make('response_at')
                    ->label('Response Received'),
                Forms\Components\Textarea::make('notes')
                    ->rows(2)->columnSpanFull()
                    ->placeholder('Internal notes, follow-up reminders, etc.'),
            ])->columns(3)->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()->weight('bold')
                    ->limit(40)->tooltip(fn($record) => $record->title),
                Tables\Columns\TextColumn::make('source')
                    ->badge()
                    ->formatStateUsing(fn($state) => ProjectOpportunity::getSourceOptions()[$state] ?? $state)
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'found',
                        'info' => 'applied',
                        'warning' => 'interviewing',
                        'primary' => 'proposal_sent',
                        'success' => 'won',
                        'danger' => 'lost',
                        'secondary' => 'passed',
                    ]),
                Tables\Columns\TextColumn::make('priority')
                    ->badge()
                    ->colors([
                        'success' => 'low',
                        'warning' => 'medium',
                        'danger' => fn($state) => in_array($state, ['high', 'urgent']),
                    ]),
                Tables\Columns\TextColumn::make('budget_range')
                    ->label('Budget')
                    ->getStateUsing(fn($record) => $record->budget_range),
                Tables\Columns\TextColumn::make('budget_type')
                    ->badge()->color('gray')
                    ->formatStateUsing(fn($state) => ProjectOpportunity::getBudgetTypeOptions()[$state] ?? $state),
                Tables\Columns\TextColumn::make('technologies')
                    ->label('Tech Stack')
                    ->getStateUsing(fn($record) => implode(', ', array_map(
                        fn($t) => ProjectOpportunity::getTechOptions()[$t] ?? $t,
                        $record->technologies ?? []
                    )))
                    ->limit(30)->wrap(),
                Tables\Columns\TextColumn::make('deadline')
                    ->date()->sortable()
                    ->color(fn($record) => $record->deadline && $record->deadline->isPast() ? 'danger' : null),
                Tables\Columns\TextColumn::make('assignedUser.name')
                    ->label('Assigned To')->default('—'),
                Tables\Columns\TextColumn::make('days_since_found')
                    ->label('Age')
                    ->getStateUsing(fn($record) => $record->days_since_found . 'd')
                    ->badge()->color('gray'),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('apply')
                    ->label('Mark Applied')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->action(fn(ProjectOpportunity $record) => $record->update([
                        'status' => 'applied',
                        'applied_at' => now(),
                    ]))
                    ->hidden(fn(ProjectOpportunity $record) => $record->status !== 'found'),
                Tables\Actions\Action::make('won')
                    ->label('Won!')
                    ->icon('heroicon-o-trophy')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn(ProjectOpportunity $record) => $record->update([
                        'status' => 'won',
                        'response_at' => now(),
                    ]))
                    ->hidden(fn(ProjectOpportunity $record) => in_array($record->status, ['won', 'lost', 'passed'])),
                Tables\Actions\Action::make('pass')
                    ->label('Pass')
                    ->icon('heroicon-o-forward')
                    ->color('gray')
                    ->action(fn(ProjectOpportunity $record) => $record->update(['status' => 'passed']))
                    ->hidden(fn(ProjectOpportunity $record) => in_array($record->status, ['won', 'lost', 'passed'])),
                Tables\Actions\Action::make('open_link')
                    ->label('Open')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn(ProjectOpportunity $record) => $record->source_url, shouldOpenInNewTab: true)
                    ->hidden(fn(ProjectOpportunity $record) => !$record->source_url),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(ProjectOpportunity::getStatusOptions()),
                Tables\Filters\SelectFilter::make('source')
                    ->options(ProjectOpportunity::getSourceOptions()),
                Tables\Filters\SelectFilter::make('priority')
                    ->options(ProjectOpportunity::getPriorityOptions()),
                Tables\Filters\SelectFilter::make('budget_type')
                    ->options(ProjectOpportunity::getBudgetTypeOptions()),
                Tables\Filters\TernaryFilter::make('active')
                    ->label('Active Only')
                    ->trueLabel('Active')
                    ->falseLabel('All')
                    ->queries(
                        true: fn($query) => $query->active(),
                        false: fn($query) => $query,
                    )->default(true),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectOpportunities::route('/'),
            'create' => Pages\CreateProjectOpportunity::route('/create'),
            'edit' => Pages\EditProjectOpportunity::route('/{record}/edit'),
        ];
    }
}
