<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Filament\Resources\LeadResource\RelationManagers;
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\AppNotification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'new')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Lead Info')->schema([
                Forms\Components\TextInput::make('name')->required()->maxLength(255),
                Forms\Components\TextInput::make('email')->email(),
                Forms\Components\TextInput::make('phone')->tel(),
                Forms\Components\TextInput::make('company'),
                Forms\Components\TextInput::make('website')->url()->prefix('https://'),
                Forms\Components\Select::make('industry')
                    ->options(Lead::getIndustryOptions())
                    ->searchable()->placeholder('Select industry'),
                Forms\Components\Select::make('company_size')
                    ->options(Lead::getCompanySizeOptions())
                    ->placeholder('Company size'),
                Forms\Components\Select::make('source')
                    ->options(Lead::getSourceOptions())
                    ->default('website')->required(),
                Forms\Components\Select::make('status')
                    ->options(Lead::getStatusOptions())
                    ->default('new')->required(),
            ])->columns(3),

            Forms\Components\Section::make('Value & Priority')->schema([
                Forms\Components\TextInput::make('estimated_value')
                    ->numeric()->prefix('€')->placeholder('Estimated deal value'),
                Forms\Components\TextInput::make('score')
                    ->numeric()->default(0)
                    ->helperText('Auto-calculated or manual'),
                Forms\Components\Select::make('priority')
                    ->options(Lead::getPriorityOptions())
                    ->default('medium'),
                Forms\Components\Select::make('assigned_to')
                    ->relationship('assignedUser', 'name')
                    ->searchable()->preload()
                    ->placeholder('Assign to team member'),
                Forms\Components\Select::make('campaign_id')
                    ->relationship('campaign', 'name')
                    ->searchable()->preload()
                    ->placeholder('From campaign (optional)'),
            ])->columns(3),

            Forms\Components\Section::make('UTM Tracking')->schema([
                Forms\Components\TextInput::make('utm_source')->placeholder('e.g. google'),
                Forms\Components\TextInput::make('utm_medium')->placeholder('e.g. cpc'),
                Forms\Components\TextInput::make('utm_campaign')->placeholder('e.g. spring_sale'),
            ])->columns(3)->collapsible()->collapsed(),

            Forms\Components\Section::make('Notes')->schema([
                Forms\Components\Textarea::make('notes')->rows(4)->columnSpanFull(),
            ])->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('company')
                    ->searchable()->default('—'),
                Tables\Columns\TextColumn::make('email')
                    ->copyable()->toggleable(),
                Tables\Columns\TextColumn::make('source')
                    ->badge()
                    ->formatStateUsing(fn($state) => Lead::getSourceOptions()[$state] ?? $state),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'info' => 'new',
                        'primary' => 'contacted',
                        'warning' => fn($state) => in_array($state, ['qualified', 'proposal']),
                        'success' => fn($state) => in_array($state, ['negotiation', 'won']),
                        'danger' => 'lost',
                    ]),
                Tables\Columns\TextColumn::make('priority')
                    ->badge()
                    ->formatStateUsing(fn($state) => Lead::getPriorityOptions()[$state] ?? $state)
                    ->colors([
                        'success' => 'low',
                        'warning' => 'medium',
                        'danger' => fn($state) => in_array($state, ['high', 'urgent']),
                    ]),
                Tables\Columns\TextColumn::make('score')
                    ->label('🎯 Score')
                    ->badge()
                    ->color(fn($state) => match (true) {
                        $state >= 60 => 'success',
                        $state >= 30 => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('estimated_value')
                    ->money('EUR')->default('—'),
                Tables\Columns\TextColumn::make('assignedUser.name')
                    ->label('Assigned')->default('—'),
                Tables\Columns\TextColumn::make('industry')
                    ->formatStateUsing(fn($state) => Lead::getIndustryOptions()[$state] ?? $state)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('campaign.name')
                    ->label('Campaign')->default('—')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('add_activity')
                    ->label('Log Activity')
                    ->icon('heroicon-o-pencil-square')
                    ->color('info')
                    ->form([
                        Forms\Components\Select::make('type')
                            ->options(LeadActivity::getTypeOptions())
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->required()->rows(3),
                        Forms\Components\DateTimePicker::make('scheduled_at')
                            ->label('Follow-up Date (optional)'),
                    ])
                    ->action(function (Lead $record, array $data) {
                        LeadActivity::log(
                            $record->id,
                            $data['type'],
                            $data['description'],
                            auth()->id(),
                            ['scheduled_at' => $data['scheduled_at'] ?? null]
                        );
                        $record->update(['last_contacted_at' => now()]);
                    }),

                Tables\Actions\Action::make('calculate_score')
                    ->label('Recalculate Score')
                    ->icon('heroicon-o-calculator')
                    ->color('warning')
                    ->action(fn(Lead $record) => $record->calculateScore()),

                Tables\Actions\Action::make('convert_to_client')
                    ->label('Convert to Client')
                    ->icon('heroicon-o-arrow-right-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalDescription('This will create a new client from this lead. Continue?')
                    ->action(function (Lead $record) {
                        $client = $record->convertToClient();

                        AppNotification::notify(
                            auth()->id(),
                            'lead_converted',
                            '🏆 Lead Converted: ' . $record->name,
                            'New client created: ' . $client->name,
                            '/admin/clients/' . $client->id . '/edit'
                        );
                    })
                    ->hidden(fn(Lead $record) => $record->status === 'won' || $record->client_id),

                Tables\Actions\Action::make('mark_lost')
                    ->label('Mark Lost')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\Textarea::make('loss_reason')
                            ->label('Why was this lead lost?')
                            ->required(),
                    ])
                    ->action(function (Lead $record, array $data) {
                        $record->update([
                            'status' => 'lost',
                            'notes' => $record->notes . "\n\n❌ Lost: " . $data['loss_reason'],
                        ]);
                        LeadActivity::log($record->id, 'status_change', 'Lead marked as lost: ' . $data['loss_reason']);
                    })
                    ->hidden(fn(Lead $record) => in_array($record->status, ['won', 'lost'])),

                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(Lead::getStatusOptions()),
                Tables\Filters\SelectFilter::make('source')
                    ->options(Lead::getSourceOptions()),
                Tables\Filters\SelectFilter::make('priority')
                    ->options(Lead::getPriorityOptions()),
                Tables\Filters\SelectFilter::make('industry')
                    ->options(Lead::getIndustryOptions()),
                Tables\Filters\SelectFilter::make('assigned_to')
                    ->relationship('assignedUser', 'name'),
                Tables\Filters\SelectFilter::make('campaign')
                    ->relationship('campaign', 'name'),
                Tables\Filters\Filter::make('hot_leads')
                    ->label('🔥 Hot Leads (score ≥ 50)')
                    ->query(fn($query) => $query->hotLeads()),
                Tables\Filters\Filter::make('high_priority')
                    ->label('⚠️ High Priority')
                    ->query(fn($query) => $query->highPriority()),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkAction::make('bulk_assign')
                    ->label('Assign To')
                    ->icon('heroicon-o-user')
                    ->form([
                        Forms\Components\Select::make('assigned_to')
                            ->label('Assign to')
                            ->options(\App\Models\User::where('role', '!=', 'client')->pluck('name', 'id'))
                            ->required(),
                    ])
                    ->action(fn($records, $data) => $records->each->update(['assigned_to' => $data['assigned_to']])),
                Tables\Actions\BulkAction::make('bulk_score')
                    ->label('Recalculate Scores')
                    ->icon('heroicon-o-calculator')
                    ->color('warning')
                    ->action(fn($records) => $records->each->calculateScore()),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ActivitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
