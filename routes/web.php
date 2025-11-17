<?php

use App\Http\Controllers\BeanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Home / Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Beans - Public & Auth
Route::resource('beans', BeanController::class);

// Reviews - Auth required
Route::middleware('auth')->group(function () {
    Route::post('beans/{bean}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Discussions - Public & Auth
Route::resource('discussions', DiscussionController::class);
Route::middleware('auth')->group(function () {
    Route::post('discussions/{discussion}/replies', [DiscussionController::class, 'storeReply'])->name('discussions.replies.store');
});

// User Dashboard & Profile - Auth required
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/journal', [DashboardController::class, 'journal'])->name('journal.index');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // User public profile
    Route::get('/users/{user}', [ProfileController::class, 'public'])->name('users.show');
});

// Placeholder auth routes (will be replaced with Laravel Breeze)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');
