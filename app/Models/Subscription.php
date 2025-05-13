<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // Tambahkan ini
use Illuminate\Support\Facades\Log;

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
        'start_date',
        'end_date',
        'amount',
        'currency',
        'duration_days',
        'status',
        'payment_method',
        'transaction_id',
        'notes',
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
        Log::debug('Subscription Model: user() relation accessed.'); // Log saat relasi diakses
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Sebuah Subscription bisa memiliki banyak Payments.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && $this->end_date->isFuture();
    }

    public function isExpired(): bool
    {
        return $this->status === 'expired';
    }
}
