<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PhotoController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['auth'])->post('/photos', [PhotoController::class, 'store'])->name('photos.store');

    Route::middleware('auth')->group(function () {
    Route::get('/photos/{photo}', [PhotoController::class, 'show'])->name('photos.show'); // View photo
    Route::get('/photos/{photo}/edit', [PhotoController::class, 'edit'])->name('photos.edit'); // Edit photo form
    Route::put('/photos/{photo}', [PhotoController::class, 'update'])->name('photos.update'); // Update photo
    Route::delete('/photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy'); // Delete photo
    });
});


require __DIR__.'/auth.php';
