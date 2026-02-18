<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerResource\Pages;
use App\Filament\Resources\PartnerResource\RelationManagers;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $navigationLabel = 'Affiliates';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Partner Details')->schema([
                Forms\Components\TextInput::make('name')
                    ->required()->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()->required()->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('code')
                    ->default(fn() => Str::random(8))
                    ->required()->unique(ignoreRecord: true)
                    ->helperText('This code is used in URLs for tracking: ?ref=CODE'),
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => '✅ Active',
                        'pending' => '⏳ Pending',
                        'suspended' => '🚫 Suspended',
                    ])->default('active')->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        'individual' => '👤 Individual',
                        'agency' => '🏢 Agency',
                    ])->default('individual')->required(),
                Forms\Components\TextInput::make('commission_rate')
                    ->numeric()->default(10)->suffix('%')
                    ->helperText('Default percentage commission for projects/milestones'),
            ])->columns(2),

            Forms\Components\Section::make('Financial Overview')
                ->schema([
                    Forms\Components\Placeholder::make('balance_display')
                        ->label('Current Balance')
                        ->content(fn($record) => '€' . number_format($record?->balance ?? 0, 2)),
                    Forms\Components\Placeholder::make('total_earned_display')
                        ->label('Total Lifetime Earnings')
                        ->content(fn($record) => '€' . number_format($record?->total_earned ?? 0, 2)),
                ])->columns(2)->visibleOn('edit'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('code')
                    ->fontFamily('mono')->copyable()->label('Tracking Code'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'active',
                        'warning' => 'pending',
                        'danger' => 'suspended',
                    ]),
                Tables\Columns\TextColumn::make('balance')
                    ->money('EUR')->sortable()->color('success'),
                Tables\Columns\TextColumn::make('referrals_count')
                    ->counts('referrals')->label('Leads/Projects')->badge()->color('info'),
                Tables\Columns\TextColumn::make('total_earned')
                    ->money('EUR')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'pending' => 'Pending',
                        'suspended' => 'Suspended',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('payout')
                    ->label('Request Payout')
                    ->icon('heroicon-o-banknotes')
                    ->color('success')
                    ->form([
                        Forms\Components\TextInput::make('amount')
                            ->numeric()->prefix('€')
                            ->required()
                            ->maxValue(fn($record) => $record->balance),
                        Forms\Components\Select::make('method')
                            ->options(['bank' => 'Bank Transfer', 'paypal' => 'PayPal', 'crypto' => 'Crypto'])
                            ->required(),
                        Forms\Components\TextInput::make('reference_no')->label('Memo/Ref'),
                    ])
                    ->action(function (Partner $record, array $data) {
                        \App\Models\PayoutLog::create([
                            'partner_id' => $record->id,
                            'amount' => $data['amount'],
                            'method' => $data['method'],
                            'reference_no' => $data['reference_no'],
                            'status' => 'pending',
                        ]);
                        $record->decrement('balance', $data['amount']);
                    })
                    ->visible(fn($record) => $record->balance > 0),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ReferralsRelationManager::class,
            RelationManagers\PayoutsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
