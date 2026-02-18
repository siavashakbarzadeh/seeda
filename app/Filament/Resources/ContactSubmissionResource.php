<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactSubmissionResource\Pages;
use App\Models\ContactSubmission;
use App\Models\Lead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactSubmissionResource extends Resource
{
    protected static ?string $model = ContactSubmission::class;
    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $navigationLabel = 'Contact Forms';
    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'new')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Submission Details')->schema([
                Forms\Components\TextInput::make('name')->disabled(),
                Forms\Components\TextInput::make('email')->disabled(),
                Forms\Components\TextInput::make('phone')->disabled(),
                Forms\Components\TextInput::make('company')->disabled(),
                Forms\Components\TextInput::make('subject')->disabled(),
                Forms\Components\Textarea::make('message')->disabled()->rows(5)->columnSpanFull(),
            ])->columns(3),

            Forms\Components\Section::make('Meta')->schema([
                Forms\Components\TextInput::make('source_page')->disabled(),
                Forms\Components\TextInput::make('utm_source')->disabled(),
                Forms\Components\TextInput::make('utm_medium')->disabled(),
                Forms\Components\TextInput::make('ip_address')->disabled(),
                Forms\Components\Select::make('status')
                    ->options([
                        'new' => '🆕 New',
                        'read' => '👁️ Read',
                        'replied' => '✅ Replied',
                        'spam' => '🚫 Spam',
                        'archived' => '📦 Archived',
                    ])->required(),
                Forms\Components\Select::make('lead_id')
                    ->relationship('lead', 'name')
                    ->searchable()->preload()
                    ->placeholder('Not linked'),
            ])->columns(3)->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()->copyable(),
                Tables\Columns\TextColumn::make('subject')
                    ->limit(30)->default('(No subject)'),
                Tables\Columns\TextColumn::make('message')
                    ->limit(40)->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('source_page')
                    ->label('From Page')->default('—'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'danger' => 'new',
                        'info' => 'read',
                        'success' => 'replied',
                        'warning' => 'spam',
                        'gray' => 'archived',
                    ]),
                Tables\Columns\IconColumn::make('lead_id')
                    ->label('Lead')
                    ->icon(fn($state) => $state ? 'heroicon-s-check-circle' : 'heroicon-o-minus')
                    ->color(fn($state) => $state ? 'success' : 'gray'),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make()->label('View'),

                Tables\Actions\Action::make('mark_read')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->action(fn(ContactSubmission $r) => $r->update(['status' => 'read']))
                    ->hidden(fn(ContactSubmission $r) => $r->status !== 'new'),

                Tables\Actions\Action::make('convert_to_lead')
                    ->label('Create Lead')
                    ->icon('heroicon-o-user-plus')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn(ContactSubmission $r) => $r->convertToLead())
                    ->hidden(fn(ContactSubmission $r) => $r->lead_id !== null),

                Tables\Actions\Action::make('mark_spam')
                    ->icon('heroicon-o-no-symbol')
                    ->color('warning')
                    ->action(fn(ContactSubmission $r) => $r->update(['status' => 'spam']))
                    ->hidden(fn(ContactSubmission $r) => $r->status === 'spam'),

                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'read' => 'Read',
                        'replied' => 'Replied',
                        'spam' => 'Spam',
                        'archived' => 'Archived',
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkAction::make('bulk_spam')
                    ->label('Mark as Spam')
                    ->icon('heroicon-o-no-symbol')
                    ->color('warning')
                    ->action(fn($records) => $records->each->update(['status' => 'spam'])),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactSubmissions::route('/'),
            'edit' => Pages\EditContactSubmission::route('/{record}/edit'),
        ];
    }
}
