<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Book;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\HtmlString;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Support\Facades\Storage; 

use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\Action;
use App\Filament\Pages\ReadBookPage;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Library';
    protected static ?string $navigationLabel = 'Daftar Buku 📙';

    public static function form(Form $form): Form
    {
        return $form // Struktur Form
            ->schema([
                Select::make('category_id')
                  ->label('Category') 
                  ->relationship('category', 'name')// relasi ke model Category, tampilkan kolom 'name'
                  ->required(),
                TextInput::make('title')
                  ->required()
                  ->maxLength(255),
                TextInput::make('author')
                  ->required()
                  ->maxLength(255),
                TextInput::make('publisher')
                  ->required()
                  ->maxLength(255),
                TextInput::make('publication_year')
                  ->numeric() // Pastikan hanya angka
                  ->maxLength(4) // Batasi 4 digit untuk tahun
                  ->required(),
                Textarea::make('description')
                  ->maxLength(65535)
                  ->columnSpanFull()
                  ->rows(5),
                FileUpload::make('cover_image')
                  ->image()
                  ->required()
                  ->disk('public')
                  ->directory('covers')
                  ->maxSize(2048)
                  ->imageEditor()
                  ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),
                FileUpload::make('file_path')
                  ->label('Book File (PDF)')
                  ->required()
                  ->disk('public')
                  ->directory('books')
                  ->maxSize(102400)
                  ->acceptedFileTypes(['application/pdf']),
                TextInput::make('total_pages')
                  ->numeric()
                  ->minValue(1)
                  ->required(),
                TextInput::make('isbn')
                  ->label('ISBN - International Standard Book Number')
                  ->unique(ignoreRecord: true)
                  ->maxLength(255)
                  ->nullable(),
                Toggle::make('is_free')
                  ->label('Is Free?') // Label yang akan ditampilkan di form
                  ->helperText('Set ke ON Jika buku Gratis, OFF Jika buku ini harus Berlangganan untuk di akses.') 
                  ->default(false)
                  ->inline(false)
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                  ->sortable()
                  ->searchable()
                  ->label('Judul Buku')
                  ->wrap(),
                TextColumn::make('category.name')
                  ->label('Category')
                  ->sortable()
                  ->searchable(),
                ImageColumn::make('cover_image')
                  ->label('Cover Buku')
                  ->width(100)  
                  ->height(140)
                  ->sortable()
                  ->square(),
                TextColumn::make('author')
                  ->label('Penulis')
                  ->searchable()
                  ->sortable(),
                TextColumn::make('publisher')
                  ->searchable()
                  ->sortable()
                  ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('publication_year')
                  ->searchable()
                  ->sortable()
                  ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('description')
                  ->label('Deskripsi')
                  ->limit(50)
                  ->tooltip(fn (string $state): string => $state)
                  ->wrap()
                  ->searchable(),
                TextColumn::make('file_path') 
                  ->label('File Buku (PDF)') 
                  ->url(fn (string $state): string => Storage::url($state)) 
                  ->openUrlInNewTab() 
                  ->icon('heroicon-o-document')
                  ->copyable()
                  ->formatStateUsing(fn (string $state): string => basename($state))
                  ->limit(10)
                  ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('total_pages')
                  ->label('Total Pages')
                  ->sortable()
                  ->alignCenter(),
                TextColumn::make('isbn')
                  ->label('ISBN')
                  ->searchable()
                  ->sortable()
                  ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_free') 
                  ->label('Gratis')
                  ->boolean() // Tampilkan ikon check/x
                  ->sortable(),
                TextColumn::make('created_at')
                  ->dateTime()
                  ->sortable()
                  ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                  ->dateTime()
                  ->sortable()
                  ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id') // Filter berdasarkan kategori
                    ->relationship('category', 'name')
                    ->label('Category'),
                Tables\Filters\TernaryFilter::make('is_free') // Filter untuk gratis/berbayar
                    ->label('Is Free')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('Read')
                ->url(fn (Book $record) => ReadBookPage::getUrl(['book' => $record->id]))
                  ->label('Baca Buku')
                  ->icon('heroicon-o-book-open'),
                  // ->openUrlInNewTab(),
                // Tables\Actions\Action::make('view')
                //     ->url(fn (Book $record) => route('books.show', $record)),
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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        return $user && ! $user->isAdmin();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'title',
            'author',
            'isbn',
        ];
    }

     // Authorization: Hanya admin yang bisa mengelola buku
    // public static function canViewAny(): bool
    // {
    //     return (Auth::user())->isAdmin();
    // }

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
}
