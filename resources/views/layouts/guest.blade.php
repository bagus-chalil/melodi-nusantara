
<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="{{asset('/assets/images/logos/favicon.png')}}" />

  <!-- Core Css -->
  <link rel="stylesheet" href="https://bootstrapdemos.adminmart.com/modernize/dist/assets/css/styles.css" />

  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('/assets/libs/select2/dist/css/select2.min.css') }}">

  <!-- Fontawesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- @vite(['resource/scss/app.css']) --}}
  <title>@yield('title') - Web I-Survey-KF</title>
</head>

<body>


  <!-- Preloader -->
  <div class="preloader">
    <img src="{{asset('assets/images/logos/favicon.png')}}" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <!-- ------------------------------------- -->
  <!-- Top Bar Start -->
  <!-- ------------------------------------- -->
  {{-- <div class="topbar-image bg-primary py-1 rounded-0 mb-0 alert alert-dismissible fade show" role="alert">
    <div class="d-flex justify-content-center gap-sm-3 gap-2 align-items-center text-center flex-md-nowrap flex-wrap">
      <span class="badge bg-white bg-opacity-10 fs-2 fw-bolder px-2">New</span>
      <p class="mb-0 text-white fw-bold">{{$data['surveyAll']->name ?? 'Survey Kimia Farma'}}!</p>
    </div>
    <button type="button" class="btn-close btn-close-white p-2 fs-2" data-bs-dismiss="alert" aria-label="Close"></button>
  </div> --}}
  <!-- ------------------------------------- -->
  <!-- Top Bar End -->
  <!-- ------------------------------------- -->

  {{-- @include('layouts.components.topbar-vertical') --}}

  {{-- @include('layouts.components.navbar-vertical') --}}

  <div class="main-wrapper overflow-hidden">
    <!-- ------------------------------------- -->
    <!-- Form Start -->
    <!-- ------------------------------------- -->
    <section class="py-lg-12 py-md-14 py-5" style="background-color: #F6F4F0">
      <div class="container-fluid" style="width: 50%">
        @yield('content')
      </div>
    </section>
    <!-- ------------------------------------- -->
    <!-- Form End -->
    <!-- ------------------------------------- -->

    <!-- ------------------------------------- -->
    <!-- Develop Start -->
    <!-- ------------------------------------- -->
    {{-- <section class="mb-5 mb-md-14 mb-lg-12">
      <div class="custom-container">
        <div class="bg-primary-subtle rounded-3 position-relative overflow-hidden">
          <div class="row">
            <div class="col-lg-6">
              <div class="py-lg-12 ps-lg-12 py-5 px-lg-0 px-9">
                <h2 class="fs-10 fw-bolder text-lg-start text-center">
                  Develop with feature-rich Bootstrap Dashboard
                </h2>
                <div class="d-flex justify-content-lg-start justify-content-center gap-3 my-4 flex-sm-nowrap flex-wrap">
                  <a href="../main/authentication-login.html" class="btn btn-primary py-6 px-9">Member Login</a>
                  <a href="../main/authentication-register.html" class="btn btn-outline-primary py-6 px-9">Register as Member</a>
                </div>
                <p class="fs-3 text-lg-start text-center mb-0">
                  <span class="fw-bolder">One-time purchase</span> - no recurring fees.
                </p>
              </div>
            </div>
            <div class="col-lg-6 d-lg-block d-none">
              <img src="{{asset('/assets/images/frontend-pages/design-collection.png')}}" alt="banner" class="position-absolute develop-feature-rich">
            </div>
          </div>
        </div>
      </div>
    </section> --}}
    <!-- ------------------------------------- -->
    <!-- Develop End -->
    <!-- ------------------------------------- -->
  </div>

  @include('layouts.components.footer-vertical')

  <!-- Scroll Top -->
  <a href="javascript:void(0)" class="top-btn btn btn-primary d-flex align-items-center justify-content-center round-54 p-0 rounded-circle">
    <i class="fa-solid fa-up-long"></i>
  </a>
</body>
@include('layouts.components.scripts-vertical')
</html>
