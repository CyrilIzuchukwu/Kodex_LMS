<nav id="sidebar" class="sidebar-wrapper overflow-hidden">
    <div class="sidebar-content">
        <div class="sidebar-brand">
            <a href="" class="hover:!bg-[#fff]">
                <img src="{{ asset('assets/auth/Kodex-logo.png') }}" class="w-24" alt="Logo">
            </a>
        </div>

        <ul class="sidebar-menu border-t border-white/10" data-simplebar>
            <li class="{{ isActive('admin.dashboard') }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="uil uil-dashboard me-1"></i>Dashboard
                </a>
            </li>

            <li class="sidebar-dropdown {{ isActive(['admin.students.*', 'admin.instructors.*']) }}">
                <a href="javascript:void(0)">
                    <i class="uil uil-users-alt me-1"></i>User Management
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li class="{{ isActive('admin.students.*') }}">
                            <a href="{{ route('admin.students.index') }}">Students</a>
                        </li>
                        <li class="{{ isActive('admin.instructors.*') }}">
                            <a href="{{ route('admin.instructors.index') }}">Instructors</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-dropdown {{ isActive(['admin.courses.*', 'admin.categories.*']) }}">
                <a href="javascript:void(0)">
                    <i class="uil uil-book-alt me-1"></i>Course Oversight
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li class="{{ isActive('admin.courses.*') }}">
                            <a href="{{ route('admin.courses.index') }}">Manage Courses</a>
                        </li>
                        <li class="{{ isActive('admin.categories.*') }}">
                            <a href="{{ route('admin.categories.index') }}">Course Categories</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="mt-5 ps-2">
                <span class="text-[#262626] text-sm">Financials</span>
            </li>

            <li class="{{ isActive('admin.payment-methods.*') }}">
                <a href="{{ route('admin.payment-methods.index') }}">
                    <i class="uil uil-credit-card me-1"></i>Payment Methods
                </a>
            </li>

            <li class="{{ isActive('admin.coupons.*') }}">
                <a href="{{ route('admin.coupons.index') }}">
                    <i class="uil uil-card-atm me-1"></i>Coupon Codes
                </a>
            </li>

            <li class="sidebar-dropdown {{ isActive('admin.reports.*') }}">
                <a href="javascript:void(0)">
                    <i class="uil uil-chart-bar me-1"></i>Reports
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li class="{{ isActive('admin.reports.transactions.*') }}">
                            <a href="{{ route('admin.reports.transactions') }}">Transaction History</a>
                        </li>
                        <li class="{{ isActive('admin.reports.logins') }}">
                            <a href="{{ route('admin.reports.logins') }}">Login History</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="mt-5 ps-2">
                <span class="text-[#262626] text-sm">Notifications</span>
            </li>

            <li class="{{ isActive('admin.announcements.*') }}">
                <a href="{{ route('admin.announcements.create') }}">
                    <i class="uil uil-megaphone me-1"></i>Announcements
                </a>
            </li>

            <li class="{{ isActive('admin.notifications.*') }}">
                <a href="{{ route('admin.notifications.index') }}">
                    <i class="uil uil-bell me-1"></i>Notifications
                </a>
            </li>

            <li class="sidebar-dropdown {{ isActive('admin.email.*') }}">
                <a href="javascript:void(0)">
                    <i class="uil uil-envelope me-1"></i>Email Settings
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li class="{{ isActive('admin.email.config') }}">
                            <a href="{{ route('admin.email.config') }}">Configuration</a>
                        </li>
                        <li class="{{ isActive('admin.email.send') }}">
                            <a href="{{ route('admin.email.send') }}">Test Email</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="mt-5 ps-2">
                <span class="text-[#262626] text-sm">Settings</span>
            </li>

            <li class="sidebar-dropdown {{ isActive('admin.settings.*') }}">
                <a href="javascript:void(0)">
                    <i class="uil uil-setting me-1"></i>System Settings
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li class="{{ isActive('admin.settings.index') }}">
                            <a href="{{ route('admin.settings.index') }}">General Settings</a>
                        </li>
                        <li class="{{ isActive('admin.settings.seo') }}">
                            <a href="{{ route('admin.settings.seo') }}">SEO</a>
                        </li>
                        <li class="{{ isActive('admin.settings.maintenance') }}">
                            <a href="{{ route('admin.settings.maintenance') }}">Maintenance</a>
                        </li>
                        <li class="{{ isActive('admin.settings.extensions') }}">
                            <a href="{{ route('admin.settings.extensions') }}">Extensions</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="{{ isActive('admin.profile.*') }}">
                <a href="{{ route('admin.profile.index') }}">
                    <i class="uil uil-user me-1"></i>Edit Profile
                </a>
            </li>

            <li class="mt-auto border-t border-white/10 pt-3">
                <a href="#" id="logout-button" class="!text-[#9F0600]">
                    <i class="uil uil-sign-out-alt me-1"></i>Logout
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- Logout Confirmation Modal -->
<div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-[9999] hidden p-4">
    <div
        class="logout-modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-full max-w-sm md:max-w-md h-auto p-4 md:p-6 flex flex-col items-center justify-center z-[10000]">
        <img src="{{ asset('dashboard_assets/images/img/logout-modal-icon.png') }}" alt="logout" class="w-12 h-12 md:w-16 md:h-16 mb-4">
        <h2 class="text-base md:text-lg font-semibold text-gray-800 mb-4 text-center">Logout?</h2>
        <p class="text-gray-600 mb-6 text-center text-xs md:text-sm">
            Are you sure you want to log out? You'll need to sign in again to access your account.
        </p>

        <form id="logout-form" method="POST" action="{{ route('logout') }}">
            @csrf

            <div class="flex justify-center gap-3 w-full">
                <button type="button" id="cancelLogout"
                    class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#EDEDED] text-gray-700 hover:bg-gray-300 transition-colors text-xs md:text-sm">
                    Cancel
                </button>

                <button type="submit" id="confirmLogout"
                    class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#E30800] text-white hover:bg-red-600 transition-colors text-xs md:text-sm">
                    Logout
                </button>
            </div>
        </form>
    </div>
</div>


@push('styles')
    <style>
        .logout-modal-content {
            transform: scale(0.95) translateY(-20px);
            opacity: 0;
            transition: all 0.3s ease-in-out;
        }

        .logout-modal-content.show {
            transform: scale(1) translateY(0);
            opacity: 1;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Logout modal functionality
            setupLogoutModal();

            // Setup logout modal functionality
            function setupLogoutModal() {
                const logoutModal = document.getElementById('logoutModal');
                const logoutForm = document.getElementById('logout-form');
                const cancelLogout = document.getElementById('cancelLogout');
                const logoutButton = document.getElementById('logout-button');

                // Open modal when the logout button is clicked
                logoutButton.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Show modal
                    logoutModal.classList.remove('hidden');
                    setTimeout(() => {
                        document.querySelector('.logout-modal-content').classList.add('show');
                    }, 10);
                });

                // Close modal when cancel is clicked
                cancelLogout.addEventListener('click', function() {
                    logoutModal.classList.add('hidden');
                    document.querySelector('.logout-modal-content').classList.remove('show');
                });

                // Handle form submission
                logoutForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const submitBtn = document.getElementById('confirmLogout');

                    // Show loading state
                    submitBtn.innerHTML = `
                        <span class="flex items-center justify-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Processing...
                        </span>
                    `;
                    submitBtn.disabled = true;

                    // Submit the form
                    this.submit();
                });
            }
        });
    </script>
@endpush
