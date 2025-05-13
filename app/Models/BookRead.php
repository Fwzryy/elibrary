<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- Tambahkan ini

class BookRead extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'book_id',
        'last_page_read',
        'progress_percentage',
        'last_read_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_page_read' => 'integer',
        'progress_percentage' => 'decimal:2', // Cast ke float/decimal dengan 2 angka di belakang koma
        'last_read_at' => 'datetime', // Cast ke objek Carbon
    ];

    /**
     * Relasi: Sebuah BookRead dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Sebuah BookRead terkait dengan satu Book.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

}
