<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth; 
use Filament\Facades\Filament; 

class LibraryManagement extends Page
{
    protected static ?string $title = 'Pengelolaan Perpustakaan 📚';
    protected static ?string $navigationIcon = 'heroicon-o-book-open'; 
    protected static ?string $navigationLabel = 'Kelola Buku & Kategori';
    protected static ?string $navigationGroup = 'Pengelolaan Library';  

    protected static string $view = 'filament.pages.library-management';

    // Hanya admin yang bisa melihat dan mengakses halaman ini
    public static function shouldBeVisible(): bool
    {
        $user = Auth::user();
        return $user && $user->isAdmin();
    }

    // mengontrol apakah item navigasi untuk halaman ini muncul di sidebar.
    // Hanya admin yang bisa melihatnya.
    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        return $user && $user->isAdmin();
    }
}