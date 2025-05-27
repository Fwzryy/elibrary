<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Models\ReadHistory; // Import model ReadHistory
use Carbon\Carbon; // Import Carbon

class ReadingHistory extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static string $view = 'filament.pages.reading-history';
    protected static ?string $title = 'Riwayat Baca Saya';
    protected static ?string $navigationGroup = 'Library';
    protected static ?string $navigationLabel = 'Riwayat Baca';

    public $readHistories; // Properti untuk menyimpan riwayat baca

    public function mount(): void
    {
        $user = Auth::user();
        if ($user) {
            // Ambil semua riwayat baca user, dengan eager loading buku
            $this->readHistories = $user->readHistories()->with('book')->orderByDesc('last_read_at')->get();
        } else {
            $this->readHistories = collect(); // Kosong jika tidak login
        }
    }

    public static function shouldBeVisible(): bool
    {
        $user = Auth::user();
        return $user && ! $user->isAdmin();
    }
}