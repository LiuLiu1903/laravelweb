<?php

use Illuminate\Support\Facades\Route;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Middleware\CheckUserStatus;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostsController;
use App\Models\Post;
use App\Http\Controllers\MediaController;


// Home route
Route::get('/', function () {
    return view('home');
});

// Mail route
Route::get('/send-mail', function () {
    Mail::to('test@example.com')->send(new TestMail());
    return 'Mail đã được gửi thành công!';
});

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

Route::middleware(['auth', CheckUserStatus::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Route::get('posts/{post:slug}', [PostsController::class, 'show'])->name('posts.show');

Route::middleware(['auth'])->group(function () {
    Route::resource('posts', PostsController::class)
        ->parameters(['posts' => 'post:slug']);
    Route::post('/posts/media', [PostsController::class, 'storeMedia'])->name('posts.storeMedia');
});