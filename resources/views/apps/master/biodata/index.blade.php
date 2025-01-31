@extends('layouts.app')
@section('title', 'Master Biodata')
@section('content')
    <div class="container-fluid">
        @include('components.ui-breadcrumb', ['breadcrumbTitle' => 'Master Biodata', 'breadcrumbItems' => ['Home', 'Master Master Biodata']])

        <div class="card position-relative dt-v">
            <div class="col-lg-4">
                <h5 class="card-title text-white">List Biodata</h5>
            </div>
            <div class="col-lg-8 d-flex justify-content-end">
                <div class="form-check mx-2  float-end">
                    <input class="form-check-input mt-2" type="checkbox" id="selectAll" />
                    <label class="form-check-label" for="selectAll">
                      Select All
                    </label>
                    <button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger">Delete</button>
                </div>
                <button id="btnShowModalAddBiodata" class="btn btn-primary add-new btn-white ms-2 ms-sm-0 waves-effect waves-light" type="button">
                    <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Add Data</span></span>
                </button>
            </div>
            <div class="table-responsive m-3 rounded-1">
                <table id="datatable-biodata" class="table table-striped text-nowrap align-middle">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Answer</th>
                        <th scope="col">Status</th>
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
    @include('apps.master.biodata.partials.modal-add')
    @include('apps.master.biodata.partials.modal-edit')
@endsection

@vite('resources/js/master-data/biodata.js',)
