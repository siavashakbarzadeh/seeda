<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CourseResource extends Resource
{
    use Translatable;

    protected static ?string $model = Course::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Course')->tabs([
                Forms\Components\Tabs\Tab::make('Basic Info')->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                    Forms\Components\TextInput::make('subtitle')
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('description')
                        ->required()
                        ->columnSpanFull(),
                ]),
                Forms\Components\Tabs\Tab::make('Curriculum & Career')->schema([
                    Forms\Components\RichEditor::make('curriculum')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('career_info')
                        ->columnSpanFull(),
                ]),
                Forms\Components\Tabs\Tab::make('Pricing & Details')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->prefix('€'),
                        Forms\Components\TextInput::make('currency')
                            ->default('EUR')
                            ->maxLength(10),
                        Forms\Components\TextInput::make('installment_info')
                            ->placeholder('e.g. 6 months at 0%')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('duration')
                            ->placeholder('e.g. 3 months')
                            ->maxLength(255),
                        Forms\Components\Select::make('level')
                            ->options([
                                'beginner' => 'Beginner',
                                'intermediate' => 'Intermediate',
                                'advanced' => 'Advanced',
                            ]),
                        Forms\Components\Select::make('format')
                            ->options([
                                'remote' => 'Full Remote',
                                'in-person' => 'In Person',
                                'hybrid' => 'Hybrid',
                            ]),
                        Forms\Components\TextInput::make('location')
                            ->placeholder('e.g. Roma, Italy')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('link')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\DateTimePicker::make('starts_at')
                            ->label('Start Date'),
                    ]),
                ]),
                Forms\Components\Tabs\Tab::make('Settings')->schema([
                    Forms\Components\FileUpload::make('image')
                        ->image()
                        ->directory('courses'),
                    Forms\Components\Toggle::make('is_active')
                        ->default(true),
                    Forms\Components\Toggle::make('is_featured')
                        ->default(false),
                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->default(0),
                ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('level')
                    ->badge(),
                Tables\Columns\TextColumn::make('format')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
                Tables\Columns\TextColumn::make('starts_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\TernaryFilter::make('is_featured'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
