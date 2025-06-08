<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome'); // Ini akan menampilkan welcome.blade.php
    }

    public function showSubscriptionPackages()
    {
        // Data dummy untuk paket langganan
        $packages = [
            [
                'name' => 'Paket Gratis',
                'price' => 'Rp 0',
                'label' => 'Saat Ini', 
                'highlight' => false,
                'features' => [
                    'Akses Terbatas ke Buku Pilihan',
                    'Baca Online Saja',
                    'Iklan',
                    'Dukungan Komunitas',
                    'Tidak Ada Download Offline',
                ],
                'link' => '#'
            ],
            [
                'name' => 'Premium 30 Hari',
                'price' => 'Rp 20.000',
                'label' => 'Hemat!', 
                'highlight' => true,
                'features' => [
                    'Akses Penuh ke Semua Buku',
                    'Baca Online & Offline',
                    'Bebas Iklan',
                    'Dukungan Prioritas',
                    'Update Buku Mingguan',
                ],
                'link' => '#'
            ],
            [
                'name' => 'Premium 90 Hari',
                'price' => 'Rp 55.000',
                'label' => 'Terpopuler', 
                'highlight' => false,
                'features' => [
                    'Akses Penuh ke Semua Buku',
                    'Baca Online & Offline',
                    'Bebas Iklan',
                    'Dukungan Prioritas',
                    'Update Buku Mingguan',
                ],
                'link' => '#' 
            ],
        ];

        return view('paketlangganan', compact('packages'));
    }

    public function showAboutUsPage()
    {
        return view('tentangkami'); // Memuat tampilan tentangkami.blade.php
    }
}