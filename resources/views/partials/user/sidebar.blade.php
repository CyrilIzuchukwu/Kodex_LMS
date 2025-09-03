<nav id="sidebar" class="sidebar-wrapper overflow-hidden">
    <div class="sidebar-content">
        <div class="sidebar-brand">
            <a href="" class="!hover:bg-none ">
                <img src="{{ asset('assets/auth/Kodex-logo.png') }}" class="w-24" alt="Logo">
            </a>
        </div>

        <ul class="sidebar-menu border-t border-white/10" data-simplebar>
            <li class="">
                <a href="{{ route('user.dashboard') }}">
                    <i class="hgi hgi-stroke hgi-dashboard-square-03 me-1"></i>Dashboard
                </a>
            </li>


            <li class="">
                <a href="{{ route('user.my-learning') }}">
                    <i class="uil uil-book-open me-1"></i>
                    My learning
                </a>
            </li>


            <li class="">
                <a href="{{ route('user.courses') }}">
                    <i class="hgi hgi-stroke hgi-book-04 me-1"></i>
                    Courses
                </a>
            </li>




            <li class="mt-5 ps-2">
                <span class="text-[#262626] text-sm">Settings</span>
            </li>



            <li class="">
                <a href="{{ route('user.settings') }}">
                    <i class="hgi hgi-stroke hgi-setting-07 me-1"></i>
                    Settings
                </a>
            </li>

            {{-- use the same logout for admin  --}}
            <li class="mt-auto border-t border-white/10">
                <a href="#" id="logout-button" class="!text-[#9F0600]">
                    <i class="uil uil-sign-out-alt me-1"></i>Logout
                </a>
            </li>

        </ul>
    </div>
</nav>


<!-- Logout Confirmation Modal -->
<div id="logoutModal"
    class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-[9999] hidden p-4">
    <div
        class="logout-modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-full max-w-sm md:max-w-md h-auto p-4 md:p-6 flex flex-col items-center justify-center z-[10000]">
        <img src="{{ asset('dashboard_assets/images/img/logout-modal-icon.png') }}" alt="logout"
            class="w-12 h-12 md:w-16 md:h-16 mb-4">
        <h2 class="text-base md:text-lg font-semibold text-gray-800 mb-4 text-center">Logout?</h2>
        <p class="text-gray-600 mb-6 text-center text-xs md:text-sm">
            Are you sure you want to log out? You'll need to sign in again to access your account.
        </p>

        <form id="logout-form" method="POST" action="">
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

                // Open modal when logout button is clicked
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
                    const originalBtnText = submitBtn.innerHTML;

                    // Show loading state
                    submitBtn.innerHTML = `
                        <span class="flex items-center justify-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Logging out...
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
