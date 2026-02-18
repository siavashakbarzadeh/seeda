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

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Expense Details')->schema([
                Forms\Components\TextInput::make('description')
                    ->required()->maxLength(255),
                Forms\Components\TextInput::make('amount')
                    ->numeric()->required()->prefix('€'),
                Forms\Components\Select::make('category')
                    ->options([
                        'software' => '💻 Software',
                        'hardware' => '🖥️ Hardware',
                        'hosting' => '☁️ Hosting',
                        'domain' => '🌐 Domain',
                        'marketing' => '📢 Marketing',
                        'travel' => '✈️ Travel',
                        'office' => '🏢 Office',
                        'subscription' => '🔄 Subscription',
                        'freelancer' => '👤 Freelancer',
                        'other' => '📦 Other',
                    ])->default('other')->required(),
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name')
                    ->searchable()->preload()->placeholder('No project'),
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
                    ->label('Receipt')
                    ->directory('receipts')
                    ->image()
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
                    ->badge()->color('gray'),
                Tables\Columns\TextColumn::make('project.name')
                    ->default('—'),
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
            ])
            ->defaultSort('date', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'software' => 'Software',
                        'hardware' => 'Hardware',
                        'hosting' => 'Hosting',
                        'domain' => 'Domain',
                        'marketing' => 'Marketing',
                        'subscription' => 'Subscription',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected']),
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
