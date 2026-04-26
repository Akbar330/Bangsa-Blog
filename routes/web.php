<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

/**
 * Public Routes
 */
Route::get('/dashboard', function () {
    if (auth()->user()->hasAnyRole(['admin', 'editor', 'writer'])) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('home');
})->name('dashboard');

Route::get('/', [BlogController::class, 'index'])->name('home');
Route::get('/post/{post:slug}', [BlogController::class, 'show'])->name('posts.show');
Route::get('/category/{category:slug}', [BlogController::class, 'category'])->name('category.show');
Route::get('/tag/{tag:slug}', [BlogController::class, 'tag'])->name('tag.show');
Route::get('/search', [BlogController::class, 'search'])->name('search');

Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');

/**
 * Admin Routes
 */
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin|editor|writer'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Posts Management
    Route::resource('posts', AdminPostController::class);

    // Categories & Tags (Admin/Editor only)
    Route::middleware(['role:admin|editor'])->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('tags', TagController::class);
    });
});

/**
 * Auth Routes (Profile)
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
