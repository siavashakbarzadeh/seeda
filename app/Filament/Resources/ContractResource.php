<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContractResource\Pages;
use App\Models\Contract;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static ?string $navigationGroup = 'Business';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Contract Details')->schema([
                Forms\Components\TextInput::make('title')
                    ->required()->maxLength(255),
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->searchable()->preload(),
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name')
                    ->searchable()->preload(),
                Forms\Components\Select::make('type')
                    ->options([
                        'fixed_price' => '💰 Fixed Price',
                        'hourly' => '⏱️ Hourly',
                        'retainer' => '🔄 Retainer',
                        'maintenance' => '🔧 Maintenance',
                        'nda' => '🔒 NDA',
                        'other' => '📄 Other',
                    ])->default('fixed_price')->required(),
                Forms\Components\TextInput::make('value')
                    ->numeric()->prefix('€'),
                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => '📝 Draft',
                        'sent' => '📤 Sent',
                        'active' => '✅ Active',
                        'expired' => '⏰ Expired',
                        'terminated' => '❌ Terminated',
                    ])->default('draft')->required(),
                Forms\Components\DatePicker::make('start_date'),
                Forms\Components\DatePicker::make('end_date'),
            ])->columns(2),

            Forms\Components\Section::make('Document')->schema([
                Forms\Components\FileUpload::make('file_path')
                    ->label('Contract File')
                    ->directory('contracts')
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxSize(10240),
                Forms\Components\Textarea::make('notes')
                    ->rows(3)->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('client.name')->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()->color('gray'),
                Tables\Columns\TextColumn::make('value')->money('EUR'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'info' => 'sent',
                        'success' => 'active',
                        'warning' => 'expired',
                        'danger' => 'terminated',
                    ]),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->color(fn($record) => $record->is_expired ? 'danger' : null),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['draft' => 'Draft', 'sent' => 'Sent', 'active' => 'Active', 'expired' => 'Expired']),
                Tables\Filters\SelectFilter::make('type')
                    ->options(['fixed_price' => 'Fixed Price', 'hourly' => 'Hourly', 'retainer' => 'Retainer', 'maintenance' => 'Maintenance']),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContracts::route('/'),
            'create' => Pages\CreateContract::route('/create'),
            'edit' => Pages\EditContract::route('/{record}/edit'),
        ];
    }
}
