
<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('/assets/images/logos/favicon.png') }}" />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('/assets/css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/css/custom.css') }}" />

    <title>@yield('title') - Melodi Nusantara </title>
</head>

<body>
<!-- Preloader -->
<div class="preloader">
    <img src="{{ asset('/assets/images/logos/favicon.png') }}" alt="loader" class="lds-ripple img-fluid" />
</div>
<div id="main-wrapper" class="auth-customizer-none">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100">
        <div class="position-relative z-index-5">
            <div class="row">
                @yield('content')
            </div>
        </div>
    </div>
</div>
<div class="dark-transparent sidebartoggler"></div>

<!-- Import Js Files -->
@include('layouts.components.scripts')

<!--Google Recaptcha -->
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptchav3.site_key') }}"></script>
@stack('js')

</body>

</html>
