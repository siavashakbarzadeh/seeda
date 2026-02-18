<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeoKeywordResource\Pages;
use App\Models\SeoKeyword;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SeoKeywordResource extends Resource
{
    protected static ?string $model = SeoKeyword::class;
    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass-circle';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $navigationLabel = 'SEO Keywords';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Keyword Info')->schema([
                Forms\Components\TextInput::make('keyword')
                    ->required()->maxLength(255)->placeholder('e.g. web development agency'),
                Forms\Components\TextInput::make('target_page')
                    ->url()->prefix('https://')
                    ->placeholder('Page being ranked'),
                Forms\Components\Select::make('status')
                    ->options([
                        'tracking' => '📡 Tracking',
                        'paused' => '⏸️ Paused',
                        'archived' => '📦 Archived',
                    ])->default('tracking'),
                Forms\Components\Select::make('campaign_id')
                    ->relationship('campaign', 'name')
                    ->searchable()->preload()
                    ->placeholder('Linked campaign'),
            ])->columns(2),

            Forms\Components\Section::make('Rankings')->schema([
                Forms\Components\TextInput::make('current_position')
                    ->numeric()->placeholder('Current Google position'),
                Forms\Components\TextInput::make('previous_position')
                    ->numeric()->placeholder('Previous position'),
                Forms\Components\TextInput::make('best_position')
                    ->numeric()->placeholder('Best ever position'),
            ])->columns(3),

            Forms\Components\Section::make('Market Data')->schema([
                Forms\Components\TextInput::make('search_volume')
                    ->numeric()->placeholder('Monthly searches'),
                Forms\Components\TextInput::make('difficulty')
                    ->numeric()->placeholder('0-100')
                    ->minValue(0)->maxValue(100),
                Forms\Components\TextInput::make('cpc')
                    ->numeric()->prefix('€')
                    ->placeholder('Estimated CPC'),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('keyword')
                    ->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('current_position')
                    ->label('🏆 Position')
                    ->badge()
                    ->color(fn($record) => match (true) {
                        !$record->current_position => 'gray',
                        $record->current_position <= 3 => 'success',
                        $record->current_position <= 10 => 'info',
                        $record->current_position <= 30 => 'warning',
                        default => 'danger',
                    })
                    ->default('—'),
                Tables\Columns\TextColumn::make('position_trend')
                    ->label('📈 Trend')
                    ->getStateUsing(fn($record) => $record->position_trend)
                    ->badge()
                    ->color(fn($record) => match (true) {
                        $record->position_change > 0 => 'success',
                        $record->position_change < 0 => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('best_position')
                    ->label('⭐ Best')->default('—'),
                Tables\Columns\TextColumn::make('search_volume')
                    ->label('🔍 Vol.')
                    ->numeric()
                    ->sortable()->default('—'),
                Tables\Columns\TextColumn::make('difficulty_label')
                    ->label('💪 Difficulty')
                    ->getStateUsing(fn($record) => $record->difficulty_label),
                Tables\Columns\TextColumn::make('cpc')
                    ->money('EUR')->label('💶 CPC')->default('—'),
                Tables\Columns\TextColumn::make('target_page')
                    ->label('Page')->limit(25)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'tracking',
                        'warning' => 'paused',
                        'gray' => 'archived',
                    ]),
            ])
            ->defaultSort('current_position', 'asc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('update_ranking')
                    ->label('Update Position')
                    ->icon('heroicon-o-arrow-path')
                    ->color('info')
                    ->form([
                        Forms\Components\TextInput::make('new_position')
                            ->label('New Position')
                            ->numeric()->required(),
                    ])
                    ->action(function (SeoKeyword $record, array $data) {
                        $record->update([
                            'previous_position' => $record->current_position,
                            'current_position' => $data['new_position'],
                            'best_position' => min($data['new_position'], $record->best_position ?? 999),
                            'last_checked_at' => now(),
                        ]);
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'tracking' => 'Tracking',
                        'paused' => 'Paused',
                        'archived' => 'Archived',
                    ]),
                Tables\Filters\Filter::make('top_10')
                    ->label('Top 10')
                    ->query(fn($query) => $query->topRanking(10)),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSeoKeywords::route('/'),
            'create' => Pages\CreateSeoKeyword::route('/create'),
            'edit' => Pages\EditSeoKeyword::route('/{record}/edit'),
        ];
    }
}
