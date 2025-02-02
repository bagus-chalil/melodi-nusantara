<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Playlist;
use App\Models\Songs;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class PlaylistApiController extends Controller
{
    /**
     * GET Semua Playlist User
     */
    public function index(Request $request)
    {
        try {
            $userId = $request->user_id;

            // Cek apakah user ada
            $user = User::find($userId);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User tidak ditemukan'
                ], 404);
            }

            $playlists = Playlist::where('user_id', $userId)
                ->orderBy('id')
                ->get()
                ->map(function ($playlist) {
                    return $this->formatPlaylistData($playlist);
                });

            return response()->json([
                'status' => 'success',
                'message' => 'Daftar playlist berhasil diambil',
                'data' => $playlists
            ], 200);
        } catch (Exception $e) {
            return $this->serverErrorResponse('Gagal mengambil playlist', $e);
        }
    }

    /**
     * CREATE / UPDATE Playlist dengan Menambahkan Lagu Satu Per Satu
     */
    public function addSongToPlaylist(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'name' => 'required|string|max:255',
                'song_id' => 'required|exists:songs,id',
            ]);

            $userId = $request->user_id;
            $songId = $request->song_id;

            // Cek apakah playlist sudah ada untuk user ini
            $playlist = Playlist::where('user_id', $userId)
                ->where('name', $request->name)
                ->first();

            if ($playlist) {
                // Decode song_id menjadi array, jika null, set ke array kosong []
                $songArray = json_decode($playlist->song_id, true) ?? [];

                // Tambahkan lagu hanya jika belum ada dalam playlist
                if (!in_array($songId, $songArray)) {
                    $songArray[] = $songId;
                    $playlist->update(['song_id' => json_encode($songArray)]);
                }
            } else {
                // Jika belum ada, buat playlist baru
                $playlist = Playlist::create([
                    'name' => $request->name,
                    'description' => $request->description ?? '',
                    'user_id' => $userId,
                    'song_id' => json_encode([$songId]),
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Lagu berhasil ditambahkan ke playlist',
                'data' => $this->formatPlaylistData($playlist)
            ], 200);
        } catch (Exception $e) {
            return $this->serverErrorResponse('Gagal menambahkan lagu ke playlist', $e);
        }
    }


    /**
     * GET Detail Playlist
     */
    /**
     * GET Detail Playlist dengan Next & Previous
     */
    public function show(Request $request, $id)
    {
        try {
            $playlist = Playlist::where('id', $id)
                ->where('user_id', $request->user_id)
                ->firstOrFail();

            $songIds = json_decode($playlist->song_id, true) ?? [];

            if (empty($songIds)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Playlist kosong',
                    'data' => []
                ], 404);
            }

            $songs = Songs::whereIn('id', $songIds)->get();

            $formattedSongs = collect($songIds)->map(function ($songId) use ($songs) {
                $song = $songs->where('id', $songId)->first();
                return $song ? [
                    'id' => $song->id,
                    'title' => $song->title,
                    'file_url' => asset('storage/' . $song->file_path)
                ] : null;
            })->filter()->values();

            return response()->json([
                'status' => 'success',
                'message' => 'Detail playlist ditemukan',
                'data' => [
                    'id' => $playlist->id,
                    'name' => $playlist->name,
                    'description' => $playlist->description,
                    'user_id' => $playlist->user_id,
                    'songs' => $formattedSongs
                ]
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Playlist tidak ditemukan',
                'error' => 'Data tidak ditemukan'
            ], 404);
        } catch (Exception $e) {
            return $this->serverErrorResponse('Terjadi kesalahan saat mengambil detail playlist', $e);
        }
    }

    /**
     * GET Next & Previous Song dari Playlist
     */
    public function getNextPrevSong(Request $request, $playlistId, $songId)
    {
        try {
            $playlist = Playlist::where('id', $playlistId)
                ->where('user_id', $request->user_id)
                ->firstOrFail();

            $songIds = json_decode($playlist->song_id, true) ?? [];
            $currentIndex = array_search($songId, $songIds);

            if ($currentIndex === false) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Lagu tidak ditemukan dalam playlist'
                ], 404);
            }

            $nextSongId = $songIds[$currentIndex + 1] ?? null;
            $prevSongId = $songIds[$currentIndex - 1] ?? null;

            $nextSong = $nextSongId ? Songs::find($nextSongId) : null;
            $prevSong = $prevSongId ? Songs::find($prevSongId) : null;

            return response()->json([
                'status' => 'success',
                'message' => 'Next & Previous Lagu ditemukan',
                'data' => [
                    'current_song' => Songs::find($songId),
                    'next_song' => $nextSong ? [
                        'id' => $nextSong->id,
                        'title' => $nextSong->title,
                        'file_url' => asset('storage/' . $nextSong->file_path)
                    ] : null,
                    'prev_song' => $prevSong ? [
                        'id' => $prevSong->id,
                        'title' => $prevSong->title,
                        'file_url' => asset('storage/' . $prevSong->file_path)
                    ] : null
                ]
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Playlist tidak ditemukan atau user tidak memiliki akses',
                'error' => 'Data tidak ditemukan'
            ], 404);
        } catch (Exception $e) {
            return $this->serverErrorResponse('Terjadi kesalahan saat mengambil Next & Previous lagu', $e);
        }
    }

    /**
     * DELETE Playlist
     */
    public function destroy(Request $request, $id)
    {
        try {
            $playlist = Playlist::where('id', $id)
                ->where('user_id', $request->user_id)
                ->firstOrFail();

            $playlist->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Playlist berhasil dihapus'
            ], 200);
        } catch (Exception $e) {
            return $this->serverErrorResponse('Gagal menghapus playlist', $e);
        }
    }

    /**
     * Format Data Playlist
     */
    private function formatPlaylistData($playlist)
    {
        $songIds = json_decode($playlist->song_id, true) ?? [];

        $songs = Songs::whereIn('id', $songIds)->get();

        return [
            'id' => $playlist->id,
            'name' => $playlist->name,
            'description' => $playlist->description,
            'user_id' => $playlist->user_id,
            'songs' => $songs->map(function ($song) {
                return [
                    'id' => $song->id,
                    'title' => $song->title,
                    'file_url' => asset('storage/' . $song->file_path)
                ];
            })
        ];
    }

    public function removeSongFromPlaylist(Request $request, $playlistId, $songId)
    {
        try {
            // Cek apakah playlist ada dan dimiliki oleh user_id
            $playlist = Playlist::where('id', $playlistId)
                ->where('user_id', $request->user_id)
                ->firstOrFail();

            // Ambil daftar lagu dalam playlist (decode dari JSON)
            $songArray = json_decode($playlist->song_id, true) ?? [];

            // Cek apakah lagu ada di dalam playlist
            if (!in_array($songId, $songArray)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Lagu tidak ditemukan dalam playlist'
                ], 404);
            }

            // Hapus lagu dari array
            $updatedSongs = array_values(array_diff($songArray, [$songId]));

            // Jika playlist kosong setelah penghapusan, hapus playlist
            if (empty($updatedSongs)) {
                $playlist->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Playlist dihapus karena tidak ada lagu tersisa'
                ], 200);
            }

            // Simpan perubahan pada playlist
            $playlist->update(['song_id' => json_encode($updatedSongs)]);

            return response()->json([
                'status' => 'success',
                'message' => 'Lagu berhasil dihapus dari playlist',
                'data' => $this->formatPlaylistData($playlist)
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Playlist tidak ditemukan atau user tidak memiliki akses',
                'error' => 'Data tidak ditemukan'
            ], 404);
        } catch (Exception $e) {
            return $this->serverErrorResponse('Terjadi kesalahan saat menghapus lagu dari playlist', $e);
        }
    }


    /**
     * Server Error Response
     */
    private function serverErrorResponse($message, $exception)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'error' => $exception->getMessage()
        ], 500);
    }
}
