<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
  use HasFactory;
  /**
     * @var array<int, string>
     */
  protected $fillable = [
    'category_id',
    'title',
    'author',
    'publisher',
    'publication_year',
    'description',
    'cover_image',
    'file_path',
    'total_pages',
    'isbn',
    'is_free',
  ];
  /**
     * @var array<string, string>
     */
    protected $casts = [
        'publication_year' => 'integer', // Untuk memastikan ini diinterpretasikan sebagai integer
        'total_pages' => 'integer', // Untuk memastikan ini diinterpretasikan sebagai integer
        'is_free' => 'boolean',
    ];

    /**
     * Relasi: Sebuah Book dimiliki oleh satu Category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi: Sebuah Book memiliki banyak BookReads.
     */
    public function bookReads(): HasMany
    {
        return $this->hasMany(BookRead::class);
    }
}
