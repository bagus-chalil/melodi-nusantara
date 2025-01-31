@extends('layouts.app')
@section('title', 'Survey Report')
@section('content')
    <div class="container-fluid">
        @include('components.ui-breadcrumb', ['breadcrumbTitle' => 'Survey Report', 'breadcrumbItems' => ['Home', 'Index']])

        <div class="card position-relative dt-v">
            <div class="col-lg-4">
                <h5 class="card-title text-white">List Report Survey</h5>
            </div>

            <div class="table-responsive m-3 rounded-1">
                <table id="datatable-report-survey" class="table table-striped text-nowrap align-middle">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Type Survey</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- model add data -->
    @include('apps.surveyor.survey-result.partials.modal-export-report')
@endsection

@vite('resources/js/survey-report/survey-report-index.js')
