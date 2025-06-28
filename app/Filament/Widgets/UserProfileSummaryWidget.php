<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth; 
use App\Models\User; 

class UserProfileSummaryWidget extends Widget
{
    protected static string $view = 'filament.widgets.user-profile-summary-widget';

    protected static ?string $heading = 'Profil Singkat Saya'; 
    protected int | string | array $columnSpan = 'half'; 
    protected static ?int $sort = 1; 

    public ?User $user = null; 

    public function mount(): void
    {
        $this->user = Auth::user();
    }

    public static function shouldBeVisible(): bool
    {
        $user = Auth::user();
        return $user && ! $user->isAdmin();
    }
}