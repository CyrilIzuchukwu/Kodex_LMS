@extends('layouts.auth')
@section('content')
    <!-- Left visual panel (desktop) -->
    @include('partials.banner-image')

    <!-- Right form panel -->
    <main class="relative flex items-center justify-center px-4 py-10 md:py-16">
        <!-- Mobile background -->
        @include('partials.mobile-background')

        <article class="relative w-full max-w-md md:max-w-lg min-h-[480px] backdrop-blur-xl bg-white/70 border border-white/60 rounded-2xl p-8 md:p-10">
            <header class="mb-6 text-center">
                <a href="#" aria-label="Kodex home" class="inline-flex items-center gap-2 select-none">
                    <img class="w-[110px]" src="{{ asset('assets/auth/Kodex-logo.png') }}" alt="logo" />
                </a>

                <div class="flex flex-col justify-center items-center gap-y-4">
                    <img class="w-[80px] mt-10" src="{{ asset('assets/auth/key.png') }}" alt="key">
                </div>

                <h1 class="mt-4 text-2xl font-semibold">Create New Password</h1>
                <p class="mt-1 text-sm text-neutral-500">Protect your account with a secure password.</p>
            </header>

            <!-- Form with correct ID and action for password reset -->
            <form id="password-reset-form" action="{{ route('password.update') }}" method="POST" class="space-y-5" novalidate>
                @csrf

                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="text-sm font-medium">New Password</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" placeholder="Enter your new password" class="flex h-11 w-full rounded-none border-0 border-b border-neutral-300 bg-transparent px-0 pr-10 py-2 text-base placeholder:text-neutral-400 focus:outline-none focus:border-brand focus:ring-0" value="{{ old('password') }}" />
                        <button type="button" aria-label="Show password" class="absolute inset-y-0 right-2 my-auto inline-flex items-center justify-center rounded-md p-2 text-neutral-500 hover:text-neutral-800 focus:outline-none focus:ring-2 focus:ring-brand" onclick="togglePassword('password')">
                            <svg id="eye-password" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg id="eye-off-password" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5 hidden"><path d="m3 3 18 18"/><path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path d="M9.5 5.1A10.4 10.4 0 0 1 12 4c7 0 11 8 11 8a17.1 17.1 0 0 1-3.2 4.6"/><path d="M6.6 6.6C3.8 8.7 2 12 2 12a16.9 16.9 0 0 0 6.5 6.5"/></svg>
                        </button>
                    </div>
                    <p class="text-xs text-brand">At least 8 characters with numbers and symbols</p>
                </div>
                @error('password')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="text-sm font-medium">Confirm New Password</label>
                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm your new password" class="flex h-11 w-full rounded-none border-0 border-b border-neutral-300 bg-transparent px-0 pr-10 py-2 text-base placeholder:text-neutral-400 focus:outline-none focus:border-brand focus:ring-0" />
                        <button type="button" aria-label="Show confirm password" class="absolute inset-y-0 right-2 my-auto inline-flex items-center justify-center rounded-md p-2 text-neutral-500 hover:text-neutral-800 focus:outline-none focus:ring-2 focus:ring-brand" onclick="togglePassword('password_confirmation')">
                            <svg id="eye-password_confirmation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg id="eye-off-password_confirmation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5 hidden"><path d="m3 3 18 18"/><path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path d="M9.5 5.1A10.4 10.4 0 0 1 12 4c7 0 11 8 11 8a17.1 17.1 0 0 1-3.2 4.6"/><path d="M6.6 6.6C3.8 8.7 2 12 2 12a16.9 16.9 0 0 0 6.5 6.5"/></svg>
                        </button>
                    </div>
                </div>
                @error('password_confirmation')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror

                <!-- Reset Password Button -->
                <button id="reset-password-btn" type="submit" class="h-12 w-full rounded-full bg-brand text-white font-medium shadow-sm hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand">
                    Reset Password
                </button>

                <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 text-sm text-neutral-600 hover:text-neutral-900">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path d="M15 18l-6-6 6-6"/></svg>
                    Back to Login
                </a>

                <div class="pt-2 flex justify-center gap-3" aria-hidden="true">
                    <span class="h-1 w-12 rounded-full bg-brand"></span>
                    <span class="h-1 w-12 rounded-full bg-brand"></span>
                    <span class="h-1 w-12 rounded-full bg-brand"></span>
                </div>
            </form>
        </article>
    </main>
@endsection

@push('scripts')
    <script>
        // Preloader and validation for password reset
        document.getElementById('reset-password-btn').addEventListener('click', function (e) {
            const form = document.getElementById('password-reset-form');
            const button = this;

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
                button.innerHTML = `Reset Password`;
                button.disabled = false;
                e.preventDefault();
                return;
            }

            // Submit form after brief delay for animation
            setTimeout(() => form.submit(), 500);
        });

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
    </script>
@endpush
