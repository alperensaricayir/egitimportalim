<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('Ad Soyad')->required()->maxLength(255),
                Forms\Components\TextInput::make('email')->label('E-posta')->email()->required(),
                Forms\Components\Select::make('role')->label('Rol')->options([
                    'admin' => 'Admin',
                    'editor' => 'Editör',
                    'user' => 'Kullanıcı',
                ])->required(),
                Forms\Components\Textarea::make('bio')->label('Biyografi')->rows(4),
                Forms\Components\TextInput::make('phone')->label('Telefon')->maxLength(40),
                Forms\Components\TextInput::make('city')->label('Şehir')->maxLength(120),
                Forms\Components\TextInput::make('avatar')->label('Avatar URL')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Ad Soyad')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label('E-posta')->searchable(),
                Tables\Columns\TextColumn::make('role')->label('Rol')->badge()->sortable(),
                Tables\Columns\TextColumn::make('city')->label('Şehir'),
                Tables\Columns\TextColumn::make('created_at')->label('Kayıt')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')->label('Rol')->options([
                    'admin' => 'Admin',
                    'editor' => 'Editör',
                    'user' => 'Kullanıcı',
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
