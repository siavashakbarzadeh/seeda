<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Support';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::open()->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $urgent = static::getModel()::open()->where('priority', 'urgent')->count();
        return $urgent > 0 ? 'danger' : 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Ticket Details')->schema([
                Forms\Components\TextInput::make('ticket_number')
                    ->required()
                    ->default(fn() => Ticket::generateNumber())
                    ->unique(ignoreRecord: true)
                    ->disabled()
                    ->dehydrated(),

                Forms\Components\TextInput::make('subject')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),

                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(fn($set) => $set('website_id', null)),

                Forms\Components\Select::make('website_id')
                    ->relationship(
                        'website',
                        'name',
                        fn($query, $get) =>
                        $get('client_id')
                        ? $query->where('client_id', $get('client_id'))
                        : $query
                    )
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('category')
                    ->options([
                        'bug' => '🐛 Bug Report',
                        'feature' => '✨ Feature Request',
                        'question' => '❓ Question',
                        'billing' => '💳 Billing',
                        'access' => '🔑 Access Issue',
                        'performance' => '⚡ Performance',
                        'other' => '📋 Other',
                    ])->placeholder('Select category'),

                Forms\Components\Select::make('priority')
                    ->options([
                        'low' => '🟢 Low',
                        'medium' => '🟡 Medium',
                        'high' => '🟠 High',
                        'urgent' => '🔴 Urgent',
                    ])->default('medium')->required(),

                Forms\Components\Select::make('status')
                    ->options([
                        'open' => '📬 Open',
                        'in_progress' => '🔄 In Progress',
                        'waiting' => '⏳ Waiting on Client',
                        'resolved' => '✅ Resolved',
                        'closed' => '🔒 Closed',
                    ])->default('open')->required(),

                Forms\Components\Select::make('assigned_to')
                    ->relationship('assignedUser', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder('Unassigned'),

                Forms\Components\Select::make('source')
                    ->options([
                        'portal' => '🌐 Portal',
                        'email' => '📧 Email',
                        'phone' => '📞 Phone',
                        'admin' => '🛡️ Admin',
                    ])->default('portal'),

                Forms\Components\TextInput::make('sla_hours')
                    ->label('SLA (hours)')
                    ->numeric()
                    ->placeholder('e.g. 24')
                    ->helperText('Max hours for first response'),

                Forms\Components\TagsInput::make('tags')
                    ->placeholder('Add tags...'),
            ])->columns(3),

            Forms\Components\Section::make('Description')->schema([
                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('Attachments')->schema([
                Forms\Components\FileUpload::make('initial_attachments')
                    ->label('Attach Files')
                    ->multiple()
                    ->directory('ticket-attachments')
                    ->maxSize(10240)
                    ->acceptedFileTypes(['image/*', 'application/pdf', '.doc', '.docx', '.xls', '.xlsx', '.zip', '.txt'])
                    ->columnSpanFull()
                    ->helperText('Max 10MB per file. Supported: images, PDF, Office docs, ZIP, TXT.'),
            ])->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ticket_number')
                    ->searchable()->sortable()->weight('bold')
                    ->copyable(),

                Tables\Columns\TextColumn::make('subject')
                    ->searchable()->sortable()
                    ->limit(35)
                    ->tooltip(fn($record) => $record->subject),

                Tables\Columns\TextColumn::make('client.name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->colors([
                        'danger' => 'bug',
                        'info' => 'feature',
                        'warning' => 'question',
                        'success' => 'billing',
                        'gray' => fn($state) => !in_array($state, ['bug', 'feature', 'question', 'billing']),
                    ])
                    ->formatStateUsing(fn($state) => $state ? ucfirst($state) : '—'),

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
                        'success' => 'resolved',
                        'gray' => 'closed',
                    ]),

                Tables\Columns\TextColumn::make('assignedUser.name')
                    ->label('Assigned')
                    ->default('—'),

                Tables\Columns\TextColumn::make('response_time')
                    ->label('Response')
                    ->getStateUsing(fn($record) => $record->response_time ?? '—')
                    ->color(fn($record) => $record->isSlaBreached() ? 'danger' : 'success')
                    ->tooltip(fn($record) => match ($record->sla_status) {
                        'breached' => '⚠️ SLA Breached!',
                        'overdue' => '🔴 SLA Overdue!',
                        'met' => '✅ SLA Met',
                        'active' => '⏳ Awaiting response',
                        default => 'No SLA set',
                    }),

                Tables\Columns\TextColumn::make('replies_count')
                    ->counts('replies')
                    ->label('💬')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('satisfaction_rating')
                    ->label('⭐')
                    ->formatStateUsing(fn($state) => $state ? str_repeat('⭐', $state) : '—')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('assign_me')
                    ->label('Assign to Me')
                    ->icon('heroicon-o-user-plus')
                    ->color('info')
                    ->action(fn(Ticket $record) => $record->update(['assigned_to' => auth()->id()]))
                    ->hidden(fn(Ticket $record) => $record->assigned_to === auth()->id()),
                Tables\Actions\Action::make('close')
                    ->label('Close')
                    ->icon('heroicon-o-lock-closed')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->action(fn(Ticket $record) => $record->update([
                        'status' => 'closed',
                        'closed_at' => now(),
                    ]))
                    ->hidden(fn(Ticket $record) => $record->status === 'closed'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'open' => 'Open',
                        'in_progress' => 'In Progress',
                        'waiting' => 'Waiting',
                        'resolved' => 'Resolved',
                        'closed' => 'Closed',
                    ]),
                Tables\Filters\SelectFilter::make('priority')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                        'urgent' => 'Urgent',
                    ]),
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'bug' => 'Bug',
                        'feature' => 'Feature',
                        'question' => 'Question',
                        'billing' => 'Billing',
                        'access' => 'Access',
                        'performance' => 'Performance',
                        'other' => 'Other',
                    ]),
                Tables\Filters\SelectFilter::make('client')
                    ->relationship('client', 'name'),
                Tables\Filters\SelectFilter::make('assigned_to')
                    ->relationship('assignedUser', 'name')
                    ->label('Assigned To'),
                Tables\Filters\Filter::make('sla_breached')
                    ->label('SLA Breached')
                    ->query(
                        fn($query) => $query->whereNotNull('sla_hours')
                            ->where(function ($q) {
                                $q->whereNull('first_responded_at')
                                    ->orWhereRaw('TIMESTAMPDIFF(HOUR, created_at, first_responded_at) > sla_hours');
                            })
                    ),
                Tables\Filters\Filter::make('unrated')
                    ->label('Awaiting Rating')
                    ->query(fn($query) => $query->unrated()),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkAction::make('bulk_assign')
                    ->label('Assign To...')
                    ->icon('heroicon-o-user-plus')
                    ->form([
                        Forms\Components\Select::make('assigned_to')
                            ->relationship('assignedUser', 'name')
                            ->required(),
                    ])
                    ->action(
                        fn($records, array $data) =>
                        $records->each(fn($r) => $r->update(['assigned_to' => $data['assigned_to']]))
                    ),
                Tables\Actions\BulkAction::make('bulk_close')
                    ->label('Close Selected')
                    ->icon('heroicon-o-lock-closed')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->action(
                        fn($records) =>
                        $records->each(fn($r) => $r->update(['status' => 'closed', 'closed_at' => now()]))
                    ),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'view' => Pages\ViewTicket::route('/{record}'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
