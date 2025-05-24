<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Filament\Panel;

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
        'is_admin',
        'role',
        'subscription_ends_at',
        'subscription_start_at',
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
        'subscription_start_at' => 'datetime',
        'is_admin' => 'boolean',
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
        return $this->subscription_ends_at !== null && $this->subscription_ends_at->isFuture();
    }
    public function canAccessPanel(Panel $panel): bool
    {
        // Izinkan user dengan role 'admin' untuk mengakses panel
        return $this->isAdmin(); // Menggunakan metode isAdmin() yang sudah Anda miliki
    }
}
