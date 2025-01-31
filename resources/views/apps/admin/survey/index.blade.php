@extends('layouts.app')
@section('title', 'Master Survey')
@section('content')
    <div class="container-fluid">
        @include('components.ui-breadcrumb', ['breadcrumbTitle' => 'Master Survey', 'breadcrumbItems' => ['Home', 'Master Survey']])

        <div class="card position-relative dt-v">
            <div class="col-lg-4">
                <h5 class="card-title text-white">List Approval Survey</h5>
            </div>
            <div class="table-responsive m-3 rounded-1">
                <table id="datatable-survey" class="table table-striped text-nowrap align-middle">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Link</th> <!-- Updated -->
                        <th scope="col">Status Approve</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@vite('resources/js/survey.js')
