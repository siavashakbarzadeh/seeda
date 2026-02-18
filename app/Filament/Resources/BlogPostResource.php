<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Blog';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Post Details')->schema([
                Forms\Components\TextInput::make('title')
                    ->required()->maxLength(255)
                    ->reactive()
                    ->afterStateUpdated(fn($state, $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->required()->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('category')
                    ->placeholder('e.g. Technology, Business, Tutorial'),
                Forms\Components\TagsInput::make('tags')
                    ->placeholder('Add tags'),
                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => '📝 Draft',
                        'published' => '✅ Published',
                        'archived' => '📦 Archived',
                    ])->default('draft')->required(),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Publish Date'),
                Forms\Components\Hidden::make('author_id')
                    ->default(fn() => auth()->id()),
            ])->columns(2),

            Forms\Components\Section::make('Content')->schema([
                Forms\Components\FileUpload::make('cover_image')
                    ->label('Cover Image')
                    ->directory('blog')
                    ->image()
                    ->maxSize(5120),
                Forms\Components\Textarea::make('excerpt')
                    ->rows(2)->placeholder('Short summary for listing pages...'),
                Forms\Components\RichEditor::make('body')
                    ->required()
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('SEO')->schema([
                Forms\Components\TextInput::make('meta_title')
                    ->placeholder('Override page title for search engines'),
                Forms\Components\Textarea::make('meta_description')
                    ->rows(2)
                    ->placeholder('Max 160 characters')
                    ->maxLength(160),
            ])->columns(1)->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->circular()->size(40),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()->sortable()->weight('bold')->limit(40),
                Tables\Columns\TextColumn::make('category')
                    ->badge()->color('gray'),
                Tables\Columns\TextColumn::make('author.name'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'published',
                        'warning' => 'archived',
                    ]),
                Tables\Columns\TextColumn::make('published_at')
                    ->date()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('publish')
                    ->label('Publish')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn(BlogPost $record) => $record->update([
                        'status' => 'published',
                        'published_at' => $record->published_at ?? now(),
                    ]))
                    ->hidden(fn(BlogPost $record) => $record->status === 'published')
                    ->requiresConfirmation(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived']),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
