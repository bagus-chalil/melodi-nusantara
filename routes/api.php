<?php

use App\Http\Controllers\Api\PlaylistApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SongApiController;
use App\Http\Controllers\Api\UserApiController;

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/songs', [SongApiController::class, 'index']); // GET semua lagu
    Route::get('/songs/search', [SongApiController::class, 'search']); // Cari lagu
    Route::get('/songs/{id}', [SongApiController::class, 'show']); // GET detail lagu

    // Playlist
    Route::get('/playlists', [PlaylistApiController::class, 'index']);
    Route::post('/playlists/add-song', [PlaylistApiController::class, 'addSongToPlaylist']);
    Route::get('/playlists/{id}', [PlaylistApiController::class, 'show']);
    Route::get('/playlists/{playlistId}/song/{songId}/next-prev', [PlaylistApiController::class, 'getNextPrevSong']);
    Route::delete('/playlists/{id}', [PlaylistApiController::class, 'destroy']);
    Route::delete('playlist/{playlistId}/remove-song/{songId}', [PlaylistApiController::class, 'removeSongFromPlaylist']);

    //User
    Route::get('/users', [UserApiController::class, 'index']);
    Route::post('/register', [UserApiController::class, 'register']);
    Route::post('/login', [UserApiController::class, 'login']);
    Route::middleware('auth.jwt')->post('/logout', [UserApiController::class, 'logout']);
    Route::middleware('auth.jwt')->get('/profile', [UserApiController::class, 'profile']);
});

