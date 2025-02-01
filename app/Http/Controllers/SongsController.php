<?php

namespace App\Http\Controllers;

use App\Models\Genres;
use App\Models\Songs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SongsController extends Controller {
    public function index(Request $request) {
        if ($request->ajax()) {
            $songs = Songs::select(['id', 'title', 'category', 'region', 'file_path', 'thumbnail']);

            return DataTables::of($songs)
                ->addColumn('checkbox', function ($song) {
                    return '<input type="checkbox" class="song-checkbox" value="' . $song->id . '">';
                })
                ->addColumn('thumbnail', function ($song) {
                    return '<img src="' . $song->thumbnail_url . '" width="50">';
                })
                ->addColumn('file_preview', function ($song) {
                    return $song->file_path ? '<audio controls><source src="' . $song->file_url . '" type="audio/mpeg"></audio>' : '-';
                })
                ->addColumn('actions', function ($song) {
                    return '
                        <button class="btn btn-sm btn-warning edit-song" data-id="' . $song->id . '">Edit</button>
                        <button class="btn btn-sm btn-danger delete-song" data-id="' . $song->id . '">Hapus</button>
                    ';
                })
                ->rawColumns(['checkbox', 'thumbnail', 'file_preview', 'actions'])
                ->make(true);
        }

        return view('apps.admin.songs.index');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|mimes:mp3,wav|max:10240',
            'lyrics' => 'required|mimes:txt,pdf,docx,doc|max:2048',
            'thumbnail' => 'required|image|mimes:jpg,png,webp|max:2048',
            'region' => 'required|string|max:100',
            'category' => 'required|in:daerah,nasional',
            'source' => 'nullable|url',
        ]);

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('songs', 'public');
        }
        if ($request->hasFile('lyrics')) {
            $validated['lyrics'] = $request->file('lyrics')->store('lyrics', 'public');
        }
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Songs::create($validated);
        return response()->json(['success' => 'Lagu berhasil ditambahkan']);
    }

    public function edit($id) {
        $song = Songs::findOrFail($id);

        return response()->json([
            'id' => $song->id,
            'title' => $song->title,
            'description' => $song->description,
            'category' => $song->category,
            'region' => $song->region,
            'source' => $song->source,
            'file_url' => $song->file_path ? asset('storage/' . $song->file_path) : null,
            'lyrics_url' => $song->lyrics ? asset('storage/' . $song->lyrics) : null,
            'thumbnail_url' => $song->thumbnail ? asset('storage/' . $song->thumbnail) : asset('default-thumbnail.jpg')
        ]);
    }

    public function update(Request $request, $id) {
        $song = Songs::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|mimes:mp3,wav|max:10240',
            'lyrics' => 'required|mimes:txt,pdf,docx,doc|max:2048',
            'thumbnail' => 'required|image|mimes:jpg,png,webp|max:2048',
            'region' => 'required|string|max:100',
            'category' => 'required|in:daerah,nasional',
            'source' => 'nullable|url',
        ]);

        // Jika ada file baru, hapus file lama lalu simpan yang baru
        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($song->file_path);
            $validated['file_path'] = $request->file('file')->store('songs', 'public');
        }

        if ($request->hasFile('lyrics')) {
            Storage::disk('public')->delete($song->lyrics);
            $validated['lyrics'] = $request->file('lyrics')->store('lyrics', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            Storage::disk('public')->delete($song->thumbnail);
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $song->update($validated);
        return response()->json(['success' => 'Lagu berhasil diperbarui']);
    }


    public function destroy($id) {
        $song = Songs::findOrFail($id);

        // Hanya hapus file jika ada di storage
        if ($song->file_path && Storage::disk('public')->exists($song->file_path)) {
            Storage::disk('public')->delete($song->file_path);
        }
        if ($song->lyrics && Storage::disk('public')->exists($song->lyrics)) {
            Storage::disk('public')->delete($song->lyrics);
        }
        if ($song->thumbnail && Storage::disk('public')->exists($song->thumbnail)) {
            Storage::disk('public')->delete($song->thumbnail);
        }

        $song->delete();
        return response()->json(['success' => 'Lagu berhasil dihapus']);
    }

    public function batchDelete(Request $request) {
        $ids = $request->validate(['ids' => 'required|array|min:1'])['ids'];
        $songs = Songs::whereIn('id', $ids)->get();

        foreach ($songs as $song) {
            Storage::disk('public')->delete([$song->file_path, $song->lyrics, $song->thumbnail]);
            $song->delete();
        }

        return response()->json(['success' => 'Beberapa lagu berhasil dihapus']);
    }
}
