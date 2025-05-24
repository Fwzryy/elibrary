<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\User\PaymentController;

Route::get('/', function () {
    return view('welcome');
    
});
Route::post('/user/submit-payment', [PaymentController::class, 'store'])->name('user.submit-payment');
