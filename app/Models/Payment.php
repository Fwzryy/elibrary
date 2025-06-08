<?php

namespace App\Models;

use Carbon\Carbon; 
use App\Enums\PaymentStatus; 
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use App\Models\Subscription; 
use App\Models\SubscriptionPackage;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    'user_id',
    // 'subscription_package_id',
    'amount',
    'status',
    'payment_method',
    'transaction_id',
    'subscription_id',
    'proof_image',
    'notes',
    'paid_at',
    'approved_at',
];
  
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2', 
        'status' => \App\Enums\PaymentStatus::class,
        'paid_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

      public static function booted(): void
    {
        static::updated(function (self $payment) {
            if ($payment->isDirty('status') && $payment->status === PaymentStatus::Approved) {
                $user = $payment->user;
                $package = $payment->subscriptionPackage; // Ambil SubscriptionPackage melalui relasi

                if ($user && $package) {
                    $latestSubscription = Subscription::where('user_id', $user->id)
                                          ->where('status', 'active')
                                          ->orderByDesc('end_date')
                                          ->first();

                    // Data yang akan digunakan untuk Subscription
                    $subscriptionData = [
                        'user_id' => $user->id,
                        'subscription_package_id' => $package->id,
                        'payment_id' => $payment->id,
                        'status' => 'active',
                        'notes' => 'Langganan diaktifkan otomatis setelah pembayaran disetujui.',
                        // Kolom dari tabel `subscriptions` yang saat ini wajib diisi,
                        // dan Anda masih memilikinya di migrasi `subscriptions`
                        'amount' => $package->price, // Ambil dari paket
                        'currency' => 'IDR', // Hardcode atau ambil dari paket/payment jika ada
                        'duration_days' => $package->duration_days, // Ambil dari paket
                        'payment_method' => $payment->payment_method, // Ambil dari payment
                        'transaction_id' => $payment->transaction_id, // Ambil dari payment
                    ];

                    if ($latestSubscription) {
                        // Perpanjang langganan yang sudah ada
                        $newEndDate = Carbon::parse($latestSubscription->end_date)->addDays($package->duration_days);
                        
                        $latestSubscription->update(array_merge($subscriptionData, [
                            'end_date' => $newEndDate,
                            // 'start_date' tidak perlu diupdate jika diperpanjang
                        ]));
                    } else {
                        // Buat langganan baru
                        $newSubscription = Subscription::create(array_merge($subscriptionData, [
                            'start_date' => now(),
                            'end_date' => now()->addDays($package->duration_days),
                        ]));
                    }

                    // Sinkronkan subscription_ends_at di model User
                    // Ini dilakukan di booted() Subscription model, jadi tidak perlu di sini lagi
                } else {
                    Log::warning('Payment processed but user or package not found. Payment ID: ' . $payment->id);
                }
            }
        });
    }

    /**
     * Relasi: Sebuah Payment dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     *Relasi: Sebuah Payment dikaitkan dengan satu SubscriptionPackage (paket yang dibeli).
     */
    public function subscriptionPackage()
    {
        return $this->belongsTo(SubscriptionPackage::class, 'subscription_id');
        // 'subscription_id' adalah foreign key di tabel 'payments'
        // yang merujuk ke 'id' di tabel 'subscription_packages'
    }

     /**
     * Relasi: Sebuah Payment dapat dikaitkan dengan satu Subscription (instance langganan yang diaktifkannya).
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
}