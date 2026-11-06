<?php

use App\Http\Controllers\PhotoGalleryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PhotoGalleryController::class, 'index'])->name('index');
Route::get('/photo_gallery', [PhotoGalleryController::class, 'photoGallery'])
    ->middleware(['auth', 'verified'])
    ->name('photo_gallery');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/gallery/{category}', [PhotoGalleryController::class, 'category'])->name('gallery.category');
Route::get('/gallery/form/{category}', [PhotoGalleryController::class, 'create'])->name('gallery.category_form');
Route::post('/gallery/store/{category}', [PhotoGalleryController::class, 'store'])->name('gallery.store');
Route::get('/gallery/show/{photoGallery}', [PhotoGalleryController::class, 'show'])->name('gallery.show');
Route::get('/gallery/edit/{photoGallery}', [PhotoGalleryController::class, 'edit'])->name('gallery.edit');
Route::put('/gallery/update/{photoGallery}', [PhotoGalleryController::class, 'update'])->name('gallery.update');
Route::delete('/gallery/destroy/{photoGallery}', [PhotoGalleryController::class, 'destroy'])->name('gallery.destroy');

require __DIR__.'/auth.php';


