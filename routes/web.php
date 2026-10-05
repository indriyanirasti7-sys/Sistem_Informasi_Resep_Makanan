<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\TipController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// Public
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/resep', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/resep/{recipe:slug}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/tips', [TipController::class, 'index'])->name('tips.index');
Route::get('/tips/{tip:slug}', [TipController::class, 'show'])->name('tips.show');
Route::get('/bookmark', [BookmarkController::class, 'favorit'])->name('bookmarks.favorit');

require __DIR__.'/auth.php';

// Auth required
Route::middleware('auth')->group(function () {
    Route::get('/bookmark', [BookmarkController::class, 'favorit'])->name('bookmarks.favorit');
    Route::post('/bookmark/{recipe:slug}', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
    Route::delete('/bookmark/{bookmark}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');

    Route::post('/resep/{recipe:slug}/rating', [RatingController::class, 'store'])->name('ratings.store');
    Route::delete('/rating/{rating}', [RatingController::class, 'destroy'])->name('ratings.destroy');
    // Profile
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
});
// Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('recipes', Admin\RecipeController::class);
    Route::resource('categories', Admin\CategoryController::class);

    Route::get('/export/recipes', [Admin\ExportController::class, 'recipes'])->name('export.recipes');
    Route::get('/export/users', [Admin\ExportController::class, 'users'])->name('export.users');
});