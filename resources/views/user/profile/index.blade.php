@extends('layouts.user')
@section('content')
    <div class="mb-6 px-4 md:px-6">
        <nav class="bg-white rounded-[20px] md:rounded-[30px] shadow-sm px-4 md:px-6 py-3 flex items-center justify-start w-full">
            <ol class="flex items-center space-x-2 md:space-x-3 text-sm md:text-base font-medium text-[#141B34]">
                <li>
                    <a href="{{ route('user.dashboard') }}" class="hover:text-[#E68815] transition-colors duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-7 7v-10"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </li>
                <li>
                    <span class="text-[#E68815] font-semibold">Edit Profile</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="container mx-auto mt-4 mb-5" id="main-content">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Edit Profile Card -->
            <div class="w-full bg-white rounded-[20px] md:rounded-[30px] px-6 md:px-8 py-6 md:py-8 shadow-sm overflow-hidden">
                <form class="flex flex-col h-full" id="profile-form" action="{{ route('user.profile.update.profile') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Header -->
                    <div class="flex items-center space-x-3 mb-12">
                        <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                            <i class="uil uil-user"></i>
                        </div>
                        <h2 class="font-medium text-[18px] leading-[100%] tracking-[-0.02em] text-[#1B1B1B]">
                            Edit Profile
                        </h2>
                    </div>

                    <!-- Profile Image Upload -->
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-20 h-20 rounded-full bg-[#F5CE9F] flex items-center justify-center overflow-hidden">
                            <img id="profile-preview" src="{{ $avatar }}" alt="User Icon" class="w-full h-full object-cover">
                        </div>

                        <!-- Upload + Remove Options -->
                        <div class="flex flex-col space-y-2">
                            <!-- Upload Button -->
                            <label for="profileImage" class="cursor-pointer px-4 py-3 font-medium text-[14px] leading-[100%] tracking-[-0.02em] font-sans bg-gray-100 text-[#1B1B1B] rounded-full shadow-sm hover:bg-gray-200 transition inline-block">
                                Upload new image
                            </label>
                            <input type="file" id="profileImage" name="profile_image" class="hidden" accept="image/*">
                            <!-- Remove Button -->
                            <button type="button" id="remove-image" class="px-4 py-3 font-medium text-[14px] leading-[100%] tracking-[-0.02em] font-sans bg-red-100 text-red-600 rounded-full shadow-sm hover:bg-red-200 transition">
                                Remove Image
                            </button>
                        </div>
                    </div>

                    @error('profile_image')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror

                    <!-- Form Fields -->
                    <div class="mb-5">
                        <label for="name" class="block text-sm font-medium text-gray-600 mb-1">User Name *</label>
                        <input type="text" id="name" name="name" placeholder="Name" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" value="{{ old('name', auth()->user()->name) }}" />
                        @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="phone_number" class="block text-sm font-medium text-gray-600 mb-1">Phone *</label>
                        <input type="text" id="phone_number" name="phone_number" placeholder="Phone Number" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" value="{{ old('name', auth()->user()->profile?->phone_number) }}" />
                        @error('phone_number')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-gray-600 mb-1">E-mail Address *</label>
                        <input id="email" type="email" class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-[#E1E1E1] rounded-lg text-[#1B1B1B] bg-gray-100 cursor-not-allowed" value="{{ old('email', auth()->user()->email) }}" readonly placeholder="Enter your email address" autocomplete="email">
                        @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" id="profile-submit" class="mt-auto w-full bg-[#EB8C22] text-white font-medium py-3 rounded-full hover:bg-[#d1761a] transition">
                        Update
                    </button>
                </form>
            </div>

            <!-- Change Password Card -->
            <div class="w-full bg-white rounded-[20px] md:rounded-[30px] px-6 md:px-8 py-6 md:py-8 shadow-sm overflow-hidden">
                <form class="flex flex-col h-full" id="reset-password-form" action="{{ route('user.profile.reset.password') }}" method="POST">
                    @csrf
                    <!-- Header -->
                    <div class="flex items-center space-x-3 mb-12">
                        <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                            <span class="mdi mdi-lock-outline"></span>
                        </div>
                        <h2 class="font-medium text-[18px] leading-[100%] tracking-[-0.02em] text-[#1B1B1B]">
                            Change Password
                        </h2>
                    </div>

                    <!-- Form Fields -->
                    <div class="space-y-4">
                        <!-- Current Password -->
                        <div class="space-y-2">
                            <label for="current_password" class="text-sm font-medium text-gray-600">Current Password *</label>
                            <div class="relative">
                                <input id="current_password" name="current_password" type="password" placeholder="Enter your current password" class="flex h-11 w-full rounded-none border-0 border-b border-neutral-300 bg-transparent px-0 pr-10 py-2 text-base text-[#1B1B1B] placeholder:text-[#6B7280] focus:outline-none focus:border-[#EB8C22] focus:ring-0" />
                                <button type="button" aria-label="Show password" class="absolute inset-y-0 right-2 my-auto inline-flex items-center justify-center rounded-md p-2 text-neutral-500 hover:text-neutral-800 focus:outline-none focus:ring-2 focus:ring-[#EB8C22]" onclick="togglePassword('current_password')">
                                    <svg id="eye-current_password" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <svg id="eye-off-current_password" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5 hidden"><path d="m3 3 18 18"/><path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path d="M9.5 5.1A10.4 10.4 0 0 1 12 4c7 0 11 8 11 8a17.1 17.1 0 0 1-3.2 4.6"/><path d="M6.6 6.6C3.8 8.7 2 12 2 12a16.9 16.9 0 0 0 6.5 6.5"/></svg>
                                </button>
                            </div>
                            @error('current_password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="space-y-2">
                            <label for="password" class="text-sm font-medium text-gray-600">New Password *</label>
                            <div class="relative">
                                <input id="password" name="password" type="password" placeholder="Enter your new password" class="flex h-11 w-full rounded-none border-0 border-b border-neutral-300 bg-transparent px-0 pr-10 py-2 text-base text-[#1B1B1B] placeholder:text-[#6B7280] focus:outline-none focus:border-[#EB8C22] focus:ring-0" />
                                <button type="button" aria-label="Show password" class="absolute inset-y-0 right-2 my-auto inline-flex items-center justify-center rounded-md p-2 text-neutral-500 hover:text-neutral-800 focus:outline-none focus:ring-2 focus:ring-[#EB8C22]" onclick="togglePassword('password')">
                                    <svg id="eye-password" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <svg id="eye-off-password" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5 hidden"><path d="m3 3 18 18"/><path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path d="M9.5 5.1A10.4 10.4 0 0 1 12 4c7 0 11 8 11 8a17.1 17.1 0 0 1-3.2 4.6"/><path d="M6.6 6.6C3.8 8.7 2 12 2 12a16.9 16.9 0 0 0 6.5 6.5"/></svg>
                                </button>
                            </div>
                            <p class="text-xs text-[#EB8C22]">At least 8 characters with numbers and symbols</p>
                            @error('password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <label for="password_confirmation" class="text-sm font-medium text-gray-600">Confirm Password *</label>
                            <div class="relative">
                                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm your new password" class="flex h-11 w-full rounded-none border-0 border-b border-neutral-300 bg-transparent px-0 pr-10 py-2 text-base text-[#1B1B1B] placeholder:text-[#6B7280] focus:outline-none focus:border-[#EB8C22] focus:ring-0" />
                                <button type="button" aria-label="Show confirm password" class="absolute inset-y-0 right-2 my-auto inline-flex items-center justify-center rounded-md p-2 text-neutral-500 hover:text-neutral-800 focus:outline-none focus:ring-2 focus:ring-[#EB8C22]" onclick="togglePassword('password_confirmation')">
                                    <svg id="eye-password_confirmation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <svg id="eye-off-password_confirmation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5 hidden"><path d="m3 3 18 18"/><path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path d="M9.5 5.1A10.4 10.4 0 0 1 12 4c7 0 11 8 11 8a17.1 17.1 0 0 1-3.2 4.6"/><path d="M6.6 6.6C3.8 8.7 2 12 2 12a16.9 16.9 0 0 0 6.5 6.5"/></svg>
                                </button>
                            </div>
                            @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" id="password-submit" class="mt-auto w-full bg-[#EB8C22] text-white font-medium py-3 rounded-full hover:bg-[#d1761a] transition">
                        Change Password
                    </button>
                </form>
            </div>
        </div>

        <div class="w-full bg-white rounded-[20px] md:rounded-[30px] px-6 md:px-8 py-6 md:py-8 shadow-sm overflow-hidden mt-4">
            <!-- Header -->
            <div class="flex items-center space-x-3 mb-12">
                <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                    <span class="mdi mdi-shield-key-outline"></span>
                </div>
                <h2 class="font-medium text-[18px] leading-[100%] tracking-[-0.02em] text-[#1B1B1B]">
                    Account & Security
                </h2>
            </div>

            <div class="gap-8 flex flex-col">
                <div class="flex flex-col sm:flex-row items-start sm:items-end justify-start sm:justify-between gap-4">
                    <div>
                        <p class="text-[#8C530D] font-medium text-lg flex items-center gap-2">
                            <i class="uil uil-link text-lg font-medium"></i>
                            Linked accounts
                        </p>
                        <span class="text-[#1B1B1B] text-sm font-normal">Enable seamless and secure access by linking your Kodex account with Google</span>
                        @if (auth()->user()->hasSocialAccount('google'))
                            <div class="flex items-center space-x-3 mt-3">
                                <div class="w-10 h-10 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"></path>
                                        <path d="M12 23c2.97 0 5.46-1.02 7.28-2.76l-3.57-2.77c-1.02.68-2.31 1.08-3.71 1.08-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C4.01 20.56 7.47 23 12 23z"></path>
                                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.84h.81z"></path>
                                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.47 1 4.01 3.44 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-[#1B1B1B] mb-2 sm:mb-0">Google: Connected</span>
                            </div>
                        @endif
                    </div>

                    @if (auth()->user()->hasSocialAccount('google'))
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-3 w-full sm:w-auto rounded-lg">
                            <form action="{{ route('social.disconnect', ['provider' => 'google', 'student' => auth()->user()->id]) }}" method="POST" class="w-full sm:w-32 mt-2 sm:mt-0">
                                @csrf
                                <button type="submit" class="w-full bg-[#E30800] text-white font-medium py-2 px-4 rounded-full hover:bg-red-600 transition">Disconnect</button>
                            </form>
                        </div>
                    @else
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-3 w-full sm:w-auto rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-white">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"></path>
                                        <path d="M12 23c2.97 0 5.46-1.02 7.28-2.76l-3.57-2.77c-1.02.68-2.31 1.08-3.71 1.08-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C4.01 20.56 7.47 23 12 23z"></path>
                                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.84h.81z"></path>
                                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.47 1 4.01 3.44 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-[#1B1B1B] mb-2 sm:mb-0">Google: Not Connected</span>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-end justify-start sm:justify-between gap-4">
                    <div>
                        <p class="text-[#E30800] font-medium text-lg flex items-center gap-2">
                            <i class="uil uil-link text-lg font-medium"></i>
                            Delete my Account
                        </p>
                        <span class="text-[#1B1B1B] text-sm font-normal">Warning: Deleting your account is permanent and cannot be undone.</span>
                    </div>

                    <button class="flex items-center justify-center space-x-1 w-full sm:w-32 bg-[#E30800] text-white text-sm font-medium px-5 py-2 rounded-full shadow hover:bg-red-600 transition" onclick="showModal('deleteModal')">
                        <span>Delete</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed hidden inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-[9999] p-4 opacity-0 transition-all duration-300 ease-in-out">
        <div class="modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-full max-w-sm md:max-w-md h-auto p-4 md:p-6 flex flex-col items-center justify-center z-[10000] transform scale-95 transition-transform duration-300 ease-in-out">
            <img src="{{ asset('dashboard_assets/images/img/gradient.png') }}" alt="delete" class="w-12 h-12 md:w-16 md:h-16 mb-4">
            <h2 class="text-base md:text-lg font-semibold text-gray-800 mb-4 text-center">Delete Account?</h2>
            <p class="text-gray-600 mb-6 text-center text-xs md:text-sm">
                Are you sure you want to delete your account? This action cannot be undone.
            </p>
            <form id="delete-form" action="{{ route('user.profile.destroy') }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-center gap-3 w-full">
                    <button type="button" onclick="closeModal('deleteModal')" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#EDEDED] text-gray-700 hover:bg-gray-300 transition-colors text-xs md:text-sm">
                        Cancel
                    </button>
                    <button type="submit" id="delete-account" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#E30800] text-white hover:bg-red-600 transition-colors text-xs md:text-sm flex items-center justify-center">
                        <span class="submit-text">Delete</span>
                        <span class="preloader flex items-center justify-center gap-2 hidden">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Profile picture preview and removal
        const profileImageInput = document.getElementById('profileImage');
        const profilePreview = document.getElementById('profile-preview');
        const removeImageBtn = document.getElementById('remove-image');
        const defaultAvatar = "{{ asset('dashboard_assets/images/client/user-03.png') }}";

        profileImageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                profilePreview.src = URL.createObjectURL(file);
                profilePreview.classList.remove('w-12', 'h-12', 'object-contain');
                profilePreview.classList.add('w-full', 'h-full', 'object-cover');
            }
        });

        removeImageBtn.addEventListener('click', function() {
            profileImageInput.value = '';
            profilePreview.src = defaultAvatar;
            profilePreview.classList.remove('w-full', 'h-full', 'object-cover');
            profilePreview.classList.add('w-12', 'h-12', 'object-contain');
        });

        // Form submission with preloader
        function handleFormSubmission(formId, buttonId, buttonText) {
            const form = document.getElementById(formId);
            const button = document.getElementById(buttonId);

            button.addEventListener('click', function(e) {
                // Show preloader
                button.innerHTML = `
                    <span class="flex items-center justify-center gap-2 z-10 relative">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span>Processing...</span>
                    </span>
                `;
                button.disabled = true;

                // Check form validity
                if (!form.checkValidity()) {
                    form.reportValidity();
                    button.innerHTML = buttonText;
                    button.disabled = false;
                    e.preventDefault();
                    return;
                }

                // Submit form after brief delay for animation
                setTimeout(() => form.submit(), 500);
            });
        }

        // Initialize form submission handlers
        handleFormSubmission('profile-form', 'profile-submit', 'Update');
        handleFormSubmission('reset-password-form', 'password-submit', 'Change Password');
        handleFormSubmission('delete-form', 'delete-account', 'Delete');

        // Toggle password visibility
        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            const eye = document.getElementById(`eye-${fieldId}`);
            const eyeOff = document.getElementById(`eye-off-${fieldId}`);
            const isText = input.type === 'text';
            input.type = isText ? 'password' : 'text';
            eye.classList.toggle('hidden', !isText);
            eyeOff.classList.toggle('hidden', isText);
        }

        // Modal functionality
        function showModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modal.classList.remove('opacity-0');
            modal.querySelector('.modal-content').classList.remove('scale-95');
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('opacity-0');
            modal.querySelector('.modal-content').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        // Initialize the form when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            const phoneNumberInput = document.getElementById('phone_number');
            if (phoneNumberInput && typeof Cleave !== 'undefined') {
                new Cleave('#phone_number', {
                    numericOnly: true,
                    blocks: [0, 3, 0, 4, 4],
                    delimiters: ['(', ')', ' ', '-', ' '],
                    maxLength: 16
                });
            }
        });
    </script>
@endpush
