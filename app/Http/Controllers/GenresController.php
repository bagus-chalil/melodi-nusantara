<?php

namespace App\Http\Controllers;

use App\Models\Genres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class GenresController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $genres = Genres::select(['id', 'name', 'cover_image']);

            return DataTables::of($genres)
                ->addColumn('cover_image', function ($genre) {
                    return '<img src="' . asset('storage/' . $genre->cover_image) . '" width="50">';
                })
                ->addColumn('checkbox', function ($genre) {
                    return '<input type="checkbox" class="genre-checkbox" value="' . $genre->id . '">';
                })
                ->addColumn('actions', function ($genre) {
                    return '
                        <button class="btn btn-sm btn-warning edit-genre" data-id="' . $genre->id . '">Edit</button>
                        <button class="btn btn-sm btn-danger delete-genre" data-id="' . $genre->id . '">Hapus</button>
                    ';
                })
                ->rawColumns(['cover_image', 'checkbox', 'actions'])
                ->make(true);
        }
        return view('apps.admin.genres.index');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:genres',
            'cover_image' => 'required|image|mimes:jpg,png,webp|max:2048',
        ]);

        $image_path = $request->file('cover_image')->store('genres', 'public');

        Genres::create([
            'name' => $request->name,
            'cover_image' => $image_path,
        ]);

        return response()->json(['success' => 'Genres berhasil ditambahkan']);
    }

    public function edit($id) {
        $genre = Genres::findOrFail($id);
        return response()->json($genre);
    }

    public function update(Request $request, $id) {
        $genre = Genres::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:genres,name,' . $id,
            'cover_image' => 'nullable|image|mimes:jpg,png,webp|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            Storage::delete('public/' . $genre->cover_image);
            $image_path = $request->file('cover_image')->store('genres', 'public');
            $genre->cover_image = $image_path;
        }

        $genre->update([
            'name' => $request->name,
            'cover_image' => $genre->cover_image,
        ]);

        return response()->json(['success' => 'Genres berhasil diperbarui']);
    }

    public function destroy($id) {
        $genre = Genres::findOrFail($id);
        Storage::delete('public/' . $genre->cover_image);
        $genre->delete();

        return response()->json(['success' => 'Genre berhasil dihapus']);
    }

    public function batchDelete(Request $request) {
        $ids = $request->ids;

        if (empty($ids)) {
            return response()->json(['error' => 'Tidak ada genre yang dipilih!'], 400);
        }

        $genres = Genres::whereIn('id', $ids)->get();

        if ($genres->isEmpty()) {
            return response()->json(['error' => 'Genre tidak ditemukan!'], 404);
        }

        foreach ($genres as $genre) {
            Storage::delete('public/' . $genre->cover_image);
            $genre->delete();
        }

        return response()->json(['success' => 'Beberapa genre berhasil dihapus']);
    }

}
