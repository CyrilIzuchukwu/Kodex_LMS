@php use Carbon\Carbon;@endphp
<div class="top-header">
    <div class="header-bar flex justify-between">
        <div class="flex items-center space-x-1">
            <!-- show or close sidebar -->
            <a id="close-sidebar" class="size-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[20px] text-center bg-gray-50 dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-white rounded-full" href="javascript:void(0)">
                <i data-feather="menu" class="size-4"></i>
                <!-- Logo -->
                <a href="{{ route('user.dashboard') }}" class="xl:hidden block me-2 mt-2 md:mt-0">
                    <img src="{{ asset('assets/auth/Kodex-logo.png') }}" class="md:hidden block" alt="">
                    <span class="md:block hidden">
                        <img src="{{ asset('assets/auth/Kodex-logo.png') }}" class="inline-block dark:hidden" alt="">
                        <img src="{{ asset('assets/auth/Kodex-logo.png') }}" class="hidden dark:inline-block" alt="">
                    </span>
                </a>
                <!-- Logo -->
            </a>
        </div>

        <div class="flex items-center gap-4">
            <!-- Notification Dropdown -->
            <div class="relative inline-block">
                <button type="button" onclick="toggleNotifications()" class="relative p-2 text-gray-600 hover:text-blue-600 transition-colors" id="notification-menu-button" aria-expanded="false" data-dropdown-toggle="notification-dropdown" data-dropdown-placement="bottom">
                    <i class="mdi mdi-bell text-xl"></i>
                    @if (auth()->user()->unreadNotifications->count() > 0)
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </button>

                <!-- Notification Dropdown menu -->
                <div id="notification-panel" class="hidden fixed top-16 right-4 bg-white rounded-xl shadow-xl border border-gray-200 w-80 max-h-96 overflow-hidden z-40" style="max-width: calc(100vw - 2rem);">
                    <div class="p-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-gray-900">Notifications</h3>
                            <button onclick="toggleNotifications()" class="text-gray-400 hover:text-gray-600">
                                <i class="mdi mdi-close"></i>
                            </button>
                        </div>
                    </div>

                    <div class="max-h-80 overflow-y-auto">
                        @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                            <div class="p-3 border-b border-gray-100 hover:bg-gray-50 {{ $notification->read_at ? '' : 'bg-orange-50' }}">
                                <div class="flex items-start gap-3">
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

                                        @if ($notification->data['attachment_url'] ?? '')
                                            <a href="{{ $notification->data['attachment_url'] }}" class="text-[#EB8C22] hover:text-[#d17a1e] text-xs" target="_blank">
                                                Download Attachment
                                            </a>
                                        @endif

                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ Carbon::parse($notification->created_at)->diffForHumans() }}
                                        </p>
                                    </div>
                                    @if (!$notification->read_at)
                                        <div class="flex-shrink-0">
                                            <div class="w-2 h-2 bg-[#EB8C22] rounded-full"></div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-4 py-6 text-center">
                                <i class="uil uil-megaphone w-8 h-8 text-gray-400 mx-auto mb-2"></i>
                                <p class="text-sm text-gray-500">No notifications</p>
                            </div>
                        @endforelse
                        @if (auth()->user()->notifications->count() > 0)
                            <div class="p-3 text-center">
                                <a href="{{ route('user.notifications.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    View all notifications
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Cart -->
            <div class="relative inline-block">
                <a href="{{ route('user.cart') }}" class="dropdown-toggle size-9 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[20px] text-center bg-gray-50 hover:bg-gray-100 border border-gray-100 rounded-full {{ request()->routeIs('user.carts') ? 'bg-gray-100' : '' }}" type="button">
                    <i data-feather="shopping-cart" class="size-4 text-[#1B1B1B] font-medium"></i>
                    <span class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 bg-red-600 text-white text-[8px] font-medium rounded-full">
                        <span id="cart-count">
                            {{ $cartCount }}
                        </span>
                        <span class="absolute inline-flex h-full w-full rounded-full bg-red-600 opacity-50 animate-ping"></span>
                    </span>
                </a>
            </div>

            <!-- User Profile Dropdown -->
            <div class="relative inline-block">
                <button type="button" onclick="toggleProfile()" class="relative p-2 text-gray-600 hover:text-blue-600 transition-colors" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <img class="w-8 h-8 rounded-full object-cover" src="{{ $avatar }}" alt="photo">
                </button>

                <!-- User Dropdown menu -->
                <div id="profile-panel" class="hidden fixed top-16 right-4 bg-white rounded-xl shadow-xl border border-gray-200 w-80 max-h-96 overflow-hidden z-40" style="max-width: calc(100vw - 2rem);">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900">{{ auth()->user()->name ?? 'User Name' }}</span>
                        <span class="block text-sm text-gray-600 truncate">{{ auth()->user()->email ?? 'user@example.com' }}</span>
                    </div>

                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a href="{{ route('user.profile.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#EB8C22]">
                                <i data-feather="user" class="w-4 h-4 me-2"></i>
                                Profile
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
<div id="logoutModal-top"
     class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-[9999] hidden p-4">
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
                <button type="button" id="cancelLogout-top"
                        class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#EDEDED] text-gray-700 hover:bg-gray-300 transition-colors text-xs md:text-sm">
                    Cancel
                </button>

                <button type="submit" id="confirmLogout-top"
                        class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#E30800] text-white hover:bg-red-600 transition-colors text-xs md:text-sm">
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
    #notification-panel,
    #profile-panel {
        transition: all 0.2s ease-in-out;
        transform-origin: top right;
        min-width: 280px;
        background-color: white !important;
        margin-top: 0.75rem;
    }

    #notification-panel.hidden,
    #profile-panel.hidden {
        opacity: 0;
        transform: scale(0.95);
        display: none;
    }

    /* Base positioning for larger screens */
    #notification-panel {
        right: 8rem; /* Shift notifications left to avoid overlap with profile */
    }

    #profile-panel {
        right: 4rem; /* Align with profile button */
    }

    /* Responsive dropdown width and positioning adjustments */
    @media (max-width: 640px) {
        #notification-panel,
        #profile-panel {
            width: calc(100vw - 2.5rem) !important;
            max-width: 320px;
            right: 1rem !important;
            top: 3.5rem !important; /* Position just below header (adjust based on header height) */
        }
    }

    @media (min-width: 641px) and (max-width: 768px) {
        #notification-panel {
            right: 6rem !important; /* Adjust for medium screens */
        }

        #profile-panel {
            right: 1rem !important; /* Align with profile button */
            top: 3.5rem !important; /* Consistent with header height */
        }
    }

    @media (min-width: 769px) {
        #notification-panel {
            right: 8rem; /* Maintain position for larger screens */
        }

        #profile-panel {
            right: 4rem; /* Maintain alignment with profile button */
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
    #notification-panel,
    #profile-panel {
        max-width: calc(100vw - 2rem);
    }

    /* Override any dark mode styles for dropdowns */
    #notification-panel,
    #profile-panel {
        background-color: white !important;
        color: #374151 !important;
    }

    #notification-panel *,
    #profile-panel * {
        color: inherit !important;
    }

    /* Specific text color overrides */
    #notification-panel .text-gray-900,
    #profile-panel .text-gray-900 {
        color: #111827 !important;
    }

    #notification-panel .text-gray-600,
    #profile-panel .text-gray-600 {
        color: #4b5563 !important;
    }

    #notification-panel .text-gray-500,
    #profile-panel .text-gray-500 {
        color: #6b7280 !important;
    }

    #notification-panel .text-gray-700,
    #profile-panel .text-gray-700 {
        color: #374151 !important;
    }
</style>

<script>
    // Toggle notifications panel
    function toggleNotifications() {
        const notificationPanel = document.getElementById('notification-panel');
        const profilePanel = document.getElementById('profile-panel');

        // If a profile panel is open, close it
        if (!profilePanel.classList.contains('hidden')) {
            profilePanel.classList.add('hidden');
        }

        // Toggle notification panel
        notificationPanel.classList.toggle('hidden');
    }

    // Toggle profile panel
    function toggleProfile() {
        const notificationPanel = document.getElementById('notification-panel');
        const profilePanel = document.getElementById('profile-panel');

        // If a notification panel is open, close it
        if (!notificationPanel.classList.contains('hidden')) {
            notificationPanel.classList.add('hidden');
        }

        // Toggle profile panel
        profilePanel.classList.toggle('hidden');
    }

    // Close both panels when clicking outside
    document.addEventListener('click', function(event) {
        const notificationPanel = document.getElementById('notification-panel');
        const profilePanel = document.getElementById('profile-panel');
        const notificationButton = document.getElementById('notification-menu-button');
        const profileButton = document.getElementById('user-menu-button');

        // Check if click is outside both panels and their buttons
        if (
            !notificationPanel.contains(event.target) &&
            !notificationButton.contains(event.target) &&
            !profilePanel.contains(event.target) &&
            !profileButton.contains(event.target)
        ) {
            notificationPanel.classList.add('hidden');
            profilePanel.classList.add('hidden');
        }
    });

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
                this.submit();
            });
        }
    });
</script>
