<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User; // Import model User
use Illuminate\Support\Facades\Auth; // Import Auth
use Carbon\Carbon; // Import Carbon

class PremiumUserGrowthChart extends ChartWidget
{
    protected static ?string $heading = 'Pertumbuhan Pengguna Premium (12 Bulan Terakhir)';

    protected static string $color = 'info'; // Warna chart
    protected static ?string $maxHeight = '300px'; // Tinggi maksimum chart

    protected static ?string $type = 'line';
    protected static ?string $pollingInterval = '30s'; // Update data setiap 30 detik

    protected int | string | array $columnSpan = 'half'; // <<< PENTING: Set ini ke HALF untuk di sebelah RevenueChart
    protected static ?int $sort = 3; 

    protected function getData(): array
    {
        $data = [];
        $labels = [];
        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subMonths(11)->startOfMonth(); // 12 bulan terakhir

        for ($i = 0; $i < 12; $i++) {
            $month = $startDate->copy()->addMonths($i);
            $labels[] = $month->translatedFormat('M Y'); // Label bulan tahun (contoh: Jan 2024)

            // Hitung jumlah pengguna premium aktif pada akhir bulan tersebut
            $premiumUsers = User::whereNotNull('subscription_ends_at')
                                ->where('subscription_ends_at', '>', $month->endOfMonth()) // Langganan aktif hingga akhir bulan
                                ->where('subscription_start_at', '<=', $month->endOfMonth()) // Dimulai sebelum/pada akhir bulan
                                ->count();
            $data[] = $premiumUsers;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pengguna Premium',
                    'data' => $data,
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)', 
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [];
    }

    // Hanya admin yang bisa melihat widget ini
    public static function shouldBeVisible(): bool
    {
        $user = Auth::user();
        return $user && $user->isAdmin();
    }
}