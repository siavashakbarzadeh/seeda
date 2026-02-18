<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebsiteResource\Pages;
use App\Models\Website;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WebsiteResource extends Resource
{
    protected static ?string $model = Website::class;
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationGroup = 'Business';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Website Details')->schema([
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required(),
                        Forms\Components\TextInput::make('email')->email(),
                        Forms\Components\TextInput::make('company'),
                    ]),
                Forms\Components\TextInput::make('name')
                    ->required()->maxLength(255)
                    ->placeholder('e.g. Client Portfolio Site'),
                Forms\Components\TextInput::make('domain')
                    ->placeholder('example.com')
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => '🟢 Active',
                        'maintenance' => '🟡 Maintenance',
                        'development' => '🔵 Development',
                        'suspended' => '🔴 Suspended',
                        'archived' => '⚫ Archived',
                    ])->default('active')->required(),
            ])->columns(2),

            Forms\Components\Section::make('Hosting & Domain')->schema([
                Forms\Components\TextInput::make('hosting_provider')
                    ->placeholder('e.g. Hetzner, AWS, Aruba'),
                Forms\Components\DatePicker::make('hosting_expiry'),
                Forms\Components\DatePicker::make('domain_expiry'),
                Forms\Components\TextInput::make('monthly_cost')
                    ->numeric()->prefix('€')
                    ->placeholder('0.00'),
            ])->columns(2),

            Forms\Components\Section::make('Technical')->schema([
                Forms\Components\TagsInput::make('tech_stack')
                    ->placeholder('Laravel, React, MySQL...'),
                Forms\Components\Textarea::make('notes')->rows(3),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.name')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('domain')
                    ->url(fn($record) => $record->domain ? "https://{$record->domain}" : null, true)
                    ->color('primary'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'active',
                        'warning' => 'maintenance',
                        'info' => 'development',
                        'danger' => 'suspended',
                        'gray' => 'archived',
                    ]),
                Tables\Columns\TextColumn::make('hosting_expiry')
                    ->date()
                    ->color(fn($record) => $record->is_expiring_soon ? 'danger' : null),
                Tables\Columns\TextColumn::make('monthly_cost')
                    ->money('EUR')
                    ->sortable(),
            ])
            ->defaultSort('client.name')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'maintenance' => 'Maintenance',
                        'development' => 'Development',
                        'suspended' => 'Suspended',
                        'archived' => 'Archived',
                    ]),
                Tables\Filters\SelectFilter::make('client')
                    ->relationship('client', 'name'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWebsites::route('/'),
            'create' => Pages\CreateWebsite::route('/create'),
            'edit' => Pages\EditWebsite::route('/{record}/edit'),
        ];
    }
}
