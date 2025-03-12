<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonResource\Pages;
use App\Filament\Resources\LessonResource\RelationManagers;
use App\Models\Lesson;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Уроки';

    protected static ?string $modelLabel = 'Урок';

    protected static ?string $pluralModelLabel = 'Уроки';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Обучение';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Название урока')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('course_id')
                    ->label('Курс')
                    ->relationship('course', 'title')
                    ->required()
                    ->preload()
                    ->searchable(),

                Forms\Components\Textarea::make('description')
                    ->label('Краткое описание')
                    ->rows(2)
                    ->maxLength(500),

                Forms\Components\RichEditor::make('content')
                    ->label('Содержимое урока')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('video_url')
                    ->label('URL видео')
                    ->url()
                    ->maxLength(255),

                Forms\Components\FileUpload::make('file_url')
                    ->label('Файл урока')
                    ->directory('lessons/files')
                    ->visibility('public'),

                Forms\Components\Select::make('type')
                    ->label('Тип урока')
                    ->required()
                    ->options([
                        'text' => 'Текст',
                        'video' => 'Видео',
                        'pdf' => 'PDF документ',
                    ])
                    ->default('text'),

                Forms\Components\TextInput::make('duration_minutes')
                    ->label('Длительность (мин)')
                    ->numeric()
                    ->minValue(1),

                Forms\Components\TextInput::make('position')
                    ->label('Позиция')
                    ->numeric()
                    ->default(0),

                Forms\Components\Toggle::make('is_free')
                    ->label('Бесплатный урок')
                    ->default(false),

                Forms\Components\Toggle::make('is_published')
                    ->label('Опубликован')
                    ->default(true),
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

                Tables\Columns\TextColumn::make('course.title')
                    ->label('Курс')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Тип')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'text' => 'Текст',
                        'video' => 'Видео',
                        'pdf' => 'PDF',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('position')
                    ->label('Позиция')
                    ->sortable(),

                Tables\Columns\TextColumn::make('duration_minutes')
                    ->label('Длительность')
                    ->formatStateUsing(fn (?string $state): string => $state ? "{$state} мин" : '-')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_free')
                    ->label('Бесплатный')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Опубликован')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('course_id')
                    ->label('Курс')
                    ->relationship('course', 'title'),

                Tables\Filters\SelectFilter::make('type')
                    ->label('Тип')
                    ->options([
                        'text' => 'Текст',
                        'video' => 'Видео',
                        'pdf' => 'PDF документ',
                    ]),

                Tables\Filters\TernaryFilter::make('is_free')
                    ->label('Бесплатный'),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Опубликован'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('position');
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
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}
