<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\TipController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// ========== PUBLIC ROUTES ==========
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/resep', [RecipeController::class, 'daftar_resep'])->name('recipes.daftar_resep');
Route::get('/resep/{recipe:slug}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/tips', [TipController::class, 'panduan'])->name('tips.panduan');
Route::get('/tips/{tip:slug}', [TipController::class, 'show'])->name('tips.detail_tips');
Route::get('/bookmark', [BookmarkController::class, 'favorit'])->name('bookmarks.favorit');

require __DIR__.'/auth.php';

// ========== AUTHENTICATED ROUTES ==========
Route::middleware('auth')->group(function () {
    Route::post('/bookmark/{recipe:slug}', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
    Route::delete('/bookmark/{bookmark}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');

    Route::post('/resep/{recipe:slug}/rating', [RatingController::class, 'store'])->name('ratings.store');
    Route::delete('/rating/{rating}', [RatingController::class, 'destroy'])->name('ratings.destroy');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::post('/reviews/{rating}/vote', [\App\Http\Controllers\RatingController::class, 'toggleVote'])->name('reviews.vote');

});

// ========== ADMIN ROUTES ==========
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // ✅ Rute Kustom Detail (Diletakkan di ATAS resource agar tidak bentrok)
    Route::get('/recipes/{recipe}/detail', [Admin\RecipeController::class, 'detail_tampilan'])->name('recipes.detail_tampilan');
    Route::get('/tips/{tip}/detail', [Admin\TipController::class, 'detail'])->name('tips.detail');

    // ✅ Resource (Kecualikan 'show' karena sudah diganti dengan rute kustom di atas)
    Route::resource('recipes', Admin\RecipeController::class)->except(['show']);
    Route::resource('categories', Admin\CategoryController::class);
    Route::resource('tips', Admin\TipController::class)->except(['show']);  
    Route::resource('users', Admin\UserController::class)->except(['create', 'store', 'edit']);
    Route::resource('reviews', Admin\ReviewController::class)->only(['index', 'destroy']); 
    
    // Settings & Export
    Route::get('/settings', [Admin\SettingController::class, 'index'])->name('settings.index');
    Route::get('/export/recipes', [Admin\ExportController::class, 'recipes'])->name('export.recipes');
    Route::get('/export/users', [Admin\ExportController::class, 'users'])->name('export.users');
});