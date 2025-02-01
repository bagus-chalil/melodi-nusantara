<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Songs;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class SongApiController extends Controller
{
    /**
     * GET Semua Lagu (Public)
     */
    public function index()
    {
        try {
            $songs = Songs::select('id', 'title', 'description', 'category', 'region', 'source', 'file_path', 'lyrics', 'thumbnail')
                ->get()
                ->map(function ($song) {
                    return [
                        'id' => $song->id,
                        'title' => $song->title,
                        'description' => $song->description,
                        'category' => $song->category,
                        'region' => $song->region,
                        'source' => $song->source,
                        'file_url' => $song->file_path ? asset('storage/' . $song->file_path) : null,
                        'lyrics_url' => $song->lyrics ? asset('storage/' . $song->lyrics) : null,
                        'thumbnail_url' => $song->thumbnail ? asset('storage/' . $song->thumbnail) : asset('default-thumbnail.jpg'),
                    ];
                });

            return response()->json([
                'status' => 'success',
                'message' => 'Lagu berhasil diambil',
                'data' => $songs
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil lagu',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * SEARCH Lagu berdasarkan Judul, Kategori, atau Region
     */
    public function search(Request $request)
    {
        try {
            $query = Songs::query();

            if ($request->has('title')) {
                $query->where('title', 'LIKE', '%' . $request->title . '%');
            }
            if ($request->has('category')) {
                $query->where('category', $request->category);
            }
            if ($request->has('region')) {
                $query->where('region', 'LIKE', '%' . $request->region . '%');
            }

            $songs = $query->select('id', 'title', 'description', 'category', 'region', 'source', 'file_path', 'lyrics', 'thumbnail')
                ->get()
                ->map(function ($song) {
                    return [
                        'id' => $song->id,
                        'title' => $song->title,
                        'description' => $song->description,
                        'category' => $song->category,
                        'region' => $song->region,
                        'source' => $song->source,
                        'file_url' => $song->file_path ? asset('storage/' . $song->file_path) : null,
                        'lyrics_url' => $song->lyrics ? asset('storage/' . $song->lyrics) : null,
                        'thumbnail_url' => $song->thumbnail ? asset('storage/' . $song->thumbnail) : asset('default-thumbnail.jpg'),
                    ];
                });

            if ($songs->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Lagu tidak ditemukan',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Pencarian berhasil',
                'data' => $songs
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mencari lagu',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET Detail Lagu berdasarkan ID
     */
    public function show($id)
    {
        try {
            $song = Songs::select('id', 'title', 'description', 'category', 'region', 'source', 'file_path', 'lyrics', 'thumbnail')
                ->where('id', $id)
                ->firstOrFail();

            return response()->json([
                'status' => 'success',
                'message' => 'Detail lagu ditemukan',
                'data' => [
                    'id' => $song->id,
                    'title' => $song->title,
                    'description' => $song->description,
                    'category' => $song->category,
                    'region' => $song->region,
                    'source' => $song->source,
                    'file_url' => $song->file_path ? asset('storage/' . $song->file_path) : null,
                    'lyrics_url' => $song->lyrics ? asset('storage/' . $song->lyrics) : null,
                    'thumbnail_url' => $song->thumbnail ? asset('storage/' . $song->thumbnail) : asset('default-thumbnail.jpg'),
                ]
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lagu tidak ditemukan',
                'error' => 'Data tidak ditemukan'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail lagu',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
