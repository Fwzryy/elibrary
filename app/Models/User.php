<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'subscription_ends_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'subscription_ends_at' => 'datetime',
    ];

    /**
     * Relasi: Seorang User memiliki banyak Subscriptions.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Relasi: Seorang User memiliki banyak BookReads.
     */
    public function bookReads(): HasMany
    {
        return $this->hasMany(BookRead::class);
    }

    /**
     * Relasi: Seorang User memiliki banyak Payments.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Helper method untuk mengecek apakah user adalah admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Helper method untuk mengecek apakah user memiliki langganan aktif.
     */
    public function hasActiveSubscription(): bool
    {
        // Langganan aktif jika subscription_ends_at tidak null DAN tanggal berakhirnya di masa depan
        // Pastikan $this->subscription_ends_at adalah instance dari Carbon
        return $this->subscription_ends_at !== null && $this->subscription_ends_at->isFuture();
    }
}
