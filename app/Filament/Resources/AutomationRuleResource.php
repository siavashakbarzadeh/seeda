<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AutomationRuleResource\Pages;
use App\Models\AutomationRule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AutomationRuleResource extends Resource
{
    protected static ?string $model = AutomationRule::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $navigationLabel = 'Automation Rules';
    protected static ?int $navigationSort = 14;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Rule Setup')->schema([
                Forms\Components\TextInput::make('name')
                    ->required()->maxLength(255)
                    ->placeholder('e.g. Auto-assign hot leads to sales'),
                Forms\Components\Select::make('trigger')
                    ->options(AutomationRule::getTriggerOptions())
                    ->required()->searchable(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
                Forms\Components\Textarea::make('description')
                    ->rows(2)->columnSpanFull(),
            ])->columns(3),

            Forms\Components\Section::make('Conditions')
                ->description('Optional: only run when these conditions match')
                ->schema([
                    Forms\Components\KeyValue::make('conditions')
                        ->label('Conditions')
                        ->helperText('Available keys: source, status, score_min, score_max, industry, company_size, action')
                        ->columnSpanFull(),
                ])->collapsible(),

            Forms\Components\Section::make('Actions')
                ->description('What happens when the trigger fires and conditions match')
                ->schema([
                    Forms\Components\Repeater::make('actions')
                        ->schema([
                            Forms\Components\Select::make('type')
                                ->options(AutomationRule::getActionTypeOptions())
                                ->required(),
                            Forms\Components\TextInput::make('value')
                                ->label('Value / Parameter')
                                ->helperText('e.g. template ID, user ID, status name, score points, etc.')
                                ->required(),
                            Forms\Components\TextInput::make('note')
                                ->label('Note')
                                ->placeholder('Optional note about this action'),
                        ])
                        ->columns(3)
                        ->minItems(1)
                        ->defaultItems(1)
                        ->columnSpanFull()
                        ->addActionLabel('+ Add Action'),
                ]),

            Forms\Components\Section::make('Execution Stats')
                ->schema([
                    Forms\Components\Placeholder::make('executions_display')
                        ->label('Times Executed')
                        ->content(fn($record) => $record?->executions_count ?? 0),
                    Forms\Components\Placeholder::make('last_executed_display')
                        ->label('Last Executed')
                        ->content(fn($record) => $record?->last_executed_at?->diffForHumans() ?? 'Never'),
                ])->columns(2)->visibleOn('edit'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('trigger')
                    ->badge()
                    ->formatStateUsing(fn($state) => AutomationRule::getTriggerOptions()[$state] ?? $state),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()->label('Active'),
                Tables\Columns\TextColumn::make('actions_count')
                    ->label('Actions')
                    ->getStateUsing(fn($record) => count($record->actions ?? []))
                    ->badge()->color('info'),
                Tables\Columns\TextColumn::make('executions_count')
                    ->label('Runs')
                    ->badge()->color('success')->sortable(),
                Tables\Columns\TextColumn::make('last_executed_at')
                    ->since()->default('Never'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('toggle')
                    ->label(fn($record) => $record->is_active ? 'Deactivate' : 'Activate')
                    ->icon(fn($record) => $record->is_active ? 'heroicon-o-pause' : 'heroicon-o-play')
                    ->color(fn($record) => $record->is_active ? 'warning' : 'success')
                    ->action(fn(AutomationRule $record) => $record->update(['is_active' => !$record->is_active])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('trigger')
                    ->options(AutomationRule::getTriggerOptions()),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAutomationRules::route('/'),
            'create' => Pages\CreateAutomationRule::route('/create'),
            'edit' => Pages\EditAutomationRule::route('/{record}/edit'),
        ];
    }
}
