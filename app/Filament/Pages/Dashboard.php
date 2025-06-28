<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Widgets\AccountWidget;
use Illuminate\Support\Facades\Auth;
use App\Filament\Widgets\RevenueChart;
use Filament\Widgets\FilamentInfoWidget;
use App\Filament\Widgets\PopularBooksChart;
use App\Filament\Widgets\AdminStatsOverview;
use App\Filament\Widgets\LatestBooksWidget; 
use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\ContinueReadingWidget;
use App\Filament\Widgets\UserCategoryReadChart;
use App\Filament\Widgets\PremiumUserGrowthChart;
use App\Filament\Widgets\UserProfileSummaryWidget;
use App\Filament\Widgets\SubscriptionStatusWidget; 

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
                UserProfileSummaryWidget::class,
                ContinueReadingWidget::class,
                UserCategoryReadChart::class, 
                SubscriptionStatusWidget::class,
                LatestBooksWidget::class,
            ];
        }
    }

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