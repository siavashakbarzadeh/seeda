<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Business';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Payment Details')->schema([
                Forms\Components\Select::make('invoice_id')
                    ->relationship('invoice', 'invoice_number')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set) {
                        if ($state) {
                            $invoice = \App\Models\Invoice::find($state);
                            if ($invoice) {
                                $set('client_id', $invoice->client_id);
                                $set('amount', $invoice->balance_due);
                            }
                        }
                    }),

                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->prefix('€')
                    ->step(0.01),

                Forms\Components\DatePicker::make('payment_date')
                    ->required()
                    ->default(now()),

                Forms\Components\Select::make('method')
                    ->options(Payment::getMethodOptions())
                    ->default('bank_transfer')
                    ->required(),

                Forms\Components\TextInput::make('reference')
                    ->placeholder('Transaction ID / Check number'),

                Forms\Components\FileUpload::make('receipt_path')
                    ->label('Receipt')
                    ->directory('payment-receipts')
                    ->maxSize(5120),

                Forms\Components\Textarea::make('notes')
                    ->rows(2)
                    ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payment_date')
                    ->date()->sortable(),
                Tables\Columns\TextColumn::make('invoice.invoice_number')
                    ->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('client.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('EUR')->sortable()->weight('bold')
                    ->color('success'),
                Tables\Columns\TextColumn::make('method')
                    ->badge()
                    ->formatStateUsing(fn($state) => Payment::getMethodOptions()[$state] ?? $state),
                Tables\Columns\TextColumn::make('reference')
                    ->limit(20)->default('—'),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()->sortable(),
            ])
            ->defaultSort('payment_date', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('method')
                    ->options(Payment::getMethodOptions()),
                Tables\Filters\SelectFilter::make('client')
                    ->relationship('client', 'name'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
