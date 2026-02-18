<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;
    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Testimonial')->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('company'),
                Forms\Components\TextInput::make('role')
                    ->placeholder('e.g. CEO, CTO'),
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->searchable()->preload()->placeholder('Link to client (optional)'),
                Forms\Components\Select::make('rating')
                    ->options([5 => '⭐⭐⭐⭐⭐', 4 => '⭐⭐⭐⭐', 3 => '⭐⭐⭐', 2 => '⭐⭐', 1 => '⭐'])
                    ->default(5)->required(),
                Forms\Components\Toggle::make('is_featured')
                    ->label('⭐ Featured on homepage'),
                Forms\Components\Textarea::make('content')
                    ->required()->rows(4)->columnSpanFull(),
                Forms\Components\FileUpload::make('photo')
                    ->avatar()->directory('testimonials'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')->circular()->size(40),
                Tables\Columns\TextColumn::make('name')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('company'),
                Tables\Columns\TextColumn::make('content')->limit(40),
                Tables\Columns\TextColumn::make('rating')
                    ->formatStateUsing(fn($state) => str_repeat('⭐', $state)),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()->label('Featured'),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
