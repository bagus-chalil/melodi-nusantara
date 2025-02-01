<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SongApiController;

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/songs', [SongApiController::class, 'index']); // GET semua lagu
    Route::get('/songs/search', [SongApiController::class, 'search']); // Cari lagu
    Route::get('/songs/{id}', [SongApiController::class, 'show']); // GET detail lagu
});

