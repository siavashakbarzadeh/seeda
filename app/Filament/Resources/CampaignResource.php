<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CampaignResource\Pages;
use App\Models\Campaign;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;
    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Campaign Details')->schema([
                Forms\Components\TextInput::make('name')
                    ->required()->maxLength(255),
                Forms\Components\Select::make('type')
                    ->options(Campaign::getTypeOptions())
                    ->required()->searchable(),
                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => '📝 Draft',
                        'active' => '▶️ Active',
                        'paused' => '⏸️ Paused',
                        'completed' => '✅ Completed',
                        'cancelled' => '❌ Cancelled',
                    ])->default('draft')->required(),
                Forms\Components\TextInput::make('budget')
                    ->numeric()->prefix('€'),
                Forms\Components\TextInput::make('spent')
                    ->numeric()->prefix('€')->default(0),
                Forms\Components\DatePicker::make('start_date'),
                Forms\Components\DatePicker::make('end_date'),
                Forms\Components\TextInput::make('target_url')
                    ->url()->prefix('https://'),
                Forms\Components\TagsInput::make('tags'),
            ])->columns(3),

            Forms\Components\Section::make('UTM Parameters')->schema([
                Forms\Components\TextInput::make('utm_source')->placeholder('e.g. google'),
                Forms\Components\TextInput::make('utm_medium')->placeholder('e.g. cpc'),
                Forms\Components\TextInput::make('utm_campaign')->placeholder('e.g. spring_sale'),
            ])->columns(3)->collapsible()->collapsed(),

            Forms\Components\Section::make('Performance Metrics')->schema([
                Forms\Components\TextInput::make('impressions')
                    ->numeric()->default(0),
                Forms\Components\TextInput::make('clicks')
                    ->numeric()->default(0),
                Forms\Components\TextInput::make('conversions')
                    ->numeric()->default(0),
                Forms\Components\TextInput::make('revenue_generated')
                    ->numeric()->prefix('€')->default(0),
            ])->columns(4)->collapsible(),

            Forms\Components\Section::make('Description')->schema([
                Forms\Components\Textarea::make('description')
                    ->rows(3)->columnSpanFull(),
            ])->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn($state) => Campaign::getTypeOptions()[$state] ?? $state),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'active',
                        'warning' => 'paused',
                        'info' => 'completed',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('budget')
                    ->money('EUR')->default('—'),
                Tables\Columns\TextColumn::make('spent')
                    ->money('EUR')
                    ->color(fn($record) => $record->budget && $record->spent > $record->budget ? 'danger' : null),
                Tables\Columns\TextColumn::make('budget_used_percent')
                    ->label('Budget %')
                    ->getStateUsing(fn($record) => $record->budget_used_percent . '%')
                    ->badge()
                    ->color(fn($record) => match (true) {
                        $record->budget_used_percent >= 90 => 'danger',
                        $record->budget_used_percent >= 60 => 'warning',
                        default => 'success',
                    }),
                Tables\Columns\TextColumn::make('clicks')
                    ->numeric()->sortable(),
                Tables\Columns\TextColumn::make('conversions')
                    ->numeric()->sortable()
                    ->color('success'),
                Tables\Columns\TextColumn::make('roi')
                    ->getStateUsing(fn($record) => $record->roi . '%')
                    ->badge()
                    ->color(fn($record) => $record->roi > 0 ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('leads_count')
                    ->counts('leads')
                    ->label('Leads')
                    ->badge()->color('info'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('activate')
                    ->icon('heroicon-o-play')
                    ->color('success')
                    ->action(fn(Campaign $r) => $r->update(['status' => 'active']))
                    ->hidden(fn(Campaign $r) => $r->status === 'active'),
                Tables\Actions\Action::make('pause')
                    ->icon('heroicon-o-pause')
                    ->color('warning')
                    ->action(fn(Campaign $r) => $r->update(['status' => 'paused']))
                    ->hidden(fn(Campaign $r) => $r->status !== 'active'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options(Campaign::getTypeOptions()),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Active',
                        'paused' => 'Paused',
                        'completed' => 'Completed',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCampaigns::route('/'),
            'create' => Pages\CreateCampaign::route('/create'),
            'edit' => Pages\EditCampaign::route('/{record}/edit'),
        ];
    }
}
