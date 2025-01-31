@extends('layouts.app')
@section('title', 'Master Genres')

@section('content')
<div class="container">
    <button class="btn btn-primary mb-3" id="addGenreBtn">Tambah Genre</button>
    <button class="btn btn-danger mb-3" id="deleteSelected">Hapus Terpilih</button>

    <table id="datatable-genres" class="table table-striped">
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAll"></th>
                <th>Nama</th>
                <th>Cover</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>

@include('apps.admin.genres.modal')

@endsection

@vite('resources/js/admin/genres.js')
