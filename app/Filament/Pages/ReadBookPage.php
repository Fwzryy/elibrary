<?php

namespace App\Filament\Pages;

use App\Models\Book;
use Filament\Pages\Page;
use App\Http\Middleware\CheckSubscription; 


class ReadBookPage extends Page
{
    protected static ?string $slug = 'read';
    protected static string $view = 'filament.pages.read-book-page';
    protected static ?string $title = 'Halaman Membaca Buku — Selamat Membaca! 📕 ';
    protected static ?string $navigationLabel = null;
    protected static ?string $navigationIcon = null;

    protected static ?string $resource = null;

    public ?Book $book = null;

    public function mount(Book $book): void // mount(int $book)
    {
        // $this->book = Book::findOrFail($book);
        $this->book = $book;
    }

    public static function getMiddleware(): array
{
    return [
        ['middleware' => 'auth', 'options' => []],
        ['middleware' => CheckSubscription::class, 'options' => []],
    ];
}

    public static function getSlug(): string
    {
        return 'read/{book}';
    }
    
    // Optional: Agar halaman tidak tampil di sidebar
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
