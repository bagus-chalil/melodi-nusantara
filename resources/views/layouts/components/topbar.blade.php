<!--  Header Start -->
<header class="topbar border d-print-none">
    <div class="with-vertical"><!-- ---------------------------------- -->
        <!-- Start Vertical Layout Header -->
        <!-- ---------------------------------- -->
        <nav class="navbar navbar-expand-lg p-0 d-print-none">

            <!-- Start Layout Navbar -->
            @include('layouts.components.navbar')
            <!-- End Layout Navbar -->

            <div class="d-block d-lg-none py-4">
                <a href="{{ url('/') }}" class="text-nowrap logo-img">
                    <img src="{{ asset('/assets/images/logos/dark-logo.svg') }}" class="dark-logo" alt="Logo-Dark" style="height:40px"/>
                    <img src="{{ asset('/assets/images/logos/light-logo.svg') }}" class="light-logo" alt="Logo-light" style="height:40px"/>
                </a>
            </div>
            <a class="navbar-toggler nav-icon-hover-bg rounded-circle p-0 mx-0 border-0" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ti ti-dots fs-7 d-print-none"></i>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="javascript:void(0)" class="nav-link nav-icon-hover-bg rounded-circle mx-0 ms-n1 d-flex d-lg-none align-items-center justify-content-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar" aria-controls="offcanvasWithBothOptions">
                        <i class="ti ti-align-justified fs-7"></i>
                    </a>
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                        <!-- ------------------------------- -->
                        <!-- start dark mode -->
                        <!-- ------------------------------- -->
                        <li class="nav-item nav-icon-hover-bg rounded-circle">
                            <a class="nav-link moon dark-layout" href="javascript:void(0)">
                                <i class="ti ti-moon moon"></i>
                            </a>
                            <a class="nav-link sun light-layout" href="javascript:void(0)">
                                <i class="ti ti-sun sun"></i>
                            </a>
                        </li>

                        <!-- ------------------------------- -->
                        <!-- start notification Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item nav-icon-hover-bg rounded-circle dropdown">
                            <a class="nav-link position-relative" href="javascript:void(0)" id="drop2" aria-expanded="false">
                                <i class="ti ti-bell-ringing"></i>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                <div class="d-flex align-items-center justify-content-between py-3 px-7">
                                    <h5 class="mb-0 fs-5 fw-semibold">Notifications</h5>
                                    <span class="badge text-bg-primary rounded-4 px-3 py-1 lh-sm">0 new</span>
                                </div>
                                <div class="py-6 px-7 mb-1">
                                    <button class="btn btn-outline-primary w-100">Empty Notifications</button>
                                </div>
                            </div>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end notification Dropdown -->
                        <!-- ------------------------------- -->

                        <!-- ------------------------------- -->
                        <!-- start profile Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item dropdown">
                            <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div class="user-profile-img">
                                        <img src="{{ asset('/assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="35" height="35" alt="modernize-img" />
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                                <div class="profile-dropdown position-relative" data-simplebar>
                                    <div class="py-3 px-7 pb-0">
                                        <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
                                    </div>
                                    <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                        <img src="{{ asset('/assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="80" height="80" alt="modernize-img" />
                                        <div class="ms-3">
                                            <h5 class="mb-1 fs-3">{{ Auth::user()->name }}</h5>
                                            <span class="mb-1 d-block"><i class="ti ti-briefcase"></i> {{ Auth::user()->job_title }}</span>
                                            {{-- <span class="mb-1 d-block"><i class="ti ti-user-check"></i>  {{ Auth::user()->roles()->first()->name }} (<i class="ti ti-building"></i>  {{ Auth::user()->entitas_code }})</span> --}}
                                        </div>
                                    </div>
                                    <div class="message-body">
                                        <a href="{{ url('activity-log') }}" class="py-8 px-7 mt-8 d-flex align-items-center">
                                                <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                  <img src="{{ asset('assets/images/svgs/icon-tasks.svg') }}" alt="modernize-img" width="24" height="24" />
                                                </span>
                                            <div class="w-100 ps-3">
                                                <h6 class="mb-1 fs-3 fw-semibold lh-base">Log Activity</h6>
                                                <span class="fs-2 d-block text-body-secondary">List All Log Activity</span>
                                            </div>
                                        </a>
                                        <a href="{{ url('users-edit-password') }}" class="py-8 px-7 mt-8 d-flex align-items-center">
                                                <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                  <img src="{{ asset('assets/images/svgs/icon-account.svg') }}" alt="modernize-img" width="24" height="24" />
                                                </span>
                                            <div class="w-100 ps-3">
                                                <h6 class="mb-1 fs-3 fw-semibold lh-base">Password</h6>
                                                <span class="fs-2 d-block text-body-secondary">Update Your Password</span>
                                            </div>
                                        </a>
                                        <a href="{{ url('faqs-page') }}" class="py-8 px-7 mt-8 d-flex align-items-center">
                                                <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                  <img src="{{ asset('assets/images/svgs/icon-dd-lifebuoy.svg') }}" alt="modernize-img" width="24" height="24" />
                                                </span>
                                            <div class="w-100 ps-3">
                                                <h6 class="mb-1 fs-3 fw-semibold lh-base">FAQ's</h6>
                                                <span class="fs-2 d-block text-body-secondary">List FAQ's for User</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="d-grid py-4 px-7 pt-8">
                                        <a href="#!" class="btn btn-outline-primary" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end profile Dropdown -->
                        <!-- ------------------------------- -->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- ---------------------------------- -->
        <!-- End Vertical Layout Header -->
        <!-- ---------------------------------- -->
    </div>
</header>
<!--  Header End -->
