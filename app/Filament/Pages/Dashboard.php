<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use App\Filament\Widgets\SubscriptionStatusWidget; 
use App\Filament\Widgets\LatestBooksWidget; 
use App\Filament\Widgets\AdminStatsOverview;
use App\Filament\Widgets\ContinueReadingWidget;
use App\Filament\Widgets\PopularBooksChart;
use App\Filament\Widgets\PremiumUserGrowthChart;
use App\Filament\Widgets\RevenueChart;
use App\Filament\Widgets\UserCategoryReadChart;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = null;
    public ?User $user = null;
    /// metode mount() untuk mengisi properti user
    public function mount(): void 
    {
        $this->user = Auth::user();
    }

    public function getWidgets(): array
    {
        $user = Auth::user();

        if ($user && $user->isAdmin()) {
            return [
                AccountWidget::class,
                FilamentInfoWidget::class,
                AdminStatsOverview::class,
                RevenueChart::class,
                PremiumUserGrowthChart::class,
                PopularBooksChart::class,
            ];
        } else {
            // Widget untuk USER di dashboard utama
            return [
                AccountWidget::class,
                FilamentInfoWidget::class,
                UserCategoryReadChart::class, 
                SubscriptionStatusWidget::class,
                ContinueReadingWidget::class,
                LatestBooksWidget::class,
            ];
        }
    }

    // Metode untuk menyediakan data ke header Blade kustom
    public function getHeader(): ?\Illuminate\Contracts\View\View
    {
        return view('filament.pages.dashboard-header', [
            'user' => $this->user, 
            'is_admin' => $this->user->isAdmin(),
        ]);
    }

    public static function shouldBeVisible(): bool
    {
        return Auth::check();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function getSlug(): string
    {
        return '/';
    }
}