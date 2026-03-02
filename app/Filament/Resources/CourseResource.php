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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->label('Başlık')->required()->maxLength(255),
                Forms\Components\Textarea::make('description')->label('Açıklama')->rows(6)->nullable(),
                Forms\Components\Toggle::make('is_paid')->label('Ücretli mi?')->default(false),
                Forms\Components\TextInput::make('price')->label('Fiyat')->numeric()->nullable(),
                Forms\Components\TextInput::make('thumbnail')->label('Kapak Görseli URL')->maxLength(255)->nullable(),
                Forms\Components\Select::make('status')->label('Durum')->options([
                    'draft' => 'Taslak',
                    'published' => 'Yayınlandı',
                ])->required(),
                Forms\Components\DateTimePicker::make('published_at')->label('Yayın Tarihi')->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('title')->label('Başlık')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('status')->label('Durum')->colors([
                    'primary' => fn($state) => $state === 'draft',
                    'success' => fn($state) => $state === 'published',
                ]),
                Tables\Columns\IconColumn::make('is_paid')->label('Ücretli')->boolean(),
                Tables\Columns\TextColumn::make('price')->label('Fiyat')->money('TRY', true),
                Tables\Columns\TextColumn::make('published_at')->label('Yayın')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->label('Durum')->options([
                    'draft' => 'Taslak',
                    'published' => 'Yayınlandı',
                ]),
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
