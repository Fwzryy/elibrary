<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/books/{book}', [BookController::class, 'show'])
    ->middleware(['auth', 'check.subscription'])
    ->name('books.show');
