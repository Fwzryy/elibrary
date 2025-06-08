<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Filament\Http\Middleware\Authenticate; 
use App\Filament\Widgets\LatestBooksWidget; 
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use App\Filament\Widgets\SubscriptionStatusWidget;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

use App\Filament\Resources;
use App\Filament\Resources\ReadHistoryResource;//untuk widget admin
use App\Filament\Resources\PaymentResource; // untuk widget admin
use App\Filament\Pages\ReadBookPage;
use App\Filament\Pages\SubscriptionPage;
use App\Filament\Pages\PricingPage;
use App\Filament\Pages\ReadingHistory;
use App\Filament\Pages\UploadPaymentPage;
// use App\Filament\Pages\BookList;

use App\Filament\Pages\Dashboard;
use App\Filament\Pages\AdminOverview;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->sidebarCollapsibleOnDesktop()
            ->brandName('Elibrary.')
            ->spa()
            ->login()
            ->registration()
            ->colors([
                'primary' => Color::Violet,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                // Pages\Dashboard::class
                Dashboard::class,
                ReadBookPage::class,
                SubscriptionPage::class,
                PricingPage::class,
                ReadingHistory::class,
                UploadPaymentPage::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,

                // Widget Status Langganan (general)
                SubscriptionStatusWidget::class, 
                // Widget Buku Terbaru (general)
                LatestBooksWidget::class, 

                // App\Filament\Widgets\BooksReadChart::class,
                // App\Filament\Widgets\RevenueChart::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->resources([ // Tambahkan array ini
            PaymentResource::class,
            ReadHistoryResource::class,
        ]);
    }
}
