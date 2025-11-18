<?php

use App\Http\Controllers\BeanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;

// Home / Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Beans - Public routes
Route::resource('beans', BeanController::class)->only(['index', 'show']);

// Beans - Auth required routes
Route::middleware('auth')->group(function () {
    Route::resource('beans', BeanController::class)->except(['index', 'show']);
});

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
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/journal', [DashboardController::class, 'journal'])->name('journal.index');
    Route::post('/journal', [DashboardController::class, 'storeJournal'])->name('journal.store');
    Route::delete('/journal/{userBean}', [DashboardController::class, 'destroyJournal'])->name('journal.destroy');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public user profile
Route::get('/users/{user}', [ProfileController::class, 'public'])->name('users.show');

// Admin Dashboard - Admin only
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::patch('/discussions/{discussion}/pin', [AdminDashboardController::class, 'pinDiscussion'])->name('discussions.pin');
    Route::patch('/discussions/{discussion}/lock', [AdminDashboardController::class, 'lockDiscussion'])->name('discussions.lock');
    Route::delete('/users/{user}', [AdminDashboardController::class, 'deleteUser'])->name('users.delete');
});

require __DIR__.'/auth.php';
