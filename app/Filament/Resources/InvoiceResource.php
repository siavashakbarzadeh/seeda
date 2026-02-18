<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Mail\InvoiceSent;
use App\Models\AppNotification;
use App\Models\Invoice;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Business';
    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        $overdue = static::getModel()::overdue()->count();
        return $overdue > 0 ? $overdue : null;
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
                        'partial' => '🔶 Partially Paid',
                        'paid' => '✅ Paid',
                        'overdue' => '⚠️ Overdue',
                        'cancelled' => '❌ Cancelled',
                    ])->default('draft')->required(),
                Forms\Components\TextInput::make('tax_rate')
                    ->numeric()
                    ->suffix('%')
                    ->default(22),
                Forms\Components\Select::make('currency')
                    ->options(['EUR' => '€ EUR', 'USD' => '$ USD', 'GBP' => '£ GBP'])
                    ->default('EUR'),
                Forms\Components\Select::make('discount_type')
                    ->options([
                        'fixed' => '€ Fixed Amount',
                        'percentage' => '% Percentage',
                    ])->placeholder('No discount'),
                Forms\Components\TextInput::make('discount_amount')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('payment_terms')
                    ->placeholder('e.g. Net 30 days')
                    ->default('Net 30'),
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
                    ->disabled()->dehydrated(),
                Forms\Components\TextInput::make('amount_paid')
                    ->numeric()->prefix('€')
                    ->disabled()->dehydrated()
                    ->helperText('Auto-calculated from payments'),
                Forms\Components\TextInput::make('balance_due')
                    ->numeric()->prefix('€')
                    ->disabled()->dehydrated(),
            ])->columns(5),

            Forms\Components\Section::make('Notes & Terms')->schema([
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
                    ->searchable()->sortable()->weight('bold')
                    ->copyable(),
                Tables\Columns\TextColumn::make('client.name')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('issue_date')
                    ->date()->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->color(fn($record) => $record->is_overdue ? 'danger' : null)
                    ->tooltip(fn($record) => match ($record->due_status) {
                        'overdue' => '⚠️ ' . abs($record->days_until_due) . ' days overdue!',
                        'due_soon' => '⏰ Due in ' . $record->days_until_due . ' days',
                        'paid' => '✅ Paid',
                        default => null,
                    }),
                Tables\Columns\TextColumn::make('total')
                    ->money('EUR')->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('balance_due')
                    ->money('EUR')
                    ->color(fn($state) => $state > 0 ? 'danger' : 'success')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('payment_progress')
                    ->label('Paid %')
                    ->getStateUsing(fn($record) => $record->payment_progress . '%')
                    ->badge()
                    ->color(fn($record) => match (true) {
                        $record->payment_progress >= 100 => 'success',
                        $record->payment_progress > 0 => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'info' => 'sent',
                        'warning' => fn($state) => in_array($state, ['partial', 'cancelled']),
                        'success' => 'paid',
                        'danger' => 'overdue',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('send_email')
                    ->label('Send to Client')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalDescription('Send this invoice via email to the client?')
                    ->action(function (Invoice $record) {
                        if ($record->client?->email) {
                            try {
                                Mail::to($record->client->email)
                                    ->send(new InvoiceSent($record));

                                $record->update([
                                    'status' => $record->status === 'draft' ? 'sent' : $record->status,
                                    'sent_at' => now(),
                                ]);

                                // Notify client user
                                $clientUser = User::where('client_id', $record->client_id)->first();
                                if ($clientUser) {
                                    AppNotification::notify(
                                        $clientUser->id,
                                        'invoice_sent',
                                        '📄 New Invoice: ' . $record->invoice_number,
                                        'Amount: €' . number_format($record->total, 2) . ' — Due: ' . $record->due_date?->format('M d, Y'),
                                        '/portal/client-invoices/' . $record->id
                                    );
                                }
                            } catch (\Exception $e) {
                                // Silent fail
                            }
                        }
                    })
                    ->hidden(fn(Invoice $record) => !$record->client?->email),

                Tables\Actions\Action::make('send_reminder')
                    ->label('Send Reminder')
                    ->icon('heroicon-o-bell-alert')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function (Invoice $record) {
                        if ($record->client?->email) {
                            try {
                                Mail::to($record->client->email)
                                    ->send(new InvoiceSent($record));
                                $record->update(['reminder_sent_at' => now()]);
                            } catch (\Exception $e) {
                            }
                        }
                    })
                    ->hidden(fn(Invoice $record) => in_array($record->status, ['paid', 'draft', 'cancelled'])),

                Tables\Actions\Action::make('record_payment')
                    ->label('Record Payment')
                    ->icon('heroicon-o-credit-card')
                    ->color('success')
                    ->form([
                        Forms\Components\TextInput::make('amount')
                            ->numeric()->prefix('€')->required()
                            ->default(fn(Invoice $record) => $record->balance_due),
                        Forms\Components\DatePicker::make('payment_date')
                            ->required()->default(now()),
                        Forms\Components\Select::make('method')
                            ->options(\App\Models\Payment::getMethodOptions())
                            ->default('bank_transfer')->required(),
                        Forms\Components\TextInput::make('reference')
                            ->placeholder('Transaction ID'),
                    ])
                    ->action(function (Invoice $record, array $data) {
                        \App\Models\Payment::create([
                            'invoice_id' => $record->id,
                            'client_id' => $record->client_id,
                            'amount' => $data['amount'],
                            'payment_date' => $data['payment_date'],
                            'method' => $data['method'],
                            'reference' => $data['reference'] ?? null,
                        ]);
                    })
                    ->hidden(fn(Invoice $record) => in_array($record->status, ['paid', 'cancelled'])),

                Tables\Actions\Action::make('markPaid')
                    ->label('Mark Paid')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn(Invoice $record) => $record->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                        'amount_paid' => $record->total,
                        'balance_due' => 0,
                    ]))
                    ->hidden(fn(Invoice $record) => $record->status === 'paid'),

                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'sent' => 'Sent',
                        'partial' => 'Partially Paid',
                        'paid' => 'Paid',
                        'overdue' => 'Overdue',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('client')
                    ->relationship('client', 'name'),
                Tables\Filters\Filter::make('overdue')
                    ->label('Overdue Only')
                    ->query(fn($query) => $query->overdue()),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
