<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Business';
    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'overdue')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Invoice Details')->schema([
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('invoice_number')
                    ->required()
                    ->default(fn() => Invoice::generateNumber())
                    ->unique(ignoreRecord: true),
                Forms\Components\DatePicker::make('issue_date')
                    ->required()
                    ->default(now()),
                Forms\Components\DatePicker::make('due_date')
                    ->default(now()->addDays(30)),
                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => '📝 Draft',
                        'sent' => '📤 Sent',
                        'paid' => '✅ Paid',
                        'overdue' => '⚠️ Overdue',
                        'cancelled' => '❌ Cancelled',
                    ])->default('draft')->required(),
                Forms\Components\TextInput::make('tax_rate')
                    ->numeric()
                    ->suffix('%')
                    ->default(22)
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        $subtotal = (float) $get('subtotal');
                        $tax = $subtotal * ((float) $state / 100);
                        $set('tax_amount', number_format($tax, 2, '.', ''));
                        $set('total', number_format($subtotal + $tax, 2, '.', ''));
                    }),
            ])->columns(3),

            Forms\Components\Section::make('Line Items')->schema([
                Forms\Components\Repeater::make('items')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('description')
                            ->required()
                            ->columnSpan(3)
                            ->placeholder('e.g. Website development — homepage'),
                        Forms\Components\TextInput::make('quantity')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('unit_price')
                            ->numeric()
                            ->prefix('€')
                            ->required()
                            ->columnSpan(1),
                        Forms\Components\Placeholder::make('line_total')
                            ->label('Total')
                            ->content(function ($get) {
                                $qty = (float) ($get('quantity') ?? 0);
                                $price = (float) ($get('unit_price') ?? 0);
                                return '€ ' . number_format($qty * $price, 2);
                            })
                            ->columnSpan(1),
                    ])
                    ->columns(6)
                    ->defaultItems(1)
                    ->addActionLabel('+ Add Item')
                    ->reorderable()
                    ->collapsible(),
            ]),

            Forms\Components\Section::make('Totals')->schema([
                Forms\Components\TextInput::make('subtotal')
                    ->numeric()->prefix('€')
                    ->disabled()->dehydrated(),
                Forms\Components\TextInput::make('tax_amount')
                    ->numeric()->prefix('€')
                    ->disabled()->dehydrated(),
                Forms\Components\TextInput::make('total')
                    ->numeric()->prefix('€')
                    ->disabled()->dehydrated()
                    ->extraAttributes(['class' => 'font-bold text-lg']),
            ])->columns(3),

            Forms\Components\Section::make('Notes')->schema([
                Forms\Components\Textarea::make('notes')
                    ->placeholder('Payment terms, bank details, etc.')
                    ->rows(3),
            ])->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable()->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('client.name')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('issue_date')
                    ->date()->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->color(fn($record) => $record->is_overdue ? 'danger' : null),
                Tables\Columns\TextColumn::make('total')
                    ->money('EUR')->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'info' => 'sent',
                        'success' => 'paid',
                        'danger' => 'overdue',
                        'warning' => 'cancelled',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('markPaid')
                    ->label('Mark Paid')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn(Invoice $record) => $record->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                    ]))
                    ->hidden(fn(Invoice $record) => $record->status === 'paid'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'sent' => 'Sent',
                        'paid' => 'Paid',
                        'overdue' => 'Overdue',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('client')
                    ->relationship('client', 'name'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
