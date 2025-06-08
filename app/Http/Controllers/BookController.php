<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; // Pastikan Anda memiliki Model Book dan sudah meng-import-nya

class BookController extends Controller
{
    public function showLatestBooks()
    {
        // ------------- BAGIAN INI YANG PERLU DIUBAH -------------
        try {
            // Mengambil semua buku, diurutkan berdasarkan tanggal terbaru,
            // dan dibatasi hingga 12 buku.
            $latestBooks = Book::orderBy('created_at', 'desc')->take(12)->get();
        } catch (\Exception $e) {
            // Ini adalah data dummy yang akan digunakan jika ada error database/Model
            // Pastikan properti 'cover_image', 'title', 'author', dan 'is_free' ada di sini
            $latestBooks = [
                (object)[
                    'id' => 1,
                    'title' => 'Novel Interaksi Antar Galaksi',
                    'cover_image' => 'images/cover-buku-3.jpeg',
                    'author' => 'Samira Hadid',
                    'is_free' => false
                ],
                (object)[
                    'id' => 2,
                    'title' => 'Designed For Work',
                    'cover_image' => 'images/cover-buku6.jpeg',
                    'author' => 'Tim Desain',
                    'is_free' => true
                ],
                (object)[
                    'id' => 3,
                    'title' => 'Customize Your Autumn Clothes',
                    'cover_image' => 'images/cover-buku5.jpeg',
                    'author' => 'Fashionista',
                    'is_free' => false
                ],
                (object)[
                    'id' => 4,
                    'title' => 'Dunia Koding Laravel',
                    'cover_image' => 'images/coding_book.jpg', // Ganti dengan path gambar Anda
                    'author' => 'Programmer Handal',
                    'is_free' => false
                ],
                (object)[
                    'id' => 5,
                    'title' => 'Resep Masakan Nusantara',
                    'cover_image' => 'images/recipe_book.jpg', // Ganti dengan path gambar Anda
                    'author' => 'Chef Juna',
                    'is_free' => true
                ],
                (object)[
                    'id' => 6,
                    'title' => 'Sejarah Peradaban Kuno',
                    'cover_image' => 'images/history_book.jpg', // Ganti dengan path gambar Anda
                    'author' => 'Arkeolog Tua',
                    'is_free' => false
                ],
                (object)[
                    'id' => 7,
                    'title' => 'Memahami Data Science',
                    'cover_image' => 'images/data_science.jpg', // Ganti dengan path gambar Anda
                    'author' => 'Data Scientist',
                    'is_free' => false
                ],
                (object)[
                    'id' => 8,
                    'title' => 'Petualangan di Rimba',
                    'cover_image' => 'images/jungle_adventure.jpg', // Ganti dengan path gambar Anda
                    'author' => 'Petualang Sejati',
                    'is_free' => true
                ],
                (object)[
                    'id' => 9,
                    'title' => 'Kisah Fantasi Naga',
                    'cover_image' => 'images/dragon_fantasy.jpg', // Ganti dengan path gambar Anda
                    'author' => 'Penulis Fantasi',
                    'is_free' => false
                ],
                (object)[
                    'id' => 10,
                    'title' => 'Tips Produktivitas',
                    'cover_image' => 'images/productivity_tips.jpg', // Ganti dengan path gambar Anda
                    'author' => 'Motivator Handal',
                    'is_free' => true
                ],
                (object)[
                    'id' => 11,
                    'title' => 'Desain Grafis Fundamental',
                    'cover_image' => 'images/design_book.jpg', // Ganti dengan path gambar Anda
                    'author' => 'Desainer Grafis',
                    'is_free' => false
                ],
                (object)[
                    'id' => 12,
                    'title' => 'Belajar Keuangan Pribadi',
                    'cover_image' => 'images/finance_book.jpg', 
                    'author' => 'Perencana Keuangan',
                    'is_free' => true
                ],
            ];
        }

        // Melewatkan variabel $latestBooks ke tampilan 'test.blade.php'
        return view('listbuku', compact('latestBooks'));
    }
}