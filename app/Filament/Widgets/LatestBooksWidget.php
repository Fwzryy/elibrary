<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class LatestBooksWidget extends Widget
{
    protected static string $view = 'filament.widgets.latest-books-widget';
    protected static ?string $heading = 'Buku-Buku Terbaru nih! 🆕'; 
    protected int | string | array $columnSpan = 2;
    public array $latestBooks = [];

    protected function getViewData(): array
    {
        $this->latestBooks = Book::latest()->take(5)->get()->toArray();

        return [
            'latestBooks' => $this->latestBooks,
        ];
    }
}