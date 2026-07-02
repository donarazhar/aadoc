<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Front\DocumentController as FrontDocumentController;

Route::get('/', [FrontDocumentController::class, 'index'])->name('home');
Route::get('/docs/{categorySlug}', [FrontDocumentController::class, 'category'])->name('docs.category');
Route::get('/docs/{categorySlug}/{documentSlug}', [FrontDocumentController::class, 'show'])->name('docs.show');
Route::get('/search', [FrontDocumentController::class, 'search'])->name('docs.search');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::post('upload-image', [\App\Http\Controllers\Admin\ImageUploadController::class, 'store'])->name('upload-image');
        Route::post('categories/reorder', [\App\Http\Controllers\Admin\CategoryController::class, 'reorder'])->name('categories.reorder');
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('documents', \App\Http\Controllers\Admin\DocumentController::class);
    });
});

require __DIR__.'/auth.php';
