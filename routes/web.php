<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Front\DocumentController as FrontDocumentController;

Route::get('/', [FrontDocumentController::class, 'index'])->name('home');
Route::get('/docs/{categorySlug}', [FrontDocumentController::class, 'category'])->name('docs.category');
Route::get('/docs/{categorySlug}/{documentSlug}', [FrontDocumentController::class, 'show'])->name('docs.show');
Route::get('/search', [FrontDocumentController::class, 'search'])->name('docs.search');

Route::get('/dashboard', function () {
    $totalCategories = \App\Models\Category::count();
    $totalDocuments = \App\Models\Document::count();
    return view('dashboard', compact('totalCategories', 'totalDocuments'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('documents', \App\Http\Controllers\Admin\DocumentController::class);
    });
});

require __DIR__.'/auth.php';
