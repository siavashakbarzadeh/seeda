<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmailListResource\Pages;
use App\Models\EmailList;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmailListResource extends Resource
{
    protected static ?string $model = EmailList::class;
    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $navigationLabel = 'Email Lists (Segments)';
    protected static ?int $navigationSort = 13;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('List Info')->schema([
                Forms\Components\TextInput::make('name')
                    ->required()->maxLength(255)->placeholder('e.g. SaaS Founders 2024'),
                Forms\Components\ColorPicker::make('color')->default('#3b82f6'),
                Forms\Components\Textarea::make('description')->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Subscribers')->schema([
                Forms\Components\Select::make('subscribers')
                    ->relationship('subscribers', 'email')
                    ->multiple()->searchable()->preload()
                    ->placeholder('Add subscribers to this list'),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->weight('bold'),
                Tables\Columns\ColorColumn::make('color'),
                Tables\Columns\TextColumn::make('subscribers_count')
                    ->counts('subscribers')->label('Members')->badge()->color('info'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('M d, Y'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmailLists::route('/'),
            'create' => Pages\CreateEmailList::route('/create'),
            'edit' => Pages\EditEmailList::route('/{record}/edit'),
        ];
    }
}
