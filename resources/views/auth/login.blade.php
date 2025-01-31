@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="col-xl-5 col-xxl-4">
        <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
            <div class="auth-max-width col-sm-8 col-md-6 col-xl-7 px-4">
                <h2 class="mb-1 fs-7 fw-bolder">Welcome to I-SURVEY-KF</h2>
                <p class="mb-7">Operated by <b>PT. Kimia Farma Tbk.</b></p>
                <!-- Validation Errors -->
                @if ($errors->any())
                    <!-- Primary Alert -->
                    <div class="alert alert-danger text-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        @foreach ($errors->all() as $error)
                            <strong>Failed </strong> {{ $error }}
                        @endforeach
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" aria-describedby="emailHelp" placeholder="Email" required>
                    </div>
                    <div class="mb-4">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check">
                            <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                            <label class="form-check-label text-dark fs-3" for="flexCheckChecked">
                                Remeber this Device
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Sign In</button>
                </form>
            </div>
        </div>
    </div>
@stop
