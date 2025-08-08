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

                <div class="flex flex-col justify-center items-center gap-y-4">
                    <img class="w-[80px] mt-10" src="{{ asset('assets/auth/fingerprint.png') }}" alt="envelope">
                </div>

                <h1 class="mt-4 text-2xl font-semibold text-gray-900">Forgot Password</h1>
                <p class="mt-1 text-sm text-gray-500">Enter your email to reset your password.</p>
            </header>

            <form class="space-y-5" action="{{ route('password.email') }}" method="POST" id="forgot-password-form">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium">Email</label>
                    <input id="email" name="email" type="email" placeholder="Enter your e-mail" autocomplete="email" class="flex h-11 w-full rounded-none border-0 border-b border-neutral-300 bg-transparent px-0 py-2 text-base placeholder:text-neutral-400 focus:outline-none focus:border-brand focus:ring-0" value="{{ old('email') }}">
                </div>

                @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror

                <button type="button" id="reset-btn" class="h-12 w-full rounded-full bg-brand text-white font-medium shadow-sm hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 transition-all duration-300 ease-in-out relative overflow-hidden">
                    <span class="relative z-10">Send Reset Link</span>
                </button>

                <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 text-sm text-gray-600 hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path d="M15 18l-6-6 6-6"/></svg>
                    Back to Login
                </a>

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
        // Initialize countdown timer
        let countdown = 0;
        let countdownInterval = null;

        // Check for throttle data from the server
        const throttleSeconds = {{ $errors->has('throttle') ? json_encode(max(0, round($errors->first('throttle')))) : 0 }};

        const form = document.getElementById('forgot-password-form');
        const emailInput = document.getElementById('email');
        const resetButton = document.getElementById('reset-btn');

        function startCountdown(seconds) {
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }

            countdown = seconds;
            if (seconds > 0) {
                resetButton.textContent = `Resend in ${seconds}s`;
                resetButton.disabled = true;
                resetButton.classList.add('opacity-50', 'cursor-not-allowed');
                countdownInterval = setInterval(() => {
                    countdown--;
                    resetButton.textContent = `Resend in ${countdown}s`;
                    if (countdown <= 0) {
                        clearInterval(countdownInterval);
                        resetButton.textContent = 'Send Reset Link';
                        resetButton.disabled = false;
                        resetButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                }, 1000);
            } else {
                resetButton.textContent = 'Send Reset Link';
                resetButton.disabled = false;
                resetButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        resetButton.addEventListener('click', function (e) {
            e.preventDefault();

            // Set preloader state
            resetButton.innerHTML = `
                <span class="flex items-center justify-center gap-2 z-10 relative">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span>Processing...</span>
                </span>
            `;
            resetButton.disabled = true;
            resetButton.classList.add('opacity-50', 'cursor-not-allowed');

            // Submit form after a slight delay to show preloader
            setTimeout(() => {
                form.submit();
            }, 500);
        });

        // Initialize countdown and button state
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
