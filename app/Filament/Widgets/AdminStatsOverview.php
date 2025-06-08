<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Book;
use App\Models\Payment;
use App\Enums\PaymentStatus;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminStatsOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Mendapatkan statistik dari database
        $totalUsers = User::count();
        $totalBooks = Book::count();
        $totalActiveSubscribers = User::whereNotNull('subscription_ends_at')
                                      ->where('subscription_ends_at', '>', now())
                                      ->count();
        $totalApprovedPayments = Payment::where('status', PaymentStatus::Approved)->sum('amount');
        $totalPendingPayments = Payment::where('status', PaymentStatus::Pending)->count();
        $totalPremiumBooks = Book::where('is_free', false)->count();


        // --- Contoh data historis untuk sparkline (Ganti dengan data aktual dari DB Anda) ---
        // Data ini harusnya diambil dari query historis (misal, jumlah user per hari/minggu)
        $userGrowthData = [10, 15, 20, 18, 25, 30, $totalUsers]; // Contoh: pertumbuhan user
        $bookGrowthData = [2, 3, 4, 3, 5, 4, $totalBooks]; // Contoh: pertumbuhan buku
        $subscriberGrowthData = [1, 2, 2, 3, 3, 3, $totalActiveSubscribers]; // Contoh: pertumbuhan pelanggan
        $revenueHistoryData = [10000, 12000, 15000, 20000, 18000, 25000, (float)$totalApprovedPayments]; // Contoh: pendapatan
        $pendingPaymentTrend = [5, 4, 3, 2, 1, 0, $totalPendingPayments]; // Contoh: tren pembayaran pending
        $premiumBookGrowth = [1, 1, 2, 2, 3, 3, $totalPremiumBooks]; // Contoh: pertumbuhan buku premium
        // --- Akhir contoh data historis ---

        return [
            Stat::make('Total Pengguna', $totalUsers)
                ->description('Jumlah pengguna terdaftar')
                ->descriptionIcon('heroicon-o-users')
                ->color('info')
                ->chart($userGrowthData), 
            Stat::make('Total Buku', $totalBooks)
                ->description('Jumlah buku dalam koleksi')
                ->descriptionIcon('heroicon-o-book-open')
                ->color('warning')
                ->chart($bookGrowthData), 
            Stat::make('Pelanggan Aktif', $totalActiveSubscribers)
                ->description('Pengguna dengan langganan premium')
                ->descriptionIcon('heroicon-o-check-badge')
                ->color('success')
                ->chart($subscriberGrowthData), 
            Stat::make('Pendapatan Disetujui', 'Rp ' . number_format($totalApprovedPayments, 0, ',', '.'))
                ->description('Total pembayaran disetujui')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success')
                ->chart($revenueHistoryData), 
            Stat::make('Pembayaran Pending', $totalPendingPayments)
                ->description('Jumlah pembayaran menunggu persetujuan')
                ->descriptionIcon('heroicon-o-arrow-path')
                ->color('danger')
                ->chart($pendingPaymentTrend),
            Stat::make('Total Buku Premium', $totalPremiumBooks)
                ->description('Jumlah buku berbayar')
                ->descriptionIcon('heroicon-o-star')
                ->color('primary')
                ->chart($premiumBookGrowth), 
        ];
    }

    // Hanya admin yang bisa melihat widget ini
    public static function shouldBeVisible(): bool
    {
        $user = Auth::user();
        return $user && $user->isAdmin();
    }
}