@extends('layouts.app')
@section('title', 'Survey Result')
@section('content')
<div class="container-fluid">
    @include('components.ui-breadcrumb', ['breadcrumbTitle' => 'Survey Result', 'breadcrumbItems' => ['Home', 'Survey Result']])

    <div class="card position-relative dt-v">
        <div class="card-header bg-primary d-flex justify-content-between align-items-center">
            <h5 class="card-title text-white">List Survey Result</h5>
        </div>

        <div class="table-responsive m-3 rounded-1">
            <div class="d-flex m-2 mb-4">
                <!-- Search Bar -->
                <select name="division" id="division" class="form-control me-2">
                    <option value="999">Semua</option>
                    @foreach ($data['allDivision'] as $division)
                        <option value="{{$division->id}}" {{ request('division') == $division->id ? 'selected' : '' }}>{{$division->name}}</option>
                    @endforeach
                </select>

                <!-- Sort Dropdown -->
                <select id="sort" name="sort" class="form-select me-2">
                    <option value="id" {{ request('sort') == 'id' ? 'selected' : '' }}>ID</option>
                    <option value="data" {{ request('sort') == 'data' ? 'selected' : '' }}>Data</option>
                </select>

                <!-- Sort Direction -->
                <select id="direction" name="direction" class="form-select me-2">
                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>

                <!-- Pagination Dropdown -->
                <select id="per_page" name="per_page" class="form-select me-2">
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    <option value="1000" {{ request('per_page') == 1000 ? 'selected' : '' }}>1000</option>
                </select>

                <button id="filterButton" class="btn btn-primary">Filter</button>
            </div>
            <h2 class="text-center"></h2>
            @include('apps.surveyor.survey-result.partials.table-survey-report')
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $data['surveys']->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</div>

@vite('resources/js/survey-result.js')

@endsection
