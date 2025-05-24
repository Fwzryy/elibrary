<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Payment; // Pastikan ini di-import

class SubscriptionStatusWidget extends Widget
{
    protected static string $view = 'filament.widgets.subscription-status-widget'; // Nama view Blade Anda

    public ?string $subscriptionStatus = 'Belum Berlangganan';
    public ?string $packageDetails = null;
    public ?string $startDate = null;
    public ?string $endDate = null;
    public ?string $remainingDays = null;


    protected function getViewData(): array
    {
        $user = Auth::user();

        if ($user->subscription_start_at) {
            // Ambil pembayaran 'approved' terbaru yang terkait dengan user dan paket langganan
            $latestApprovedPayment = $user->payments()
                                        ->where('status', 'approved')
                                        ->whereNotNull('approved_at')
                                        ->latest('approved_at') // Urutkan berdasarkan waktu approve terbaru
                                        ->with('subscriptionPackage') // Eager load relasi paket
                                        ->first();

            if ($latestApprovedPayment && $latestApprovedPayment->subscriptionPackage) {
                $package = $latestApprovedPayment->subscriptionPackage;

                $this->packageDetails = $package->name . ' (' . $package->duration_days . ' Hari)';
                $this->startDate = Carbon::parse($user->subscription_start_at)->translatedFormat('d F Y'); // Menggunakan kolom di users
                $endDate = Carbon::parse($user->subscription_start_at)->addDays($package->duration_days);
                $this->endDate = $endDate->translatedFormat('d F Y');

                if (Carbon::now()->lt($endDate)) {
                    $this->subscriptionStatus = 'Aktif';
                    $this->remainingDays = (int) Carbon::now()->diffInDays($endDate) . ' hari tersisa';
                } else {
                    $this->subscriptionStatus = 'Kadaluarsa';
                    $this->remainingDays = '0 hari tersisa';
                }
            } else {
                $this->subscriptionStatus = 'Belum Berlangganan'; // Atau ada pembayaran tapi paket tidak ditemukan
            }
        }

        return [
            'subscriptionStatus' => $this->subscriptionStatus,
            'packageDetails' => $this->packageDetails,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'remainingDays' => $this->remainingDays,
        ];
    }
}