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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('course_id')->label('Kurs')
                    ->relationship('course', 'title')->required(),
                Forms\Components\TextInput::make('title')->label('Başlık')->required()->maxLength(255),
                Forms\Components\Textarea::make('content')->label('İçerik')->rows(8),
                Forms\Components\TextInput::make('video_url')->label('Video URL')->maxLength(255)->nullable(),
                Forms\Components\TextInput::make('order')->label('Sıra')->numeric()->default(0),
                Forms\Components\Select::make('status')->label('Durum')->options([
                    'draft' => 'Taslak',
                    'published' => 'Yayınlandı',
                ])->required(),
                Forms\Components\DateTimePicker::make('published_at')->label('Yayın Tarihi')->nullable(),
                Forms\Components\Toggle::make('is_preview')->label('Ön İzleme')->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('course.title')->label('Kurs')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('title')->label('Başlık')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('order')->label('Sıra')->sortable(),
                Tables\Columns\BadgeColumn::make('status')->label('Durum')->colors([
                    'primary' => fn($state) => $state === 'draft',
                    'success' => fn($state) => $state === 'published',
                ]),
                Tables\Columns\IconColumn::make('is_preview')->label('Ön İzleme')->boolean(),
                Tables\Columns\TextColumn::make('published_at')->label('Yayın')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->label('Durum')->options([
                    'draft' => 'Taslak',
                    'published' => 'Yayınlandı',
                ]),
                Tables\Filters\SelectFilter::make('course_id')->label('Kurs')->relationship('course', 'title'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}
