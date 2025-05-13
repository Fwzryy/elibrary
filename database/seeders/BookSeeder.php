<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class BookSeeder extends Seeder
{

    public function run(): void
    {
        $category = Category::first(); //Ambil salah satu kategori

        Book::create([
          'title' => 'The Art of Learning',
          'description' => 'A deep dive into learning effectively.',
          'cover_image' => 'covers/sample-cover.jpg',
          'file_path' => 'books/sample-book.pdf',
          'is_free' => true,
          'category_id' => $category->id,
        ]);

        Book::create([
            'title' => 'About Laravel Filament',
            'description' => 'Learn advanced Laravel features.',
            'cover_image' => 'covers/laravel-book.jpg',
            'file_path' => 'books/laravel-book.pdf',
            'is_free' => false,
            'category_id' => $category->id,
        ]);
    }
}
