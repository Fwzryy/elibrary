<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class SubscriptionPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar'; // Icon untuk navigasi sidebar
    protected static string $view = 'filament.pages.subscription-page'; 
    protected static ?string $title = 'Akses Premium 👑'; // Judul halaman
    protected static ?string $navigationLabel = 'Berlangganan'; // Label di sidebar navigasi

    public static function getMiddleware(): array
    {
        return [
            ['middleware' => 'auth', 'options' => []],
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}