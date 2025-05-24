<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class LatestBooksWidget extends Widget
{
    // Ini menunjuk ke view Blade kustom untuk widget ini
    protected static string $view = 'filament.widgets.latest-books-widget';
    protected int | string | array $columnSpan = 1;
    // Properti untuk menyimpan data buku terbaru
    public array $latestBooks = [];

    protected function getViewData(): array
    {
        // Mengambil 5 buku terbaru, diurutkan berdasarkan created_at secara descending
        // dan mengonversinya ke array.
        $this->latestBooks = Book::latest()->take(5)->get()->toArray();

        return [
            'latestBooks' => $this->latestBooks,
        ];
    }
}