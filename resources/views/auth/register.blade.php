@extends('layouts.auth')
@section('content')
    <!-- Left visual panel (desktop) -->
    @include('partials.banner-image')

    <!-- Right form panel -->
    <main class="relative flex items-center justify-center px-6 py-10 md:py-16">
        <!-- Mobile background -->
        @include('partials.mobile-background')

        <article class="relative w-full max-w-md md:max-w-lg min-h-[480px] backdrop-blur-xl bg-white/70 border border-white/60 rounded-2xl p-8 md:p-10">
            <header class="mb-6 text-center">
                <a href="#" aria-label="Kodex home" class="inline-flex items-center gap-2 select-none">
                    <img class="w-[110px]" src="{{ asset('assets/auth/Kodex-logo.png') }}" alt="logo" />
                </a>
                <h1 class="mt-4 text-2xl font-semibold">Let's Get Started</h1>
                <p class="mt-1 text-sm text-neutral-500">Enter your email to create your account.</p>
            </header>

            <form class="space-y-5" action="{{ route('register.store') }}" method="POST" id="register-form">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium">Email</label>
                    <input id="email" name="email" type="email" placeholder="Enter your e-mail" autocomplete="email" class="flex h-11 w-full rounded-none border-0 border-b border-neutral-300 bg-transparent px-0 py-2 text-base placeholder:text-neutral-400 focus:outline-none focus:border-brand focus:ring-0" value="{{ old('email') }}">
                </div>

                @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror

                <button type="button" id="register-btn" class="h-12 w-full rounded-full bg-brand text-white font-medium shadow-sm hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 transition-all duration-300 ease-in-out relative overflow-hidden">
                    <span class="relative z-10">Continue</span>
                </button>

                <a href="{{ route('social.redirect', 'google') }}" type="button" class="h-12 w-full rounded-full border border-neutral-200 bg-[#dfdddd] text-neutral-800 font-medium focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 transition-all duration-300 ease-in-out flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="h-5 w-5">
                        <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.954,4,4,12.954,4,24c0,11.046,8.954,20,20,20c11.046,0,20-8.954,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
                        <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,16.108,18.961,13,24,13c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z" />
                        <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.5,5.005C9.62,39.556,16.227,44,24,44z" />
                        <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.103,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C34.917,40.915,44,35,44,24C44,22.659,43.862,21.35,43.611,20.083z" />
                    </svg>
                    Continue with Google
                </a>

                <p class="text-center text-sm text-neutral-500">Already have an account? <a href="{{ route('login') }}" class="text-brand hover:underline">Login</a></p>

                <div class="pt-2 flex justify-center gap-3" aria-hidden="true">
                    <span class="h-1 w-12 rounded-full bg-brand"></span>
                    <span class="h-1 w-12 rounded-full bg-brand/60"></span>
                    <span class="h-1 w-12 rounded-full bg-brand/40"></span>
                </div>
            </form>
        </article>
    </main>
@endsection

@push('scripts')
    <script>
        document.getElementById('register-btn').addEventListener('click', function (e) {
            e.preventDefault(); // Prevent default form submission
            const form = document.getElementById('register-form');
            const button = this;

            // Set preloader state
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

            // Validate form
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                button.innerHTML = `<span class="relative z-10">Continue</span>`;
                button.disabled = false;

                const invalidField = form.querySelector(':invalid');
                if (invalidField) {
                    invalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    invalidField.focus();
                }
                return;
            }

            // Submit form after a slight delay to show preloader
            setTimeout(() => {
                form.submit();
            }, 500);
        });

        // Initialize countdown timer for throttle errors
        let countdown = 0;
        let countdownInterval = null;

        // Check for throttle data from the server (passed via Laravel)
        const throttleSeconds = {{ $errors->has('throttle') ? json_encode(max(0, round($errors->first('throttle')))) : 0 }};

        function startCountdown(seconds) {
            // Clear any existing interval
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }

            countdown = seconds;
            const submitButton = document.getElementById('register-btn');

            if (seconds > 0) {
                submitButton.innerHTML = `Retry in ${seconds}s`;
                submitButton.disabled = true;
                countdownInterval = setInterval(() => {
                    countdown--;
                    submitButton.innerHTML = `Resend in ${countdown}s`;
                    if (countdown <= 0) {
                        clearInterval(countdownInterval);
                        submitButton.innerHTML = `<span class="relative z-10">Continue</span>`;
                        submitButton.disabled = false;
                    }
                }, 1000);
            } else {
                submitButton.innerHTML = `<span class="relative z-10">Continue</span>`;
                submitButton.disabled = false;
            }
        }

        // Initialize countdown if the throttle is active
        document.addEventListener('DOMContentLoaded', () => {
            startCountdown(throttleSeconds);
        });

        // Cleanup interval on page unload
        window.addEventListener('beforeunload', () => {
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }
        });
    </script>
@endpush
