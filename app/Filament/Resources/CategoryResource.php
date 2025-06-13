<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Auth; 

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Daftar Kategori 🗂️';
    protected static ?string $navigationGroup = 'Library';
    protected static ?string $pluralLabel = 'Categories';
    protected static ?string $slug = 'categories';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                  ->label('Category Name')
                  ->required()
                  ->maxLength(255)
                  ->unique(ignoreRecord: true)
                  ->live()
                  ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null), // Otomatis isi slug saat membuat
                TextInput::make('slug')
                  ->required()
                  ->maxLength(255)
                  ->unique(ignoreRecord: true), // Pastikan slug unik, abaikan saat edit
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
              Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->color('gray'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->color('warning'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
              // Belum ada relasi di sini untuk ditampilkan langsung di kategori
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
    public static function getGloballySearchableAttributes(): array
    {
        return [
            'name',
            'slug',
        ];
    }
      // Authorization: Hanya admin yang bisa mengelola kategori
    public static function canViewAny(): bool
    {
        return (Auth::user())->isAdmin();
    }
    public static function canCreate(): bool
    {
        return (Auth::user())->isAdmin();
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return (Auth::user())->isAdmin();
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return (Auth::user())->isAdmin();
    }

    public static function canDeleteAny(): bool
    {
        return (Auth::user())->isAdmin();
    }
    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        return $user && ! $user->isAdmin();
    }
}
