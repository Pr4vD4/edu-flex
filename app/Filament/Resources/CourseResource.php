<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Курсы';

    protected static ?string $modelLabel = 'Курс';

    protected static ?string $pluralModelLabel = 'Курсы';

    protected static ?string $navigationGroup = 'Обучение';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Название курса')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('slug')
                    ->label('URL-slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                Forms\Components\Textarea::make('description')
                    ->label('Описание')
                    ->required()
                    ->rows(4),

                Forms\Components\FileUpload::make('image')
                    ->label('Изображение')
                    ->image()
                    ->directory('images/courses')
                    ->visibility('public'),

                Forms\Components\Select::make('category_id')
                    ->label('Категория')
                    ->relationship('category', 'name')
                    ->required(),

                Forms\Components\Select::make('teacher_id')
                    ->label('Преподаватель')
                    ->relationship('teacher', 'name', function (Builder $query) {
                        return $query->where('role', 'teacher');
                    })
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Статус')
                    ->required()
                    ->options([
                        'draft' => 'Черновик',
                        'published' => 'Опубликован',
                        'archived' => 'В архиве',
                    ]),

                Forms\Components\Toggle::make('is_featured')
                    ->label('Рекомендуемый курс')
                    ->default(false),

                Forms\Components\TextInput::make('price')
                    ->label('Стоимость')
                    ->numeric()
                    ->required()
                    ->minValue(0),

                Forms\Components\TextInput::make('duration')
                    ->label('Длительность (в минутах)')
                    ->numeric()
                    ->minValue(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Категория')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('teacher.name')
                    ->label('Преподаватель')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'warning',
                        'archived' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'published' => 'Опубликован',
                        'draft' => 'Черновик',
                        'archived' => 'В архиве',
                        default => $state,
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_featured')
                    ->label('Рекомендуемый')
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Стоимость')
                    ->money('RUB')
                    ->sortable(),

                Tables\Columns\TextColumn::make('students_count')
                    ->label('Кол-во студентов')
                    ->counts('students')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        'published' => 'Опубликован',
                        'draft' => 'Черновик',
                        'archived' => 'В архиве',
                    ]),

                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Категория')
                    ->relationship('category', 'name'),

                Tables\Filters\SelectFilter::make('teacher_id')
                    ->label('Преподаватель')
                    ->relationship('teacher', 'name'),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Рекомендуемый'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
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
