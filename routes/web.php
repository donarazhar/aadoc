<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Front\DocumentController as FrontDocumentController;

Route::get('/auth/google', [\App\Http\Controllers\Auth\SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [\App\Http\Controllers\Auth\SocialiteController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::middleware('auth')->group(function () {
    // Public routes (but require login)
    Route::get('/', [FrontDocumentController::class, 'index'])->name('home');
    Route::get('/docs/{categorySlug}', [FrontDocumentController::class, 'category'])->name('docs.category');
    Route::get('/docs/{categorySlug}/{documentSlug}', [FrontDocumentController::class, 'show'])->name('docs.show');
    Route::get('/search', [FrontDocumentController::class, 'search'])->name('docs.search');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Superadmin routes
    Route::middleware(['superadmin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::post('upload-image', [\App\Http\Controllers\Admin\ImageUploadController::class, 'store'])->name('upload-image');
            Route::post('categories/reorder', [\App\Http\Controllers\Admin\CategoryController::class, 'reorder'])->name('categories.reorder');
            Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
            Route::post('documents/reorder', [\App\Http\Controllers\Admin\DocumentController::class, 'reorder'])->name('documents.reorder');
            Route::resource('documents', \App\Http\Controllers\Admin\DocumentController::class);
            Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
            
            // Backups
            Route::get('backups', [\App\Http\Controllers\Admin\BackupController::class, 'index'])->name('backups.index');
            Route::post('backups/generate', [\App\Http\Controllers\Admin\BackupController::class, 'generate'])->name('backups.generate');
            Route::get('backups/download/{file}', [\App\Http\Controllers\Admin\BackupController::class, 'download'])->name('backups.download');
            Route::post('backups/restore', [\App\Http\Controllers\Admin\BackupController::class, 'restore'])->name('backups.restore');
            Route::delete('backups/{file}', [\App\Http\Controllers\Admin\BackupController::class, 'destroy'])->name('backups.destroy');
        });
    });
});

require __DIR__.'/auth.php';
