<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\PaymentController;

Route::get('/', [HomeController::class, 'index'])->name('welcome');

Route::post('/user/submit-payment', [PaymentController::class, 'store'])->name('user.submit-payment');

Route::get('/buku-terbaru', [BookController::class, 'showLatestBooks'])->name('listbuku.page');

Route::get('/paket-langganan', [HomeController::class, 'showSubscriptionPackages'])->name('paket.langganan');

Route::get('/tentang-kami', [HomeController::class, 'showAboutUsPage'])->name('tentang.kami');