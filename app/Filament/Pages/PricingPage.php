<?php

namespace App\Filament\Pages;

use Illuminate\Support\Facades\Auth; 

use Filament\Pages\Page;

class PricingPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static string $view = 'filament.pages.pricing-page';

    protected static ?string $title = 'Pilihan Paket Premium → Langganan ';
    protected static ?string $navigationLabel = 'Langganan';
    protected static ?int $navigationSort = 10;


    public static function shouldRegisterNavigation(): bool
    {      // Tampilkan hanya jika user login dan belum memiliki langganan aktif
        return Auth::check() && !Auth::user()->isAdmin();
    }

}
