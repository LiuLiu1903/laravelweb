<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Middleware\CheckUserStatus;
use App\Mail\TestMail;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

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
Route::get('/dashboard', [App\Http\Controllers\PostsController::class, 'dashboard'])->name('dashboard');

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

Route::middleware(['auth'])->group(function () {
    Route::resource('posts', PostsController::class)
        ->parameters(['posts' => 'post:slug']);
    Route::post('/posts/media', [PostsController::class, 'storeMedia'])->name('posts.storeMedia');
    Route::delete('/user/posts/delete-all', [PostsController::class, 'deleteAll'])->name('posts.deleteAll');
    Route::get('/posts/{post:slug}/media', [PostsController::class, 'showMedia'])->name('posts.showMedia');
    Route::get('/posts/profile/trash', [PostsController::class, 'showTrash'])->name('training.posts.profile.trash');
    Route::post('/posts/profile/restore', [PostsController::class, 'restorePost'])->name('training.posts.restore');
});

Route::get('/page-not-found', function () {
    return view('error.pageerror');
})->name('404');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        // Dashboard
        Route::get('/', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // ---- Posts ----
        Route::get('posts/search', [AdminController::class, 'searchPost'])->name('posts.search');
        // Danh sách bài viết
        Route::get('posts', [AdminPostController::class, 'showPosts'])
            ->name('posts.index');
        // Form sửa (edit)
        Route::get('posts/edit/{slug}', [AdminPostController::class, 'showEditPost'])
            ->name('posts.edit');
        // Xử lý cập nhật
        Route::put('posts/{slug}', [AdminPostController::class, 'editPost'])
            ->name('posts.update');
        Route::post('posts/{slug}/status', [PostController::class, 'updateStatus'])->name('posts.updateStatus');

        // ---- Users ----
        // Danh sách user
        Route::get('users', [AdminUserController::class, 'showUsers'])
            ->name('users.index');
        // Form sửa user
        Route::get('users/edit/{id?}', [AdminUserController::class, 'showEditUser'])
            ->name('users.edit');
        Route::put('users/edit', [AdminUserController::class, 'editUser'])
            ->name('users.update');

        // Tìm kiếm user (dùng GET để giữ query string)
        Route::get('users/search', [AdminUserController::class, 'searchUser'])
            ->name('users.search');

        Route::delete('users/{id?}', [AdminUserController::class, 'delete'])
            ->name('users.delete');

    });
