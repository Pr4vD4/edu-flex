<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnrollmentResource\Pages;
use App\Filament\Resources\EnrollmentResource\RelationManagers;
use App\Models\Enrollment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Записи на курсы';

    protected static ?string $modelLabel = 'Запись на курс';

    protected static ?string $pluralModelLabel = 'Записи на курсы';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Обучение';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Студент')
                    ->relationship('user', 'name')
                    ->required()
                    ->preload()
                    ->searchable(),

                Forms\Components\Select::make('course_id')
                    ->label('Курс')
                    ->relationship('course', 'title')
                    ->required()
                    ->preload()
                    ->searchable(),

                Forms\Components\Select::make('status')
                    ->label('Статус')
                    ->required()
                    ->options([
                        'active' => 'Активна',
                        'completed' => 'Завершена',
                        'cancelled' => 'Отменена',
                    ])
                    ->default('active'),

                Forms\Components\TextInput::make('progress')
                    ->label('Прогресс')
                    ->default(0)
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->suffix('%'),

                Forms\Components\DateTimePicker::make('completed_at')
                    ->label('Дата завершения')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Студент')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('course.title')
                    ->label('Курс')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Активна',
                        'completed' => 'Завершена',
                        'cancelled' => 'Отменена',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('progress')
                    ->label('Прогресс')
                    ->formatStateUsing(fn (string $state): string => "{$state}%")
                    ->sortable(),

                Tables\Columns\TextColumn::make('completed_at')
                    ->label('Завершен')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата записи')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        'active' => 'Активна',
                        'completed' => 'Завершена',
                        'cancelled' => 'Отменена',
                    ]),
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
            'index' => Pages\ListEnrollments::route('/'),
            'create' => Pages\CreateEnrollment::route('/create'),
            'edit' => Pages\EditEnrollment::route('/{record}/edit'),
        ];
    }
}
