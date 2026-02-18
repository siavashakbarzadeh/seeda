<?php

namespace App\Filament\Client\Resources;

use App\Filament\Client\Resources\ClientTicketResource\Pages;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClientTicketResource extends Resource
{
    protected static ?string $model = Ticket::class;
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'My Tickets';
    protected static ?string $modelLabel = 'Ticket';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $clientId = auth()->user()?->client_id;
        return $clientId
            ? Ticket::where('client_id', $clientId)->open()->count() ?: null
            : null;
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $clientId = auth()->user()?->client_id;
        return parent::getEloquentQuery()->where('client_id', $clientId);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('New Ticket')->schema([
                Forms\Components\Hidden::make('client_id')
                    ->default(fn() => auth()->user()?->client_id),

                Forms\Components\Hidden::make('ticket_number')
                    ->default(fn() => Ticket::generateNumber()),

                Forms\Components\TextInput::make('subject')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->placeholder('Brief summary of your issue'),

                Forms\Components\Select::make('category')
                    ->options([
                        'bug' => '🐛 Bug Report',
                        'feature' => '✨ Feature Request',
                        'question' => '❓ Question',
                        'billing' => '💳 Billing',
                        'access' => '🔑 Access Issue',
                        'other' => '📋 Other',
                    ])
                    ->placeholder('What type of issue?'),

                Forms\Components\Select::make('website_id')
                    ->label('Related Website')
                    ->relationship(
                        'website',
                        'name',
                        fn($query) =>
                        $query->where('client_id', auth()->user()?->client_id)
                    )
                    ->searchable()
                    ->preload()
                    ->placeholder('Select a website (optional)'),

                Forms\Components\Select::make('priority')
                    ->options([
                        'low' => '🟢 Low — No rush',
                        'medium' => '🟡 Medium — Normal',
                        'high' => '🟠 High — Important',
                        'urgent' => '🔴 Urgent — Critical blocker',
                    ])->default('medium')->required(),

                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->columnSpanFull()
                    ->placeholder('Describe your issue in detail. Include steps to reproduce if applicable.'),

                Forms\Components\FileUpload::make('initial_attachments')
                    ->label('Attach Screenshots or Files')
                    ->multiple()
                    ->directory('ticket-attachments')
                    ->maxSize(10240)
                    ->acceptedFileTypes(['image/*', 'application/pdf', '.doc', '.docx', '.zip', '.txt'])
                    ->columnSpanFull()
                    ->helperText('Max 10MB per file.'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ticket_number')
                    ->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('subject')
                    ->searchable()->limit(40),
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
                        'success' => 'resolved',
                        'gray' => 'closed',
                    ]),
                Tables\Columns\TextColumn::make('replies_count')
                    ->counts('replies')
                    ->label('💬')
                    ->badge(),
                Tables\Columns\IconColumn::make('satisfaction_rating')
                    ->label('⭐')
                    ->icon(fn($state) => $state ? 'heroicon-s-star' : 'heroicon-o-star')
                    ->color(fn($state) => $state ? 'warning' : 'gray')
                    ->tooltip(
                        fn($record) => $record->satisfaction_rating
                        ? $record->satisfaction_rating . '/5 stars'
                        : ($record->status === 'resolved' ? 'Click to rate!' : 'Pending')
                    ),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
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
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientTickets::route('/'),
            'create' => Pages\CreateClientTicket::route('/create'),
            'view' => Pages\ViewClientTicket::route('/{record}'),
        ];
    }
}
