<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadInteractionResource\Pages;
use App\Models\LeadInteraction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeadInteractionResource extends Resource
{
    protected static ?string $model = LeadInteraction::class;
    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-rays';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $navigationLabel = 'Behavioral Tracking';
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Interaction Details')->schema([
                Forms\Components\TextInput::make('session_id')
                    ->required()->maxLength(255),
                Forms\Components\Select::make('lead_id')
                    ->relationship('lead', 'name')
                    ->searchable()->preload()
                    ->placeholder('Anonymous if not linked'),
                Forms\Components\TextInput::make('url')
                    ->required()->url()->prefix('https://'),
                Forms\Components\Select::make('action')
                    ->options([
                        'page_view' => '👀 Page View',
                        'view_pricing' => '💶 View Pricing',
                        'download_case_study' => '📄 Download Case Study',
                        'click_cta' => '🖱️ Click CTA',
                        'form_start' => '📝 Form Start',
                        'form_submit' => '✅ Form Submit',
                        'exit_intent' => '🚪 Exit Intent',
                        'video_play' => '▶️ Video Play',
                        'scroll_depth' => '📜 Scroll Depth',
                    ])->required()->searchable(),
                Forms\Components\TextInput::make('points')
                    ->numeric()->default(0)
                    ->helperText('Lead scoring points awarded for this action'),
                Forms\Components\KeyValue::make('meta')
                    ->label('Extra Data')
                    ->helperText('e.g. referrer, device, duration'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('session_id')
                    ->fontFamily('mono')->limit(12)->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('lead.name')
                    ->label('Lead')->default('Anonymous')
                    ->searchable(),
                Tables\Columns\TextColumn::make('url')
                    ->limit(30)->copyable(),
                Tables\Columns\TextColumn::make('action')
                    ->badge()
                    ->colors([
                        'info' => fn($state) => in_array($state, ['page_view', 'scroll_depth']),
                        'primary' => fn($state) => in_array($state, ['view_pricing', 'click_cta']),
                        'success' => fn($state) => in_array($state, ['form_submit', 'download_case_study']),
                        'warning' => fn($state) => in_array($state, ['form_start', 'video_play']),
                        'danger' => 'exit_intent',
                    ]),
                Tables\Columns\TextColumn::make('points')
                    ->badge()->color('success')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('action')
                    ->options([
                        'page_view' => 'Page View',
                        'view_pricing' => 'View Pricing',
                        'download_case_study' => 'Download Case Study',
                        'click_cta' => 'Click CTA',
                        'form_start' => 'Form Start',
                        'form_submit' => 'Form Submit',
                        'exit_intent' => 'Exit Intent',
                    ]),
                Tables\Filters\SelectFilter::make('lead')
                    ->relationship('lead', 'name'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeadInteractions::route('/'),
            'create' => Pages\CreateLeadInteraction::route('/create'),
            'edit' => Pages\EditLeadInteraction::route('/{record}/edit'),
        ];
    }
}
