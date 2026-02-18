<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmailCampaignResource\Pages;
use App\Models\EmailCampaign;
use App\Models\NewsletterSubscriber;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmailCampaignResource extends Resource
{
    protected static ?string $model = EmailCampaign::class;
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $navigationLabel = 'Email Campaigns';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Campaign Setup')->schema([
                Forms\Components\TextInput::make('name')
                    ->required()->placeholder('e.g. February Newsletter'),
                Forms\Components\TextInput::make('subject')
                    ->required()->placeholder('Email subject line'),
                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => '📝 Draft',
                        'scheduled' => '📅 Scheduled',
                        'sending' => '📤 Sending',
                        'sent' => '✅ Sent',
                        'cancelled' => '❌ Cancelled',
                    ])->default('draft')->required(),
                Forms\Components\DateTimePicker::make('scheduled_at')
                    ->placeholder('Schedule send time'),
            ])->columns(2),

            Forms\Components\Section::make('Email Body')->schema([
                Forms\Components\RichEditor::make('body')
                    ->required()
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'link',
                        'bulletList',
                        'orderedList',
                        'h2',
                        'h3',
                        'blockquote',
                        'codeBlock',
                    ]),
            ]),

            Forms\Components\Section::make('Statistics')->schema([
                Forms\Components\TextInput::make('recipients_count')
                    ->numeric()->disabled()->dehydrated(),
                Forms\Components\TextInput::make('opened_count')
                    ->numeric()->disabled()->dehydrated(),
                Forms\Components\TextInput::make('clicked_count')
                    ->numeric()->disabled()->dehydrated(),
                Forms\Components\TextInput::make('bounced_count')
                    ->numeric()->disabled()->dehydrated(),
                Forms\Components\TextInput::make('unsubscribed_count')
                    ->numeric()->disabled()->dehydrated(),
            ])->columns(5)->visibleOn('edit'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('subject')
                    ->limit(35),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'info' => 'scheduled',
                        'warning' => 'sending',
                        'success' => 'sent',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('recipients_count')
                    ->label('📧 Sent'),
                Tables\Columns\TextColumn::make('open_rate')
                    ->label('📬 Open')
                    ->getStateUsing(fn($record) => $record->open_rate . '%')
                    ->badge()
                    ->color(fn($record) => $record->open_rate > 25 ? 'success' : 'warning'),
                Tables\Columns\TextColumn::make('click_rate')
                    ->label('🖱️ Click')
                    ->getStateUsing(fn($record) => $record->click_rate . '%')
                    ->badge()
                    ->color(fn($record) => $record->click_rate > 5 ? 'success' : 'gray'),
                Tables\Columns\TextColumn::make('bounced_count')
                    ->label('↩️ Bounce')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sent_at')
                    ->dateTime()->sortable()->default('—'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('send_now')
                    ->label('Send Now')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalDescription(
                        fn(EmailCampaign $record) =>
                        'Send this email to ' . NewsletterSubscriber::where('is_active', true)->count() . ' active subscribers?'
                    )
                    ->action(function (EmailCampaign $record) {
                        $subscribers = NewsletterSubscriber::where('is_active', true)->get();
                        $record->update([
                            'status' => 'sent',
                            'sent_at' => now(),
                            'recipients_count' => $subscribers->count(),
                        ]);
                        // In production: dispatch a job to send emails in batches
                    })
                    ->hidden(fn(EmailCampaign $record) => !in_array($record->status, ['draft', 'scheduled'])),

                Tables\Actions\Action::make('duplicate')
                    ->label('Duplicate')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('gray')
                    ->action(function (EmailCampaign $record) {
                        $record->replicate()->fill([
                            'name' => $record->name . ' (Copy)',
                            'status' => 'draft',
                            'sent_at' => null,
                            'recipients_count' => 0,
                            'opened_count' => 0,
                            'clicked_count' => 0,
                            'bounced_count' => 0,
                            'unsubscribed_count' => 0,
                        ])->save();
                    }),

                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'scheduled' => 'Scheduled',
                        'sent' => 'Sent',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmailCampaigns::route('/'),
            'create' => Pages\CreateEmailCampaign::route('/create'),
            'edit' => Pages\EditEmailCampaign::route('/{record}/edit'),
        ];
    }
}
