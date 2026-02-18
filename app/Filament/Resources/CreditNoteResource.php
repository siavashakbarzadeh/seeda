<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CreditNoteResource\Pages;
use App\Models\CreditNote;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CreditNoteResource extends Resource
{
    protected static ?string $model = CreditNote::class;
    protected static ?string $navigationIcon = 'heroicon-o-receipt-refund';
    protected static ?string $navigationGroup = 'Business';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Credit Note')->schema([
                Forms\Components\TextInput::make('credit_number')
                    ->required()
                    ->default(fn() => CreditNote::generateNumber())
                    ->unique(ignoreRecord: true),

                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->searchable()->preload()->required()
                    ->reactive()
                    ->afterStateUpdated(fn($set) => $set('invoice_id', null)),

                Forms\Components\Select::make('invoice_id')
                    ->label('Related Invoice')
                    ->relationship(
                        'invoice',
                        'invoice_number',
                        fn($query, $get) => $get('client_id')
                        ? $query->where('client_id', $get('client_id'))
                        : $query
                    )
                    ->searchable()->preload()
                    ->placeholder('Select invoice (optional)'),

                Forms\Components\DatePicker::make('issue_date')
                    ->required()->default(now()),

                Forms\Components\TextInput::make('amount')
                    ->numeric()->prefix('€')->required(),

                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => '📝 Draft',
                        'issued' => '📤 Issued',
                        'applied' => '✅ Applied',
                        'refunded' => '💰 Refunded',
                    ])->default('draft')->required(),

                Forms\Components\Textarea::make('reason')
                    ->required()->rows(3)->columnSpanFull()
                    ->placeholder('Reason for credit note...'),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('credit_number')
                    ->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('client.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('invoice.invoice_number')
                    ->default('—'),
                Tables\Columns\TextColumn::make('issue_date')
                    ->date()->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('EUR')->weight('bold')->color('danger'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'info' => 'issued',
                        'success' => 'applied',
                        'warning' => 'refunded',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'issued' => 'Issued',
                        'applied' => 'Applied',
                        'refunded' => 'Refunded',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCreditNotes::route('/'),
            'create' => Pages\CreateCreditNote::route('/create'),
            'edit' => Pages\EditCreditNote::route('/{record}/edit'),
        ];
    }
}
