<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CaseStudyResource\Pages;
use App\Models\CaseStudy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CaseStudyResource extends Resource
{
    protected static ?string $model = CaseStudy::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = '🗂️ Portfolio';
    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', true)->count() ?: null;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Project Info')->schema([
                Forms\Components\TextInput::make('title')->required()->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                Forms\Components\Select::make('category')
                    ->options(CaseStudy::getCategoryOptions())
                    ->required()->searchable(),
                Forms\Components\ColorPicker::make('color')->default('#16A34A'),
                Forms\Components\TagsInput::make('tags')->placeholder('React, Node.js...'),
                Forms\Components\Textarea::make('excerpt')->required()->rows(2)->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Media & Client')->schema([
                Forms\Components\FileUpload::make('thumbnail')
                    ->image()->directory('portfolio/thumbnails')
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth('1200')
                    ->imageResizeTargetHeight('675')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('client_name')
                    ->placeholder('e.g. FinPay Inc.'),
                Forms\Components\FileUpload::make('client_logo')
                    ->image()->directory('portfolio/logos')
                    ->imageResizeTargetWidth('200')
                    ->imageResizeTargetHeight('200'),
                Forms\Components\TextInput::make('live_url')
                    ->label('Live URL')->url()->prefix('https://')
                    ->placeholder('www.example.com'),
                Forms\Components\TextInput::make('duration')
                    ->placeholder('e.g. 3 months'),
            ])->columns(2),

            Forms\Components\Section::make('Case Study Details')->schema([
                Forms\Components\Textarea::make('challenge')->required()->rows(3),
                Forms\Components\Textarea::make('solution')->required()->rows(3),
                Forms\Components\TagsInput::make('results')
                    ->placeholder('Add a result metric, e.g. "40% faster load time"'),
                Forms\Components\CheckboxList::make('technologies')
                    ->options([
                        'laravel' => 'Laravel',
                        'php' => 'PHP',
                        'react' => 'React',
                        'nextjs' => 'Next.js',
                        'vue' => 'Vue.js',
                        'nodejs' => 'Node.js',
                        'python' => 'Python',
                        'django' => 'Django',
                        'typescript' => 'TypeScript',
                        'tailwind' => 'Tailwind CSS',
                        'aws' => 'AWS',
                        'gcp' => 'Google Cloud',
                        'docker' => 'Docker',
                        'mysql' => 'MySQL',
                        'postgresql' => 'PostgreSQL',
                        'mongodb' => 'MongoDB',
                        'graphql' => 'GraphQL',
                        'shopify' => 'Shopify',
                        'flutter' => 'Flutter',
                        'react_native' => 'React Native',
                        'tensorflow' => 'TensorFlow',
                        'pytorch' => 'PyTorch',
                    ])->columns(4)->searchable(),
            ]),

            Forms\Components\Section::make('Client Testimonial')->schema([
                Forms\Components\Textarea::make('testimonial_text')
                    ->rows(2)->placeholder('What the client said about this project...'),
                Forms\Components\TextInput::make('testimonial_author')
                    ->placeholder('e.g. John Doe, CTO of FinPay'),
            ])->columns(2)->collapsible(),

            Forms\Components\Section::make('Settings')->schema([
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                Forms\Components\Toggle::make('is_featured')->default(false)
                    ->helperText('Featured projects show on the homepage'),
                Forms\Components\Toggle::make('is_active')->default(true),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->width(80)->height(45)->rounded(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('client_name')
                    ->label('Client')->default('—'),
                Tables\Columns\TextColumn::make('category')
                    ->badge()->sortable(),
                Tables\Columns\TextColumn::make('tags')
                    ->getStateUsing(fn($record) => implode(', ', $record->tags ?? []))
                    ->limit(25)->wrap()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()->label('Featured'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()->label('Active'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable()->label('#'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('toggle_featured')
                    ->label(fn(CaseStudy $record) => $record->is_featured ? 'Unfeature' : 'Feature')
                    ->icon('heroicon-o-star')
                    ->color(fn(CaseStudy $record) => $record->is_featured ? 'gray' : 'warning')
                    ->action(fn(CaseStudy $record) => $record->update(['is_featured' => !$record->is_featured])),
                Tables\Actions\Action::make('view_live')
                    ->label('Open')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn(CaseStudy $record) => $record->live_url, shouldOpenInNewTab: true)
                    ->hidden(fn(CaseStudy $record) => !$record->live_url),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCaseStudies::route('/'),
            'create' => Pages\CreateCaseStudy::route('/create'),
            'edit' => Pages\EditCaseStudy::route('/{record}/edit'),
        ];
    }
}
