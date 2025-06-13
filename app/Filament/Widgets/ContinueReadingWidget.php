<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth; 
use App\Models\User; 
use App\Models\ReadHistory; 

class ContinueReadingWidget extends Widget
{
    protected static string $view = 'filament.widgets.continue-reading-widget'; 

    protected static ?string $heading = 'Lanjutin Baca nya yuk 📖👇'; 
    protected int | string | array $columnSpan = 'half'; 
    protected static ?int $sort = 1;

    public ?ReadHistory $lastReadHistory = null; 

    public function mount(): void
    {
        $user = Auth::user();
        if ($user) {
        
            $this->lastReadHistory = $user->readHistories()->with('book')->first();
        }
    }

    public static function shouldBeVisible(): bool
    {
        $user = Auth::user();
        return $user && ! $user->isAdmin();
    }
}