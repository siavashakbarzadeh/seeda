<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LandingSectionResource\Pages;
use App\Models\LandingSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LandingSectionResource extends Resource
{
    use Translatable;

    protected static ?string $model = LandingSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Landing Page';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('key')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->helperText('Unique identifier: hero, services_intro, about_intro, cta, etc.')
                    ->maxLength(255),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]),
            Forms\Components\TextInput::make('title')
                ->maxLength(255)
                ->columnSpanFull(),
            Forms\Components\TextInput::make('subtitle')
                ->maxLength(500)
                ->columnSpanFull(),
            Forms\Components\RichEditor::make('content')
                ->columnSpanFull(),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('button_text')
                    ->maxLength(255),
                Forms\Components\TextInput::make('button_link')
                    ->maxLength(255),
            ]),
            Forms\Components\FileUpload::make('image')
                ->image()
                ->directory('landing'),
            Forms\Components\Toggle::make('is_active')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->searchable()
                    ->sortable()
                    ->badge(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLandingSections::route('/'),
            'create' => Pages\CreateLandingSection::route('/create'),
            'edit' => Pages\EditLandingSection::route('/{record}/edit'),
        ];
    }
}
