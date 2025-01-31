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
        <!-- Master Data -->
        <!-- ---------------------------------- -->
        @role('Super Admin')
        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Master Data</span>
        </li>
        @endrole


        <!-- ---------------------------------- -->
        <!-- Master Aspect -->
        <!-- ---------------------------------- -->
        @role('Super Admin')
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ url('admin/genres/') }}"  aria-expanded="false">
                <span>
                    <i class="fa-solid fa-list-ol"></i>
                </span>
                <span class="hide-menu">Genre</span>
            </a>
        </li>
        @endrole

        <!-- ---------------------------------- -->
        <!-- Master Categories -->
        <!-- ---------------------------------- -->
        @role('Super Admin')
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ url('admin/songs/') }}"  aria-expanded="false">
                <span>
                    <i class="fa-solid fa-list-ul"></i>
                </span>
                <span class="hide-menu">Song</span>
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
