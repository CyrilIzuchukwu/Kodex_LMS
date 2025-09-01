@php use Carbon\Carbon;@endphp
<div class="top-header">
    <div class="header-bar flex justify-between">
        <div class="flex items-center space-x-1">
            <!-- Logo -->
            <a href="{{ route('admin.dashboard') }}" class="xl:hidden block me-2">
                <img src="{{ asset('assets/auth/Kodex-logo.png') }}" class="md:hidden block" alt="">
                <span class="md:block hidden">
                    <img src="{{ asset('assets/auth/Kodex-logo.png') }}" class="inline-block dark:hidden" alt="">
                    <img src="{{ asset('assets/auth/Kodex-logo.png') }}" class="hidden dark:inline-block" alt="">
                </span>
            </a>
            <!-- Logo -->

            <!-- show or close sidebar -->
            <a id="close-sidebar" class="size-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[20px] text-center bg-gray-50 dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-white rounded-full" href="javascript:void(0)">
                <i data-feather="menu" class="size-4"></i>
            </a>
        </div>

        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse mr-4">
            <!-- Notification Dropdown -->
            <div class="relative inline-block">
                <button type="button" class="flex text-sm bg-gray-100 rounded-full p-1 hover:bg-gray-200 focus:ring-4 focus:ring-[#E68815]/30 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-[#E68815]/50" id="notification-menu-button" aria-expanded="false" data-dropdown-toggle="notification-dropdown" data-dropdown-placement="bottom">
                    <i data-feather="bell" class="w-6 h-6 text-gray-600 dark:text-gray-300"></i>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="absolute top-0 end-0 flex items-center justify-center bg-[#E68815] text-white text-[10px] font-bold rounded-full size-2 after:content-[''] after:absolute after:size-2 after:bg-[#E68815] after:top-0 after:end-0 after:rounded-full after:animate-ping"></span>
                    @endif
                </button>

                <!-- Notification Dropdown menu -->
                <div class="z-50 hidden mt-2 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-lg border border-gray-200 w-80 absolute right-3 sm:right-3 md:right-3 lg:right-3 xl:right-3" id="notification-dropdown" style="max-width: calc(100vw - 2rem);">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <div class="flex justify-between items-center">
                            <span class="block text-sm font-semibold text-gray-900">Notifications</span>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-[#EB8C22] rounded-full">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="max-h-64 overflow-y-auto">
                        @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                            <div class="px-4 py-3 hover:bg-gray-50 {{ $notification->read_at ? '' : 'bg-orange-50' }}">
                                <div class="block">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-[#EB8C22]/10 rounded-full flex items-center justify-center">
                                                <i class="uil uil-megaphone text-[#EB8C22]"></i>
                                            </div>
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $notification->data['title'] }}
                                            </p>

                                            <p class="text-sm text-gray-600 truncate">
                                                {!! Str::limit(strip_tags($notification->data['content']), 50) !!}
                                            </p>

                                            @if($notification->data['attachment_url'])
                                                <a href="{{ $notification->data['attachment_url'] }}" class="text-[#EB8C22] hover:text-[#d17a1e] text-xs" target="_blank">
                                                    Download Attachment
                                                </a>
                                            @endif
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ Carbon::parse($notification->created_at)->diffForHumans() }}
                                            </p>
                                        </div>

                                        @if(!$notification->read_at)
                                            <div class="flex-shrink-0">
                                                <div class="w-2 h-2 bg-[#EB8C22] rounded-full"></div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-4 py-6 text-center">
                                <i class="uil uil-megaphone w-8 h-8 text-gray-400 mx-auto mb-2"></i>
                                <p class="text-sm text-gray-500">No notifications</p>
                            </div>
                        @endforelse
                    </div>

                    @if(auth()->user()->notifications->count() > 0)
                        <div class="px-4 py-2 bg-gray-50">
                            <a href="#" class="text-sm text-[#EB8C22] hover:text-[#d17a1e] font-medium">
                                View all notifications
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- User Profile Dropdown -->
            <div class="relative inline-block">
                <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-[#EB8C22]/30" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-8 h-8 rounded-full" src="{{ $avatar }}" alt="user photo">
                </button>

                <!-- User Dropdown menu -->
                <div class="z-50 hidden mt-2 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-lg border border-gray-200 w-56 absolute right-3 sm:right-3 md:right-3 lg:right-3 xl:right-3" id="user-dropdown" style="max-width: calc(100vw - 2rem);">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900">{{ auth()->user()->name ?? 'User Name' }}</span>
                        <span class="block text-sm text-gray-600 truncate">{{ auth()->user()->email ?? 'user@example.com' }}</span>
                    </div>

                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a href="{{ route('admin.profile.index') }}"
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#EB8C22]">
                                <i data-feather="user" class="w-4 h-4 me-2"></i>
                                Profile
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.settings.index') }}"
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#EB8C22]">
                                <i data-feather="settings" class="w-4 h-4 me-2"></i>
                                Settings
                            </a>
                        </li>

                        <li>
                            <a href="#" id="logout-button-top" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#EB8C22]">
                                <i data-feather="log-out" class="w-4 h-4 me-2"></i>
                                Sign out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Logout Confirmation Modal -->
<div id="logoutModal-top" class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-[9999] hidden p-4">
    <div
        class="logout-modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-full max-w-sm md:max-w-md h-auto p-4 md:p-6 flex flex-col items-center justify-center z-[10000]">
        <img src="{{ asset('dashboard_assets/images/img/logout-modal-icon.png') }}" alt="logout"
             class="w-12 h-12 md:w-16 md:h-16 mb-4">
        <h2 class="text-base md:text-lg font-semibold text-gray-800 mb-4 text-center">Logout?</h2>
        <p class="text-gray-600 mb-6 text-center text-xs md:text-sm">
            Are you sure you want to log out? You'll need to sign in again to access your account.
        </p>

        <form id="logout-form-top" method="POST" action="{{ route('logout') }}">
            @csrf

            <div class="flex justify-center gap-3 w-full">
                <button type="button" id="cancelLogout-top" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#EDEDED] text-gray-700 hover:bg-gray-300 transition-colors text-xs md:text-sm">
                    Cancel
                </button>

                <button type="submit" id="confirmLogout-top" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#E30800] text-white hover:bg-red-600 transition-colors text-xs md:text-sm">
                    Logout
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Custom styles for better visual appeal */
    .top-header {
        background-color: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
    }

    .header-bar {
        padding: 0.75rem 1.5rem;
    }

    /* Dropdown animations and positioning */
    #notification-dropdown,
    #user-dropdown {
        transition: all 0.2s ease-in-out;
        transform-origin: top right;
        min-width: 280px; /* Ensure minimum width on mobile */
        background-color: white !important;
        margin-top: 0.75rem; /* Adjusted for better top alignment */
    }

    #notification-dropdown.hidden,
    #user-dropdown.hidden {
        opacity: 0;
        transform: scale(0.95);
    }

    /* Responsive dropdown width adjustments */
    @media (max-width: 640px) {
        #notification-dropdown {
            width: calc(100vw - 2.5rem) !important;
            max-width: 320px;
            right: 1.25rem !important; /* Slightly more left for small screens */
        }

        #user-dropdown {
            width: calc(100vw - 2.5rem) !important;
            max-width: 280px;
            right: 1.25rem !important; /* Slightly more left for small screens */
        }
    }

    @media (min-width: 641px) and (max-width: 768px) {
        #notification-dropdown {
            right: 0.75rem !important; /* Adjusted for medium screens */
        }

        #user-dropdown {
            right: 0.75rem !important; /* Adjusted for medium screens */
        }
    }

    /* Better hover effects with orange accent */
    .hover\:bg-gray-50:hover {
        background-color: #f9fafb;
    }

    /* Notification badge pulse effect */
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }

    .bg-\[#EB8C22\] {
        animation: pulse 2s infinite;
    }

    /* Smooth transitions */
    * {
        transition: background-color 0.15s ease-in-out, color 0.15s ease-in-out;
    }

    /* Prevent horizontal scrolling on small screens */
    #notification-dropdown,
    #user-dropdown {
        max-width: calc(100vw - 2rem);
    }

    /* Override any dark mode styles for dropdowns */
    #notification-dropdown,
    #user-dropdown {
        background-color: white !important;
        color: #374151 !important;
    }

    #notification-dropdown *,
    #user-dropdown * {
        color: inherit !important;
    }

    /* Specific text color overrides */
    #notification-dropdown .text-gray-900,
    #user-dropdown .text-gray-900 {
        color: #111827 !important;
    }

    #notification-dropdown .text-gray-600,
    #user-dropdown .text-gray-600 {
        color: #4b5563 !important;
    }

    #notification-dropdown .text-gray-500,
    #user-dropdown .text-gray-500 {
        color: #6b7280 !important;
    }

    #notification-dropdown .text-gray-700,
    #user-dropdown .text-gray-700 {
        color: #374151 !important;
    }
</style>

<script>
    // Enhanced dropdown functionality with improved positioning
    document.addEventListener('DOMContentLoaded', function() {
        // Handle notification dropdown
        const notificationButton = document.getElementById('notification-menu-button');
        const notificationDropdown = document.getElementById('notification-dropdown');

        // Handle user dropdown
        const userButton = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-dropdown');

        // Function to adjust the dropdown position based on screen size
        function adjustDropdownPosition(dropdown) {
            if (!dropdown) return;

            const rect = dropdown.getBoundingClientRect();
            const viewportWidth = window.innerWidth;
            const rightOffset = 0.75 * 16; // 0.75rem in pixels (assuming 1rem = 16px)

            // If dropdown extends beyond viewport, adjust position
            if (rect.right > viewportWidth - rightOffset) {
                const overhang = rect.right - (viewportWidth - rightOffset);
                dropdown.style.transform = `translateX(-${overhang}px)`;
            } else {
                dropdown.style.transform = '';
            }
        }

        // Toggle notification dropdown
        if (notificationButton && notificationDropdown) {
            notificationButton.addEventListener('click', function(e) {
                e.stopPropagation();
                notificationDropdown.classList.toggle('hidden');
                userDropdown.classList.add('hidden'); // Close the user dropdown if open
                notificationButton.setAttribute('aria-expanded',
                    notificationDropdown.classList.contains('hidden') ? 'false' : 'true'
                );

                // Adjust position after showing
                if (!notificationDropdown.classList.contains('hidden')) {
                    setTimeout(() => adjustDropdownPosition(notificationDropdown), 10);
                }
            });
        }

        // Toggle user dropdown
        if (userButton && userDropdown) {
            userButton.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.classList.toggle('hidden');
                notificationDropdown.classList.add('hidden'); // Close notification dropdown if open
                userButton.setAttribute('aria-expanded',
                    userDropdown.classList.contains('hidden') ? 'false' : 'true'
                );

                // Adjust position after showing
                if (!userDropdown.classList.contains('hidden')) {
                    setTimeout(() => adjustDropdownPosition(userDropdown), 10);
                }
            });
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!notificationButton?.contains(e.target) && !notificationDropdown?.contains(e.target)) {
                notificationDropdown?.classList.add('hidden');
                notificationButton?.setAttribute('aria-expanded', 'false');
            }

            if (!userButton?.contains(e.target) && !userDropdown?.contains(e.target)) {
                userDropdown?.classList.add('hidden');
                userButton?.setAttribute('aria-expanded', 'false');
            }
        });

        // Close dropdowns on an escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                notificationDropdown?.classList.add('hidden');
                userDropdown?.classList.add('hidden');
                notificationButton?.setAttribute('aria-expanded', 'false');
                userButton?.setAttribute('aria-expanded', 'false');
            }
        });

        // Adjust dropdown positions on the window resize
        window.addEventListener('resize', function() {
            if (!notificationDropdown?.classList.contains('hidden')) {
                adjustDropdownPosition(notificationDropdown);
            }
            if (!userDropdown?.classList.contains('hidden')) {
                adjustDropdownPosition(userDropdown);
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Logout modal functionality
        setupLogoutModal();

        // Setup logout modal functionality
        function setupLogoutModal() {
            const logoutModal = document.getElementById('logoutModal-top');
            const logoutForm = document.getElementById('logout-form-top');
            const cancelLogout = document.getElementById('cancelLogout-top');
            const logoutButton = document.getElementById('logout-button-top');

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

                const submitBtn = document.getElementById('confirmLogout-top');

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
