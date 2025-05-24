<?php

namespace App\Models;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'duration_days',
        'description',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_days' => 'integer',
        'is_active' => 'boolean',
    ];
    /**
     * Relasi: Sebuah SubscriptionPackage bisa punya banyak Subscription (instance langganan).
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function payments(): HasMany
    {
        //  'subscription_package_id' adalah FK di tabel 'payments' yang merujuk ke model ini.
        return $this->hasMany(Payment::class, 'subscription_package_id');
    }


    protected $table = 'subscription_packages'; // Pastikan nama tabel benar
}