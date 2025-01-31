@extends('layouts.app')
@section('title', 'Master Genres')

@section('content')
<div class="container">
    <button class="btn btn-primary mb-3" id="addSongBtn">Tambah Genre</button>
    <button class="btn btn-danger mb-3" id="deleteSelected">Hapus Terpilih</button>

    <table id="datatable-songs" class="table table-striped">
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAll"></th>
                <th>Title</th>
                <th>Artist</th>
                <th>Genre</th>
                <th>File</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>

@include('apps.admin.songs.modal')

@endsection

@vite('resources/js/admin/songs.js')
