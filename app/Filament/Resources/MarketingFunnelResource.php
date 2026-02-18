<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MarketingFunnelResource\Pages;
use App\Models\MarketingFunnel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MarketingFunnelResource extends Resource
{
    protected static ?string $model = MarketingFunnel::class;
    protected static ?string $navigationIcon = 'heroicon-o-funnel';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $navigationLabel = 'Funnels/Assets';
    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Asset Content')->schema([
                Forms\Components\TextInput::make('name')
                    ->required()->maxLength(255)->placeholder('e.g. 2024 Software Pricing Guide'),
                Forms\Components\TextInput::make('slug')
                    ->required()->maxLength(255)->unique(ignoreRecord: true)
                    ->prefix('seeda.dev/l/'),
                Forms\Components\Select::make('type')
                    ->options(MarketingFunnel::getTypeOptions())
                    ->required(),
                Forms\Components\FileUpload::make('file_path')
                    ->label('Resource File (PDF/Docs)')
                    ->directory('marketing-funnels')
                    ->required(),
                Forms\Components\Toggle::make('is_locked')
                    ->label('Gated Content (Requires Lead Capture)')
                    ->default(true)
                    ->helperText('Users must provide contact info to access this file'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('type')
                    ->badge()->formatStateUsing(fn($state) => MarketingFunnel::getTypeOptions()[$state] ?? $state),
                Tables\Columns\IconColumn::make('is_locked')
                    ->boolean()->label('Gated'),
                Tables\Columns\TextColumn::make('conversions')
                    ->label('Leads Generated')
                    ->badge()->color('success')->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Tracking URL')
                    ->fontFamily('mono')->copyable()
                    ->formatStateUsing(fn($state) => 'seeda.dev/l/' . $state),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMarketingFunnels::route('/'),
            'create' => Pages\CreateMarketingFunnel::route('/create'),
            'edit' => Pages\EditMarketingFunnel::route('/{record}/edit'),
        ];
    }
}
