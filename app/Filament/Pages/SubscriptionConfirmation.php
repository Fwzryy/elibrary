<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth; // Pastikan ini di-import
use App\Models\User; // Pastikan ini di-import
use Carbon\Carbon; // Pastikan ini di-import

class SubscriptionConfirmation extends Page
{
    protected static ?string $title = 'Status Langganan Anda ✨';
    protected static ?string $navigationIcon = 'heroicon-o-check-badge'; // Ikon yang sesuai
    protected static ?string $navigationLabel = 'Konfirmasi Langganan'; // Label navigasi (opsional)
    protected static ?int $navigationSort = 11; // Urutan di sidebar admin (misal, setelah PricingPage)

    protected static string $view = 'filament.pages.subscription-confirmation';

    public ?User $currentUser; // Properti untuk menyimpan user yang login
    public ?string $remainingDays = null; // Sisa hari
    public ?string $packageType = null; // Jenis paket

    public function mount(): void
    {
        $this->currentUser = Auth::user();

        if ($this->currentUser && $this->currentUser->isActiveSubscriber()) {
              $this->remainingDays = floor(Carbon::now()->diffInDays($this->currentUser->subscription_ends_at, false)) . ' hari';
            $lastApprovedPayment = $this->currentUser->payments()
                                                    ->where('status', \App\Enums\PaymentStatus::Approved)
                                                    ->with('subscriptionPackage')
                                                    ->orderByDesc('approved_at')
                                                    ->first();
            if ($lastApprovedPayment && $lastApprovedPayment->subscriptionPackage) {
                $this->packageType = $lastApprovedPayment->subscriptionPackage->name;
            } else {
                $this->packageType = 'Tidak Diketahui';
            }
        } else {
            $this->remainingDays = 'Tidak aktif';
            $this->packageType = 'Belum Ada';
        }
    }

    // Hanya user non-admin yang bisa melihat halaman ini
    public static function shouldBeVisible(): bool
    {
        $user = Auth::user();
        return $user && ! $user->isAdmin();
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        return $user && ! $user->isAdmin();
    }
}