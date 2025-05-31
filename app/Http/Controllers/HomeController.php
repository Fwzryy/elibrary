<?php

namespace App\Http\Controllers;

use App\Models\Book; // Import model Book 
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Mengambil 3 buku terbaru berdasarkan tanggal pembuatan (created_at).
        $latestBooks = Book::orderBy('created_at', 'desc')->limit(3)->get();

        // Mengirim data $latestBooks ke view 'welcome.blade.php'
        return view('welcome', [
            'latestBooks' => $latestBooks,
        ]);
    }
}