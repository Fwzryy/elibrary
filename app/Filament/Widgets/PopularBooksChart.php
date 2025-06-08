<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\ReadHistory; 
use App\Models\Book; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Collection; 

class PopularBooksChart extends ChartWidget
{
    protected static ?string $heading = 'Buku Paling Banyak Diminati';

    protected static string $color = 'primary'; 
    protected static ?string $maxHeight = '300px'; 

    protected static ?string $type = 'bar';
    protected static ?string $pollingInterval = '30s';

    protected int | string | array $columnSpan = 'full'; 
    protected static ?int $sort = 5; 

    protected function getData(): array
    {
        $labels = [];
        $data = [];
        $backgroundColors = []; 

        $readingByBook = ReadHistory::with('book')
                                    ->get()
                                    ->groupBy('book_id') 
                                    ->map(function(Collection $histories) {
                                        return $histories->count(); 
                                    })
                                    ->sortDesc() 
                                    ->take(10); 

        $topBookIds = $readingByBook->keys()->all();
        $topBooks = Book::whereIn('id', $topBookIds)->get()->keyBy('id'); 

        foreach ($readingByBook as $bookId => $count) {
            $book = $topBooks->get($bookId);
            if ($book) {
                $labels[] = $book->title; 
                $data[] = $count; 
                $backgroundColors[] = $this->getRandomColor(); 
            }
        }

       
        if (empty($data)) {
            $labels = ['Belum ada data'];
            $data = [1];
            $backgroundColors = ['#cccccc'];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Dibaca',
                    'data' => $data,
                    'backgroundColor' => $backgroundColors,
                    'borderColor' => 'rgb(153, 102, 255)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    
    private function getRandomColor(): string
    {
        $colors = [
      'rgba(255, 99, 132, 0.65)',
      'rgba(255, 159, 64, 0.65)',
      'rgba(255, 205, 86, 0.65)',
      'rgba(75, 192, 192, 0.65)',
      'rgba(54, 162, 235, 0.65)',
      'rgba(153, 102, 255, 0.65)',
      'rgba(201, 203, 207, 0.65)'
        ];
        static $usedColors = [];
        $availableColors = array_diff($colors, $usedColors);
        if (empty($availableColors)) {
            $usedColors = [];
            $availableColors = $colors;
        }
        $selectedColor = $availableColors[array_rand($availableColors)];
        $usedColors[] = $selectedColor;
        return $selectedColor;
    }


    protected function getType(): string
    {
        return 'bar'; 
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