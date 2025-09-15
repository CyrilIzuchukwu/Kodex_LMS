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
                <h1 class="mt-4 text-2xl font-semibold">Log in to your account</h1>
                <p class="mt-1 text-sm text-neutral-500">Welcome back! Please enter your details.</p>
            </header>

            <!-- Fixed form with action, method, and ID -->
            <form id="login-form" action="{{ route('login.store') }}" method="POST" class="space-y-5" novalidate>
                @csrf

                <!-- Check for provider-specific errors -->
                @if ($errors->any())
                    <div class="mt-1 text-sm text-red-500">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium">Email</label>
                    <input id="email" name="email" type="email" placeholder="Enter your e-mail" autocomplete="email" class="flex h-11 w-full rounded-none border-0 border-b border-neutral-300 bg-transparent px-0 py-2 text-base placeholder:text-neutral-400 focus:outline-none focus:border-brand focus:ring-0" value="{{ old('email') }}" />
                </div>

                @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror

                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="text-sm font-medium">Password</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" placeholder="Enter your password" class="flex h-11 w-full rounded-none border-0 border-b border-neutral-300 bg-transparent px-0 pr-10 py-2 text-base placeholder:text-neutral-400 focus:outline-none focus:border-brand focus:ring-0" />
                        <button type="button" aria-label="Show password" class="absolute inset-y-0 right-2 my-auto inline-flex items-center justify-center rounded-md p-2 text-neutral-500 hover:text-neutral-800 focus:outline-none focus:ring-2 focus:ring-brand" onclick="togglePassword()">
                            <svg id="eye" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg id="eye-off" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5 hidden"><path d="m3 3 18 18"/><path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path d="M9.5 5.1A10.4 10.4 0 0 1 12 4c7 0 11 8 11 8a17.1 17.1 0 0 1-3.2 4.6"/><path d="M6.6 6.6C3.8 8.7 2 12 2 12a16.9 16.9 0 0 0 6.5 6.5"/></svg>
                        </button>
                    </div>
                </div>
                @error('password')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror

                <!-- Remember + Forgot -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-neutral-300 text-brand focus:ring-brand"
                            {{ old('remember') ? 'checked' : '' }} />
                        <span>Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-brand hover:underline">Forgot Password</a>
                </div>

                <!-- Login Button with preloader -->
                <button id="login-btn" type="button" class="h-12 w-full rounded-full bg-brand text-white font-medium shadow-sm hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand">
                    Login
                </button>

                <!-- Google Button -->
                <a href="{{ route('social.redirect', 'google') }}" type="button" class="h-12 w-full rounded-full border border-neutral-200 bg-[#dfdddd] text-neutral-800 font-medium focus:outline-none focus:ring-2 focus:ring-brand flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="h-5 w-5"><path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.302,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.954,4,4,12.954,4,24c0,11.046,8.954,20,20,20c11.046,0,20-8.954,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,16.108,18.961,13,24,13c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.5,5.005C9.62,39.556,16.227,44,24,44z"/><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.103,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C34.917,40.915,44,35,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg>
                    Continue with Google
                </a>

                <p class="text-center text-sm text-neutral-500">
                    Don’t have an account? <a href="{{ route('register') }}" class="text-brand hover:underline">Sign up</a>
                </p>
            </form>
        </article>
    </main>
@endsection

@push('scripts')
    <script>
        // Preloader and validation
        document.getElementById('login-btn').addEventListener('click', function (e) {
            e.preventDefault();
            const form = document.getElementById('login-form');
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
                button.innerHTML = `Login`;
                button.disabled = false;
                return;
            }

            // Delay for animation effect
            setTimeout(() => form.submit(), 500);
        });

        // Toggle password visibility
        function togglePassword() {
            const input = document.getElementById('password');
            const eye = document.getElementById('eye');
            const eyeOff = document.getElementById('eye-off');
            const isText = input.type === 'text';
            input.type = isText ? 'password' : 'text';
            eye.classList.toggle('hidden', !isText);
            eyeOff.classList.toggle('hidden', isText);
        }
    </script>
@endpush
