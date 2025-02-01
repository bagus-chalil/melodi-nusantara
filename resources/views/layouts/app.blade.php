
<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('/assets/images/logos/favicon.png') }}" />

    <title>@yield('title') - Melodi Nusantara </title>

    @include('layouts.components.styles')
    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>

<body>
<!-- Preloader -->
<div class="preloader">
    <img src="{{ asset('/assets/images/svgs/tube-spinner.svg') }}" alt="loader" class="lds-ripple img-fluid" />
</div>
<div id="main-wrapper">
    <!-- Sidebar Start -->
    <aside class="left-sidebar with-vertical d-print-none">
        <div><!-- ---------------------------------- -->
            <!-- Start Vertical Layout Sidebar -->
            <!-- ---------------------------------- -->
            <div class="brand-logo d-flex align-items-center justify-content-between">
                {{-- <a href="{{ url('/') }}" class="text-nowrap logo-img">
                    <img src="{{ asset('/assets/images/logos/dark-logo.png') }}" class="dark-logo" alt="Logo-Dark" width="150px" />
                    <img src="{{ asset('/assets/images/logos/light-logo.png') }}" class="light-logo" alt="Logo-light" width="150px" />
                </a>
                <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                    <i class="ti ti-x"></i>
                </a> --}}
                Melodi Nusantara
            </div>

            @include('layouts.components.sidebar')

            <div class="fixed-profile p-2 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
                <div class="hstack gap-3">
                    <div class="john-img">
                        <img src="{{ asset('/assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="40" height="40" alt="modernize-img" />
                    </div>
                    <div class="john-title">
                        <h6 class="mb-0 fs-2 fw-semibold">{{ Auth::user()->name }}</h6>
                        {{-- <span class="fs-2">{{ Auth::user()->roles()->first()->name }} {{ Auth::user()->entitas_code }}</span> --}}
                    </div>
                    <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ti ti-power fs-6"></i>
                    </button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>

            <!-- ---------------------------------- -->
            <!-- Start Vertical Layout Sidebar -->
            <!-- ---------------------------------- -->
        </div>
    </aside>
    <!--  Sidebar End -->
    <div class="page-wrapper">
        @include('layouts.components.topbar')

        <div class="body-wrapper">
            @yield('content')
        </div>
    </div>

</div>
@include('layouts.components.footer')

<div class="dark-transparent sidebartoggler"></div>

@include('components.modal-loading')

@include('layouts.components.scripts')

</body>

</html>
