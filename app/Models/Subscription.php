<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; 
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Subscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'subscription_package_id',
        'payment_id',
        'start_date',
        'end_date',
        'status',
        'notes',
        'amount',
        'currency',
        'duration_days',
        'payment_method',
        'transaction_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'amount' => 'decimal:2',
        'duration_days' => 'integer',
        'status' => 'string',
    ];
    public static function booted(): void
    {
        // Sync user's subscription_ends_at on create or update
        static::saved(function (Subscription $subscription) {
            if ($subscription->status === 'completed') {
                $user = $subscription->user;
                $user->subscription_ends_at = $subscription->end_date;
                $user->saveQuietly();
            }
        });
    }

    /**
     * Relasi: Sebuah Subscription dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Relasi: Sebuah Subscription dikaitkan dengan satu SubscriptionPackage.
     */
    public function subscriptionPackage(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPackage::class);
    }
    /**
     * Relasi: Sebuah Subscription diaktifkan oleh satu Payment.
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && $this->end_date && $this->end_date->isFuture();
    }

    public function isExpired(): bool
    {
          return $this->end_date && $this->end_date->isPast();
    }

    public function getAmountAttribute($value)
    {
        return $value ?? $this->subscriptionPackage->price ?? $this->payment->amount ?? null;
    }

    // Anda bisa tambahkan helper untuk mendapatkan durasi hari dari paket
    public function getDurationDaysAttribute($value)
    {
        return $value ?? $this->subscriptionPackage->duration_days ?? null;
    }
}
