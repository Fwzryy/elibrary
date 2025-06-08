<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Payment; 
use App\Enums\PaymentStatus; 
use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Pendapatan Disetujui (7 Hari Terakhir)'; 

    protected static ?string $type = 'line';

    protected static ?string $pollingInterval = '30s'; 

    protected int | string | array $columnSpan = 'half';
    protected static ?int $sort = 2; 

    protected function getData(): array
    {
        $data = [];
        $labels = [];
        $startDate = Carbon::now()->subDays(6); // 7 hari lalu

        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $labels[] = $date->translatedFormat('D, d M'); 

            $revenue = Payment::where('status', PaymentStatus::Approved)
                ->whereDate('approved_at', $date->toDateString())
                ->sum('amount');
            $data[] = (float) $revenue; // Memastikan data numerik
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan Harian',
                    'data' => $data,
                    'borderColor' => '#10B981', 
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
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