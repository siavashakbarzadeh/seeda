<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialMediaPostResource\Pages;
use App\Models\SocialMediaPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SocialMediaPostResource extends Resource
{
    protected static ?string $model = SocialMediaPost::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $navigationLabel = 'Social Media';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Post Details')->schema([
                Forms\Components\TextInput::make('title')
                    ->required()->maxLength(255)->placeholder('Post title/reference'),
                Forms\Components\Select::make('platform')
                    ->options(SocialMediaPost::getPlatformOptions())
                    ->required()->searchable(),
                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => '📝 Draft',
                        'scheduled' => '📅 Scheduled',
                        'published' => '✅ Published',
                        'failed' => '❌ Failed',
                    ])->default('draft')->required(),
                Forms\Components\DateTimePicker::make('scheduled_at')
                    ->label('Schedule For'),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Published At'),
                Forms\Components\Select::make('campaign_id')
                    ->relationship('campaign', 'name')
                    ->searchable()->preload()
                    ->placeholder('Link to campaign (optional)'),
            ])->columns(3),

            Forms\Components\Section::make('Content')->schema([
                Forms\Components\Textarea::make('content')
                    ->required()->rows(4)->columnSpanFull()
                    ->placeholder('Write your post content here...'),
                Forms\Components\FileUpload::make('media_url')
                    ->label('Media (Image/Video)')
                    ->image()
                    ->directory('social-media')
                    ->columnSpanFull(),
                Forms\Components\TagsInput::make('hashtags')
                    ->placeholder('#marketing, #webdev')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('post_url')
                    ->label('Live Post URL')
                    ->url()->prefix('https://')
                    ->placeholder('Link after publishing'),
            ])->columns(2),

            Forms\Components\Section::make('Engagement Metrics')
                ->schema([
                    Forms\Components\TextInput::make('impressions')
                        ->numeric()->default(0)->prefix('👁️'),
                    Forms\Components\TextInput::make('likes')
                        ->numeric()->default(0)->prefix('❤️'),
                    Forms\Components\TextInput::make('comments')
                        ->numeric()->default(0)->prefix('💬'),
                    Forms\Components\TextInput::make('shares')
                        ->numeric()->default(0)->prefix('🔄'),
                    Forms\Components\TextInput::make('clicks')
                        ->numeric()->default(0)->prefix('🖱️'),
                ])->columns(5)
                ->collapsible()
                ->visibleOn('edit'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()->weight('bold')->limit(30),
                Tables\Columns\TextColumn::make('platform')
                    ->badge()
                    ->formatStateUsing(fn($state) => SocialMediaPost::getPlatformOptions()[$state] ?? $state)
                    ->colors([
                        'primary' => fn($state) => in_array($state, ['facebook', 'linkedin']),
                        'danger' => fn($state) => in_array($state, ['youtube', 'pinterest']),
                        'success' => 'twitter',
                        'warning' => 'instagram',
                        'info' => 'tiktok',
                    ]),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'info' => 'scheduled',
                        'success' => 'published',
                        'danger' => 'failed',
                    ]),
                Tables\Columns\TextColumn::make('scheduled_at')
                    ->dateTime('M d, H:i')->sortable()->default('—'),
                Tables\Columns\TextColumn::make('impressions')
                    ->numeric()->sortable()->label('👁️ Views'),
                Tables\Columns\TextColumn::make('total_engagement')
                    ->label('💬 Engage')
                    ->getStateUsing(fn($record) => $record->total_engagement)
                    ->badge()->color('info'),
                Tables\Columns\TextColumn::make('engagement_rate')
                    ->label('📊 Rate')
                    ->getStateUsing(fn($record) => $record->engagement_rate . '%')
                    ->badge()
                    ->color(fn($record) => $record->engagement_rate > 3 ? 'success' : 'gray'),
                Tables\Columns\TextColumn::make('campaign.name')
                    ->label('Campaign')->default('—')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('publish')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn(SocialMediaPost $r) => $r->update([
                        'status' => 'published',
                        'published_at' => now(),
                    ]))
                    ->hidden(fn(SocialMediaPost $r) => $r->status === 'published'),
                Tables\Actions\Action::make('duplicate')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('gray')
                    ->action(fn(SocialMediaPost $r) => $r->replicate()->fill([
                        'title' => $r->title . ' (Copy)',
                        'status' => 'draft',
                        'published_at' => null,
                        'likes' => 0,
                        'comments' => 0,
                        'shares' => 0,
                        'impressions' => 0,
                        'clicks' => 0,
                    ])->save()),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('platform')
                    ->options(SocialMediaPost::getPlatformOptions()),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'scheduled' => 'Scheduled',
                        'published' => 'Published',
                    ]),
                Tables\Filters\SelectFilter::make('campaign')
                    ->relationship('campaign', 'name'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSocialMediaPosts::route('/'),
            'create' => Pages\CreateSocialMediaPost::route('/create'),
            'edit' => Pages\EditSocialMediaPost::route('/{record}/edit'),
        ];
    }
}
