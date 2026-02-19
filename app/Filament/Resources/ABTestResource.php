<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ABTestResource\Pages;
use App\Models\ABTest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ABTestResource extends Resource
{
    protected static ?string $model = ABTest::class;
    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $navigationLabel = 'A/B Tests';
    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Test Setup')->schema([
                Forms\Components\TextInput::make('name')
                    ->required()->maxLength(255)
                    ->placeholder('e.g. Landing Page Headline Test'),
                Forms\Components\Select::make('campaign_id')
                    ->relationship('campaign', 'name')
                    ->searchable()->preload()
                    ->placeholder('Link to campaign (optional)'),
                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => '📝 Draft',
                        'running' => '▶️ Running',
                        'completed' => '✅ Completed',
                    ])->default('draft')->required(),
                Forms\Components\Textarea::make('description')
                    ->rows(2)->columnSpanFull(),
            ])->columns(3),

            Forms\Components\Section::make('Variants')->schema([
                Forms\Components\TextInput::make('variant_a_label')
                    ->default('Variant A')->required()
                    ->placeholder('e.g. Green CTA Button'),
                Forms\Components\TextInput::make('variant_b_label')
                    ->default('Variant B')->required()
                    ->placeholder('e.g. Blue CTA Button'),
                Forms\Components\DatePicker::make('start_date'),
                Forms\Components\DatePicker::make('end_date'),
            ])->columns(2),

            Forms\Components\Section::make('Results')
                ->schema([
                    Forms\Components\TextInput::make('variant_a_views')
                        ->numeric()->default(0)->label('A — Views'),
                    Forms\Components\TextInput::make('variant_a_conversions')
                        ->numeric()->default(0)->label('A — Conversions'),
                    Forms\Components\TextInput::make('variant_b_views')
                        ->numeric()->default(0)->label('B — Views'),
                    Forms\Components\TextInput::make('variant_b_conversions')
                        ->numeric()->default(0)->label('B — Conversions'),
                    Forms\Components\Select::make('winner')
                        ->options([
                            'a' => '🏆 Variant A',
                            'b' => '🏆 Variant B',
                        ])->placeholder('Not decided yet'),
                ])->columns(5)->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('campaign.name')
                    ->label('Campaign')->default('—'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'running',
                        'info' => 'completed',
                    ]),
                Tables\Columns\TextColumn::make('variant_a_label')
                    ->label('Variant A'),
                Tables\Columns\TextColumn::make('variant_a_conversion_rate')
                    ->label('A Rate')
                    ->getStateUsing(fn($record) => $record->variant_a_conversion_rate . '%')
                    ->badge()
                    ->color(fn($record) => $record->winner === 'a' ? 'success' : 'gray'),
                Tables\Columns\TextColumn::make('variant_b_label')
                    ->label('Variant B'),
                Tables\Columns\TextColumn::make('variant_b_conversion_rate')
                    ->label('B Rate')
                    ->getStateUsing(fn($record) => $record->variant_b_conversion_rate . '%')
                    ->badge()
                    ->color(fn($record) => $record->winner === 'b' ? 'success' : 'gray'),
                Tables\Columns\TextColumn::make('confidence_level')
                    ->label('Confidence')
                    ->getStateUsing(fn($record) => $record->confidence_level)
                    ->badge()
                    ->colors([
                        'danger' => 'Low',
                        'warning' => 'Medium',
                        'success' => 'High',
                    ]),
                Tables\Columns\TextColumn::make('winner')
                    ->formatStateUsing(fn($state, $record) => match ($state) {
                        'a' => '🏆 ' . $record->variant_a_label,
                        'b' => '🏆 ' . $record->variant_b_label,
                        default => '—',
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('start')
                    ->label('Start Test')
                    ->icon('heroicon-o-play')
                    ->color('success')
                    ->action(fn(ABTest $record) => $record->update([
                        'status' => 'running',
                        'start_date' => now(),
                    ]))
                    ->hidden(fn(ABTest $record) => $record->status !== 'draft'),
                Tables\Actions\Action::make('declare_winner')
                    ->label('Declare Winner')
                    ->icon('heroicon-o-trophy')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalDescription('The variant with the highest conversion rate will be declared the winner.')
                    ->action(fn(ABTest $record) => $record->declareWinner())
                    ->hidden(fn(ABTest $record) => $record->status !== 'running'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'running' => 'Running',
                        'completed' => 'Completed',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListABTests::route('/'),
            'create' => Pages\CreateABTest::route('/create'),
            'edit' => Pages\EditABTest::route('/{record}/edit'),
        ];
    }
}
