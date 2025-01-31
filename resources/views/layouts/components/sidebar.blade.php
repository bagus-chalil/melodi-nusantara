<nav class="sidebar-nav scroll-sidebar" data-simplebar>
    <ul id="sidebarnav">
        <!-- ---------------------------------- -->
        <!-- Apps -->
        <!-- ---------------------------------- -->
        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Apps</span>
        </li>
        <!-- ---------------------------------- -->
        <!-- Home -->
        <!-- ---------------------------------- -->
        <li class="sidebar-item">
            <a class="sidebar-link" href="/" aria-expanded="false">
                <span>
                    <i class="fa-solid fa-house"></i>
                </span>
                <span class="hide-menu">Home</span>
            </a>
        </li>

        <!-- ---------------------------------- -->
        <!-- Analytics -->
        <!-- ---------------------------------- -->
        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Analytics</span>
        </li>

        <!-- ---------------------------------- -->
        <!-- Dashboard -->
        <!-- ---------------------------------- -->
        <li class="sidebar-item">
            <a class="sidebar-link justify-content-between" href="{{ url('dashboard') }}" aria-expanded="false">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex">
                    <i class="fa-solid fa-chart-line"></i>
                  </span>
                    <span class="hide-menu">Dashboard</span>
                </div>
            </a>
        </li>

        <!-- ---------------------------------- -->
        <!-- Survey -->
        <!-- ---------------------------------- -->
        @role('Super Admin|Admin')
        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Survey</span>
        </li>
        @endrole

        <!-- ---------------------------------- -->
        <!-- Create Form -->
        <!-- ---------------------------------- -->
        @role('Super Admin')
        <li class="sidebar-item">
            <a class="sidebar-link justify-content-between" href="{{ url('survey') }}" aria-expanded="false">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex">
                    <i class="fa-solid fa-clipboard-list"></i>
                  </span>
                    <span class="hide-menu">Create Form</span>
                </div>
            </a>
        </li>
        @endrole

        <!-- ---------------------------------- -->
        <!-- Approval -->
        <!-- ---------------------------------- -->
        @role('Super Admin|Admin')
        <li class="sidebar-item">
            <a class="sidebar-link justify-content-between" href="{{ url('survey/approval') }}" aria-expanded="false">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex">
                    <i class="fa-solid fa-list-check"></i>
                  </span>
                    <span class="hide-menu">Approval</span>
                </div>
            </a>
        </li>
        @endrole

        <!-- ---------------------------------- -->
        <!-- Survey Report -->
        <!-- ---------------------------------- -->
        @role('Super Admin')
        <li class="sidebar-item">
            <a class="sidebar-link justify-content-between" href="{{ url('survey-report/list') }}" aria-expanded="false">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex">
                    <i class="fa-solid fa-square-poll-vertical"></i>
                  </span>
                    <span class="hide-menu">Report</span>
                </div>
            </a>
        </li>
        @endrole

        <!-- ---------------------------------- -->
        <!-- Master Data -->
        <!-- ---------------------------------- -->
        @role('Super Admin')
        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Master Data</span>
        </li>
        @endrole

        <!-- ---------------------------------- -->
        <!-- Master Biodata -->
        <!-- ---------------------------------- -->
        @role('Super Admin')
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ url('master-data/biodata/') }}"  aria-expanded="false">
                <span>
                    <i class="fa-solid fa-person-circle-check"></i>
                </span>
                <span class="hide-menu">Biodata</span>
            </a>
        </li>
        @endrole

        <hr>

        <!-- ---------------------------------- -->
        <!-- Master Aspect -->
        <!-- ---------------------------------- -->
        @role('Super Admin')
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ url('master-data/aspect/') }}"  aria-expanded="false">
                <span>
                    <i class="fa-solid fa-list-ol"></i>
                </span>
                <span class="hide-menu">Aspect</span>
            </a>
        </li>
        @endrole

        <!-- ---------------------------------- -->
        <!-- Master Categories -->
        <!-- ---------------------------------- -->
        @role('Super Admin')
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ url('master-data/categories/') }}"  aria-expanded="false">
                <span>
                    <i class="fa-solid fa-list-ul"></i>
                </span>
                <span class="hide-menu">Categories</span>
            </a>
        </li>
        @endrole

        <!-- ---------------------------------- -->
        <!-- Master Question -->
        <!-- ---------------------------------- -->
        @role('Super Admin')
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ url('master-data/questions/') }}"  aria-expanded="false">
                <span>
                    <i class="fa-solid fa-spell-check"></i>
                </span>
                <span class="hide-menu">Questions</span>
            </a>
        </li>
        @endrole

        <hr>

        <!-- ---------------------------------- -->
        <!-- Master Answers -->
        <!-- ---------------------------------- -->
        @role('Super Admin')
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ url('master-data/answers/') }}"  aria-expanded="false">
                <span>
                  <i class="ti ti-zoom-question"></i>
                </span>
                <span class="hide-menu">Answers</span>
            </a>
        </li>
        @endrole

        <!-- ---------------------------------- -->
        <!-- User -->
        <!-- ---------------------------------- -->
        @role('Super Admin')
        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Admin</span>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ url('users') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-users"></i>
                </span>
                <span class="hide-menu">User</span>
            </a>
        </li>
        @endrole
    </ul>
</nav>
