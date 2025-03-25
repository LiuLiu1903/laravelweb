<?php

use Illuminate\Support\Facades\Route;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('home');
});

Route::get('/send-mail', function () {
    Mail::to('test@example.com')->send(new TestMail());
    return 'Mail đã được gửi thành công!';
});

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);                   

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');