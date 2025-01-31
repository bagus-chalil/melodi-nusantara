@extends('layouts.app')
@section('title', 'Master Survey')
@section('content')
    <div class="container-fluid">
        @include('components.ui-breadcrumb', ['breadcrumbTitle' => 'Master Survey', 'breadcrumbItems' => ['Home', 'Master Survey']])

        <div class="card position-relative dt-v">
            <div class="col-lg-4">
                <h5 class="card-title text-white">List Survey</h5>
            </div>
            <div class="col-lg-8 d-flex justify-content-end">
                <div class="form-check mx-2  float-end">
                    <input class="form-check-input mt-2" type="checkbox" id="selectAll" />
                    <label class="form-check-label" for="selectAll">
                      Select All
                    </label>
                    <button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger">Delete</button>
                </div>
                <button id="btnShowModalAddSurvey" class="btn btn-primary add-new btn-white ms-2 ms-sm-0 waves-effect waves-light" type="button">
                    <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Add Data</span></span>
                </button>
            </div>
            <div class="table-responsive m-3 rounded-1">
                <table id="datatable-survey" class="table table-striped text-nowrap align-middle">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Quota</th>
                        <th scope="col">Total Responden</th>
                        <th scope="col">Link</th>
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

    <!-- model add data -->
    @include('apps.surveyor.survey.partials.modal-add')
    @include('apps.surveyor.survey.partials.modal-edit')
@endsection

@vite('resources/js/survey.js')
