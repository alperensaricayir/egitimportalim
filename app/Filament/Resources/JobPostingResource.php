<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobPostingResource\Pages;
use App\Filament\Resources\JobPostingResource\RelationManagers;
use App\Models\JobPosting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobPostingResource extends Resource
{
    protected static ?string $model = JobPosting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Başlık')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->label('Şehir')
                    ->maxLength(120)
                    ->required(),
                Forms\Components\TextInput::make('category')
                    ->label('Kategori')
                    ->maxLength(120)
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Açıklama')
                    ->rows(6)
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('title')->label('Başlık')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('city')->label('Şehir')->sortable(),
                Tables\Columns\TextColumn::make('category')->label('Kategori')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('Oluşturma')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Aktif'),
                Tables\Filters\SelectFilter::make('category')->label('Kategori'),
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
            'index' => Pages\ListJobPostings::route('/'),
            'create' => Pages\CreateJobPosting::route('/create'),
            'edit' => Pages\EditJobPosting::route('/{record}/edit'),
        ];
    }
}
