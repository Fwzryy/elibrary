<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User; 
use App\Models\ReadHistory; 
use App\Models\Category; 
use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon;

class UserCategoryReadChart extends ChartWidget
{
    protected static ?string $heading = 'Buku yang Saya Baca Berdasarkan Kategori 🗂️';

    protected static ?string $type = 'doughnut'; // / pie'

    protected static ?string $pollingInterval = '30s';
    protected static ?string $maxHeight = '300px';

    protected int | string | array $columnSpan = 'half'; 
    protected static ?int $sort = 1; 

    protected function getData(): array
    {
        $user = Auth::user();
        $labels = [];
        $data = [];
        $backgroundColors = [];

        if ($user) {
            $readingByCategory = $user->readHistories() 
                                    ->with('book.category') 
                                    ->get()
                                    ->groupBy(function($history) {
                                        return $history->book->category->name ?? 'Lain-lain';
                                    });

            foreach ($readingByCategory as $categoryName => $histories) {
                $labels[] = $categoryName;
                $data[] = $histories->count(); 

                $backgroundColors[] = $this->getRandomColor(); 
            }
        }

        return [
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => $backgroundColors,
                ],
            ],
            'labels' => $labels,
        ];
    }

    private function getRandomColor(): string
    {
        $colors = [
            '#F97316', '#EF4444', '#EAB308', '#22C55E', '#0EA5E9', '#6366F1', '#EC4899', '#A855F7', '#F43F5E', '#14B8A6'
        ];
        return $colors[array_rand($colors)];
    }

    protected function getType(): string
    {
        return 'doughnut'; // Atau 'doughnut'
    }

    protected function getOptions(): array
    {
      
        return [];
   
    }

    public static function shouldBeVisible(): bool
    {
        $user = Auth::user();
        return $user && ! $user->isAdmin();
    }
}