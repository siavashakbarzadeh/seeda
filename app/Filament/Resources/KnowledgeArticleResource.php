<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KnowledgeArticleResource\Pages;
use App\Models\KnowledgeArticle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class KnowledgeArticleResource extends Resource
{
    protected static ?string $model = KnowledgeArticle::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Internal';
    protected static ?string $navigationLabel = 'Knowledge Base';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Article')->schema([
                Forms\Components\TextInput::make('title')
                    ->required()->maxLength(255)
                    ->reactive()
                    ->afterStateUpdated(fn($state, $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->required()->unique(ignoreRecord: true),
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name')
                    ->searchable()->preload()->placeholder('General'),
                Forms\Components\TextInput::make('category')
                    ->placeholder('e.g. Setup Guide, API Docs, How-To'),
                Forms\Components\Toggle::make('is_pinned')
                    ->label('📌 Pin to top'),
                Forms\Components\Hidden::make('user_id')
                    ->default(fn() => auth()->id()),
            ])->columns(2),

            Forms\Components\Section::make('Content')->schema([
                Forms\Components\RichEditor::make('body')
                    ->required()
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'h2',
                        'h3',
                        'bulletList',
                        'orderedList',
                        'link',
                        'blockquote',
                        'codeBlock',
                    ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_pinned')
                    ->boolean()->label('📌'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('category')
                    ->badge()->color('gray'),
                Tables\Columns\TextColumn::make('project.name')
                    ->default('General'),
                Tables\Columns\TextColumn::make('author.name'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->since()->sortable(),
            ])
            ->defaultSort('is_pinned', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('project')
                    ->relationship('project', 'name'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKnowledgeArticles::route('/'),
            'create' => Pages\CreateKnowledgeArticle::route('/create'),
            'edit' => Pages\EditKnowledgeArticle::route('/{record}/edit'),
        ];
    }
}
