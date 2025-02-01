@extends('layouts.app')
@section('title', 'Master Lagu')

@section('content')
<div class="container">
    <button class="btn btn-primary mb-3" id="addSongBtn">Tambah Lagu</button>
    <button class="btn btn-danger mb-3" id="deleteSelected">Hapus Terpilih</button>

    <table id="datatable-songs" class="table table-striped">
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAll"></th>
                <th>Thumbnail</th>
                <th>Judul</th>
                <th>Genre</th>
                <th>Region</th>
                <th>Audio</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>

@include('apps.admin.songs.modal')

@endsection

@vite('resources/js/admin/songs.js')
