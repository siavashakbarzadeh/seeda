<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecurringInvoiceResource\Pages;
use App\Models\RecurringInvoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RecurringInvoiceResource extends Resource
{
    protected static ?string $model = RecurringInvoice::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';
    protected static ?string $navigationGroup = 'Business';
    protected static ?string $navigationLabel = 'Recurring Invoices';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Recurring Invoice')->schema([
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->searchable()->preload()->required(),

                Forms\Components\TextInput::make('title')
                    ->required()->placeholder('e.g. Monthly Hosting'),

                Forms\Components\Select::make('frequency')
                    ->options([
                        'weekly' => '📅 Weekly',
                        'monthly' => '🗓️ Monthly',
                        'quarterly' => '📆 Quarterly',
                        'yearly' => '📅 Yearly',
                    ])->default('monthly')->required(),

                Forms\Components\TextInput::make('amount')
                    ->numeric()->prefix('€')->required(),

                Forms\Components\TextInput::make('tax_rate')
                    ->numeric()->suffix('%')->default(22),

                Forms\Components\DatePicker::make('next_issue_date')
                    ->required()->default(now()->startOfMonth()->addMonth()),

                Forms\Components\DatePicker::make('end_date')
                    ->placeholder('Leave empty for infinite'),

                Forms\Components\TextInput::make('occurrences_left')
                    ->numeric()->placeholder('Leave empty for infinite'),

                Forms\Components\Toggle::make('is_active')->default(true),
                Forms\Components\Toggle::make('auto_send')
                    ->label('Auto-send to client')
                    ->helperText('Automatically email invoices when generated'),

                Forms\Components\Textarea::make('notes')->rows(2)->columnSpanFull(),
            ])->columns(3),

            Forms\Components\Section::make('Line Items')->schema([
                Forms\Components\Repeater::make('items')
                    ->schema([
                        Forms\Components\TextInput::make('description')
                            ->required()->columnSpan(3),
                        Forms\Components\TextInput::make('quantity')
                            ->numeric()->default(1)->columnSpan(1),
                        Forms\Components\TextInput::make('unit_price')
                            ->numeric()->prefix('€')->columnSpan(1),
                    ])
                    ->columns(5)
                    ->defaultItems(1)
                    ->addActionLabel('+ Add Item'),
            ])->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('client.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('frequency')
                    ->badge()->color('info'),
                Tables\Columns\TextColumn::make('amount')
                    ->money('EUR')->weight('bold'),
                Tables\Columns\TextColumn::make('next_issue_date')
                    ->date()->sortable()
                    ->color(fn($record) => $record->next_issue_date?->lte(now()) ? 'danger' : null),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\IconColumn::make('auto_send')->boolean(),
                Tables\Columns\TextColumn::make('invoices_count')
                    ->counts('invoices')
                    ->label('Generated')
                    ->badge()->color('gray'),
            ])
            ->defaultSort('next_issue_date')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('generate_now')
                    ->label('Generate Invoice')
                    ->icon('heroicon-o-document-plus')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn(RecurringInvoice $record) => $record->generateInvoice())
                    ->hidden(fn(RecurringInvoice $record) => !$record->is_active),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecurringInvoices::route('/'),
            'create' => Pages\CreateRecurringInvoice::route('/create'),
            'edit' => Pages\EditRecurringInvoice::route('/{record}/edit'),
        ];
    }
}
