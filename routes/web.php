<?php

use Illuminate\Support\Facades\Route;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;

// Home route
Route::get('/', function () {
    return view('home');
});

// Mail route
Route::get('/send-mail', function () {
    Mail::to('test@example.com')->send(new TestMail());
    return 'Mail đã được gửi thành công!';
});

// Authentication routes
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'create')->name('register');
    Route::post('/register', 'store');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('guest')->group(function () {
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('/forgot-password', 'showLinkRequestForm')->name('password.request');
        Route::post('/forgot-password', 'sendResetLinkEmail')->name('password.email');
        Route::get('/reset-password/{token}', 'showResetForm')->name('password.reset');
        Route::post('/reset-password', 'reset')->name('password.update');
    });
});
