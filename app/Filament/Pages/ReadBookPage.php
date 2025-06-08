<?php

namespace App\Filament\Pages;

use Carbon\Carbon; 
use App\Models\Book;
use Filament\Pages\Page;
use App\Models\ReadHistory; 
use Illuminate\Support\Facades\Auth; 
use App\Http\Middleware\CheckSubscription; 
use Filament\Notifications\Notification;


class ReadBookPage extends Page
{
    protected static ?string $slug = 'read';
    protected static string $view = 'filament.pages.read-book-page';
    protected static ?string $title = 'Halaman Membaca Buku — Selamat Membaca! 📕 ';
    protected static ?string $navigationLabel = null;
    protected static ?string $navigationIcon = null;

    protected static ?string $resource = null;

    public ?Book $book = null;
    public ?int $currentPage = 1; 
    public ?float $progressPercentage = 0.0; 

     // Properti untuk menyimpan instance ReadHistory
    public ?ReadHistory $readHistory = null;

    public function mount(Book $book): void 
    {
        // $this->book = Book::findOrFail($book);
        $this->book = $book;
        
        if ($this->book->is_premium && (!Auth::check() || !Auth::user()->hasActiveSubscription())) {
            redirect()->to(\App\Filament\Pages\SubscriptionPage::getUrl())->with('error', 'Anda perlu berlangganan premium untuk mengakses buku ini.');
            return; 
        }

        $user = Auth::user();
        if ($user) {
            // Cari atau buat entri riwayat baca untuk user dan buku ini
            $this->readHistory = ReadHistory::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'book_id' => $this->book->id,
                ],
                [
                    'last_page_read' => 1, // Default halaman 
                    'progress_percentage' => 0.0,
                    'last_read_at' => now(),
                ]
            );
            // Set halaman saat ini dan persentase berdasarkan riwayat yang ditemukan
            $this->currentPage = $this->readHistory->last_page_read ?? 1;
            $this->progressPercentage = $this->readHistory->progress_percentage ?? 0.0;
            // Update waktu terakhir dibaca setiap kali mount
            $this->readHistory->update(['last_read_at' => now()]);
        }
    }

    //  untuk memperbarui progres baca
    public function updateReadingProgress(int $pageNumber): void
    {
        if ($pageNumber < 1 || ($this->book && $pageNumber > $this->book->total_pages)) {
            return;
        }

        $this->currentPage = $pageNumber;
        if ($this->book && $this->book->total_pages > 0) {
            $this->progressPercentage = ($this->currentPage / $this->book->total_pages) * 100;
        } else {
            $this->progressPercentage = 0.0;
        }

        if ($this->readHistory) {
            $this->readHistory->update([
                'last_page_read' => $this->currentPage,
                'progress_percentage' => round($this->progressPercentage, 2),
                'last_read_at' => now(),
                'finished_at' => ($this->currentPage >= $this->book->total_pages) ? now() : null,
            ]);
            Notification::make()->title('Progres membaca disimpan!')->success()->duration(1000)->send();
        }
    }
    
    public function updateScrollProgress(int $pageNumber, float $progressPercentage): void // <<< PERUBAHAN
    {
        $this->updateReadingProgress($pageNumber); // Panggil metode yang sudah ada

        $this->progressPercentage = $progressPercentage; // Update properti komponen
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
