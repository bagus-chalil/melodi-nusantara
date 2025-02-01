<?php

use App\Http\Controllers\Api\PlaylistApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SongApiController;

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/songs', [SongApiController::class, 'index']); // GET semua lagu
    Route::get('/songs/search', [SongApiController::class, 'search']); // Cari lagu
    Route::get('/songs/{id}', [SongApiController::class, 'show']); // GET detail lagu

    Route::get('/playlists', [PlaylistApiController::class, 'index']);
    Route::post('/playlists/add-song', [PlaylistApiController::class, 'addSongToPlaylist']);
    Route::get('/playlists/{id}', [PlaylistApiController::class, 'show']);
    Route::get('/playlists/{playlistId}/song/{songId}/next-prev', [PlaylistApiController::class, 'getNextPrevSong']);
    Route::delete('/playlists/{id}', [PlaylistApiController::class, 'destroy']);
});

