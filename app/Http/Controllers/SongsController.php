<?php

namespace App\Http\Controllers;

use App\Models\Genres;
use App\Models\Songs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SongsController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $songs = Songs::with('genre')->select(['id', 'title', 'artist', 'genre_id', 'file_path', 'description', 'lyrics', 'region']);
            return DataTables::of($songs)
                ->addColumn('checkbox', function ($song) {
                    return '<input type="checkbox" class="song-checkbox" value="' . $song->id . '">';
                })
                ->addColumn('genre', function ($song) {
                    return $song->genre->name ?? '-';
                })
                ->addColumn('file_preview', function ($song) {
                    return '<audio controls class="w-100"><source src="' . Storage::url($song->file_path) . '" type="audio/mpeg"></audio>';
                })
                ->addColumn('actions', function ($song) {
                    return '
                        <button class="btn btn-sm btn-warning edit-song" data-id="' . $song->id . '">Edit</button>
                        <button class="btn btn-sm btn-danger delete-song" data-id="' . $song->id . '">Hapus</button>
                    ';
                })
                ->rawColumns(['checkbox', 'file_preview', 'actions'])
                ->make(true);
        }

        $genres = Genres::all();
        return view('apps.admin.songs.index', compact('genres'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,id',
            'description' => 'nullable|string',
            'lyrics' => 'nullable|string',
            'region' => 'nullable|string|max:100',
            'file' => 'required|mimes:mp3,wav|max:10240',
        ]);

        $filePath = $request->file('file')->store('songs', 'public');

        Songs::create($validated + ['file_path' => $filePath]);

        return response()->json(['success' => 'Song created successfully']);
    }

    public function edit(Songs $song) {
        return response()->json($song);
    }

    public function update(Request $request, Songs $song) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,id',
            'description' => 'nullable|string',
            'lyrics' => 'nullable|string',
            'region' => 'nullable|string|max:100',
            'file' => 'nullable|mimes:mp3,wav|max:10240',
        ]);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($song->file_path);
            $validated['file_path'] = $request->file('file')->store('songs', 'public');
        }

        $song->update($validated);

        return response()->json(['success' => 'Song updated successfully']);
    }

    public function destroy(Songs $song) {
        Storage::disk('public')->delete($song->file_path);
        $song->delete();
        return response()->json(['success' => 'Song deleted successfully']);
    }

    public function batchDelete(Request $request) {
        $request->validate(['ids' => 'required|array|min:1']);

        $songs = Songs::whereIn('id', $request->ids)->get();
        foreach ($songs as $song) {
            Storage::disk('public')->delete($song->file_path);
            $song->delete();
        }

        return response()->json(['success' => 'Selected songs deleted successfully']);
    }
}
