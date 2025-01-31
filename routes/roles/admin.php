<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\SongsController;

//role admin
Route::middleware('auth')->group(function () {
    Route::middleware(['auth', 'role:Super Admin|Admin'])->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('genres', GenresController::class)->except(['show']);
            Route::resource('songs', SongsController::class)->except(['show']);
        });
        Route::delete('genres/batch-delete', [GenresController::class, 'batchDelete'])->name('genres.batchDelete');
        Route::delete('songs/batch-delete', [SongsController::class, 'batchDelete'])->name('genres.batchDelete');
    });
});


