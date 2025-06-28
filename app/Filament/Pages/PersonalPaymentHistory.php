<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Payment;

class PersonalPaymentHistory extends Page 
{
    protected static ?string $title = 'Riwayat Pembayaran Saya';
    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';
    protected static ?string $navigationGroup = 'Akun Saya';
    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.personal-payment-history';

    public ?User $currentUser;
    public $userPayments;

    public function mount(): void
    {
        $this->currentUser = Auth::user();
        if ($this->currentUser) {
            $this->userPayments = Payment::where('user_id', $this->currentUser->id)
              ->with('subscriptionPackage') 
                ->orderByDesc('created_at')
                  ->get();
        } else {
            $this->userPayments = collect(); 
        }
    }

    public static function shouldBeVisible(): bool
    {
        $user = Auth::user();
        return $user && ! $user->isAdmin();
    }
}