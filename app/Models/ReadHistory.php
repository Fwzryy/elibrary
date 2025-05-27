<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- Tambahkan ini

class ReadHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'read_histories';
    protected $fillable = [
        'user_id',
        'book_id',
        'last_page_read',
        'progress_percentage',
        'last_read_at',
        'finished_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_page_read' => 'integer',
        'progress_percentage' => 'decimal:2', // Cast ke float/decimal dengan 2 angka di belakang koma
        'last_read_at' => 'datetime',
        'finished_at' => 'datetime', 
    ];

    /**
     * Relasi: Sebuah riwayat baca dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Sebuah riwayat baca dikaitkan dengan satu Book.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

}
