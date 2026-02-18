<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Business';
    protected static ?int $navigationSort = 5;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Expense Details')->schema([
                Forms\Components\TextInput::make('description')
                    ->required()->maxLength(255)->columnSpanFull(),
                Forms\Components\TextInput::make('amount')
                    ->numeric()->required()->prefix('€'),
                Forms\Components\Select::make('category')
                    ->options(Expense::getCategoryOptions())
                    ->default('other')->required()->searchable(),
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name')
                    ->searchable()->preload()->placeholder('No project'),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->default(fn() => auth()->id())
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->required()->default(now()),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => '⏳ Pending',
                        'approved' => '✅ Approved',
                        'rejected' => '❌ Rejected',
                        'reimbursed' => '💰 Reimbursed',
                    ])->default('pending')->required(),
                Forms\Components\Toggle::make('is_reimbursable')
                    ->inline(),
                Forms\Components\FileUpload::make('receipt_path')
                    ->label('Receipt / Proof')
                    ->directory('receipts')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize(5120),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')->date()->sortable(),
                Tables\Columns\TextColumn::make('description')->searchable()->limit(35),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->formatStateUsing(fn($state) => Expense::getCategoryOptions()[$state] ?? $state),
                Tables\Columns\TextColumn::make('project.name')
                    ->default('—')->toggleable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('By'),
                Tables\Columns\TextColumn::make('amount')
                    ->money('EUR')->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'info' => 'reimbursed',
                    ]),
                Tables\Columns\IconColumn::make('is_reimbursable')->boolean(),
                Tables\Columns\IconColumn::make('receipt_path')
                    ->label('📎')
                    ->icon(fn($state) => $state ? 'heroicon-s-paper-clip' : 'heroicon-o-minus')
                    ->color(fn($state) => $state ? 'success' : 'gray'),
            ])
            ->defaultSort('date', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('approve')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn(Expense $record) => $record->update(['status' => 'approved']))
                    ->hidden(fn(Expense $record) => $record->status !== 'pending'),

                Tables\Actions\Action::make('reject')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn(Expense $record) => $record->update(['status' => 'rejected']))
                    ->hidden(fn(Expense $record) => $record->status !== 'pending'),

                Tables\Actions\Action::make('reimburse')
                    ->icon('heroicon-o-banknotes')
                    ->color('info')
                    ->requiresConfirmation()
                    ->action(fn(Expense $record) => $record->update(['status' => 'reimbursed']))
                    ->hidden(fn(Expense $record) => !($record->status === 'approved' && $record->is_reimbursable)),

                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options(Expense::getCategoryOptions()),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'reimbursed' => 'Reimbursed',
                    ]),
                Tables\Filters\SelectFilter::make('project')
                    ->relationship('project', 'name'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkAction::make('bulk_approve')
                    ->label('Approve Selected')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn($records) => $records->each->update(['status' => 'approved'])),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
