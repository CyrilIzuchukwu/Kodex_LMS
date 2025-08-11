<nav id="sidebar" class="sidebar-wrapper overflow-hidden">
    <div class="sidebar-content">
        <div class="sidebar-brand">
            <a href="">
                <img src="{{ asset('assets/auth/Kodex-logo.png') }}" class="w-24" alt="Logo">
            </a>
        </div>

        <ul class="sidebar-menu border-t border-white/10" data-simplebar>
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="mdi mdi-view-dashboard-outline me-1"></i>Dashboard
                </a>
            </li>

            <li class="sidebar-dropdown">
                <a href="javascript:void(0)"><i class="uil uil-users-alt me-1"></i>User Management</a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="">Student</a></li>
                        <li><a href="">Instructor</a></li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-dropdown">
                <a href="javascript:void(0)"><i class="uil uil-book-alt me-1"></i>Course Oversight</a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href=""></a></li>
                        <li><a href="">Instructor</a></li>
                    </ul>
                </div>
            </li>

            <li class="">
                <a href="">
                    <i class="mdi mdi-bullhorn-variant-outline me-1"></i>Announcement
                </a>
            </li>

            <li class="">
                <a href="">
                    <i class="uil uil-bill me-1"></i>Payments
                </a>
            </li>

            <li class="mt-5 ps-2">
                <span class="text-[#262626] text-sm">Account</span>
            </li>

            <li class="">
                <a href="">
                    <i class="uil uil-setting me-1"></i>Settings
                </a>
            </li>

            <li class="mt-auto border-t border-white/10">
                <a href="" class="!text-[#9F0600]">
                    <i class="uil uil-sign-out-alt me-1"></i>Logout
                </a>
            </li>
        </ul>
    </div>
</nav>
