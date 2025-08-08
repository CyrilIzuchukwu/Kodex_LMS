@extends('layouts.email-verify')
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
                    <img class="w-[80px] mt-10" src="{{ asset('assets/auth/envelope.png') }}" alt="envelope">
                </div>

                <h1 class="mt-4 text-2xl font-semibold">Enter Verification Code</h1>
                <p class="mt-1 text-sm text-neutral-500">We've sent a 4-digit code to your email.</p>
            </header>

            <form class="space-y-6" action="{{ route('email.verify.store') }}" method="POST" id="verify-form">
                @csrf

                <!-- Hidden input to store combined OTP -->
                <input type="hidden" name="otp" id="otp-hidden">

                <!-- OTP inputs -->
                <div class="flex items-center justify-center gap-6" role="group" aria-label="Enter 4-digit code">
                    <input aria-label="Digit 1" data-otp inputmode="numeric" pattern="[0-9]*" maxlength="1" class="w-10 h-10 bg-transparent text-center text-lg border-0 border-b border-neutral-400 focus:outline-none focus:border-brand focus:ring-0" />
                    <input aria-label="Digit 2" data-otp inputmode="numeric" pattern="[0-9]*" maxlength="1" class="w-10 h-10 bg-transparent text-center text-lg border-0 border-b border-neutral-400 focus:outline-none focus:border-brand focus:ring-0" />
                    <input aria-label="Digit 3" data-otp inputmode="numeric" pattern="[0-9]*" maxlength="1" class="w-10 h-10 bg-transparent text-center text-lg border-0 border-b border-neutral-400 focus:outline-none focus:border-brand focus:ring-0" />
                    <input aria-label="Digit 4" data-otp inputmode="numeric" pattern="[0-9]*" maxlength="1" class="w-10 h-10 bg-transparent text-center text-lg border-0 border-b border-neutral-400 focus:outline-none focus:border-brand focus:ring-0" />
                </div>

                @error('otp')
                <p class="mt-1 text-sm text-red-500 text-center">{{ $message }}</p>
                @enderror

                <div class="flex justify-center">
                    <button type="submit" id="verify-btn" class="h-12 w-[14.5rem] rounded-full bg-brand text-white font-medium shadow-sm hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 transition-all duration-300 ease-in-out relative overflow-hidden">
                        <span class="relative z-10">Verify Code</span>
                    </button>
                </div>

                <p class="text-center text-sm text-neutral-500">
                    Didn't receive the code?
                    <a href="#" class="text-brand hover:underline" id="resendOtp">Resend</a>
                </p>

                <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 text-sm text-neutral-600 hover:text-neutral-900">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path d="M15 18l-6-6 6-6"/></svg>
                    Back to Login
                </a>

                <div class="pt-2 flex justify-center gap-3" aria-hidden="true">
                    <span class="h-1 w-12 rounded-full bg-brand"></span>
                    <span class="h-1 w-12 rounded-full bg-brand"></span>
                    <span class="h-1 w-12 rounded-full bg-brand/60"></span>
                </div>
            </form>
        </article>
    </main>
@endsection

@push('scripts')
    <script>
        // OTP input handling
        const otpInputs = document.querySelectorAll('[data-otp]');
        const otpHidden = document.getElementById('otp-hidden');

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                const value = e.target.value;
                if (value.length === 1 && value.match(/[0-9]/)) {
                    if (index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                } else {
                    e.target.value = '';
                }
                updateHiddenOtp();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });

            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').replace(/\D/g, '');
                if (pastedData.length <= 4) {
                    for (let i = 0; i < pastedData.length && i < otpInputs.length; i++) {
                        otpInputs[i].value = pastedData[i];
                    }
                    if (pastedData.length < 4) {
                        otpInputs[pastedData.length].focus();
                    } else {
                        otpInputs[3].focus();
                    }
                    updateHiddenOtp();
                }
            });
        });

        function updateHiddenOtp() {
            otpHidden.value = Array.from(otpInputs).map(input => input.value).join('');
        }

        // Form submission with preloader
        document.getElementById('verify-btn').addEventListener('click', function (e) {
            e.preventDefault();
            const form = document.getElementById('verify-form');
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

            // Submit form after slight delay to show preloader
            setTimeout(() => {
                form.submit();
            }, 500);
        });

        // Resend OTP
        document.addEventListener('DOMContentLoaded', function () {
            const resendOtp = document.getElementById('resendOtp');

            if (!resendOtp) {
                return;
            }

            let url = `/email/verify/resend`;

            const element = resendOtp; // Use the available element
            const originalText = element.innerHTML;

            function startCountdown(expiryTime) {
                const interval = setInterval(() => {
                    const now = new Date().getTime();
                    const expiry = new Date(expiryTime).getTime();
                    const remainingTime = expiry - now;

                    if (remainingTime > 0) {
                        const minutes = Math.floor((remainingTime / 1000 / 60) % 60);
                        const seconds = Math.floor((remainingTime / 1000) % 60);
                        element.innerHTML = `Resend in ${minutes}m ${seconds}s`;
                        element.style.pointerEvents = 'none';
                    } else {
                        clearInterval(interval);
                        element.innerHTML = originalText;
                        element.style.pointerEvents = 'auto';
                        localStorage.removeItem('retryTime');
                    }
                }, 1000);
            }

            const storedExpiry = localStorage.getItem('retryTime');
            if (storedExpiry) {
                startCountdown(storedExpiry);
            }

            element.addEventListener('click', function (event) {
                event.preventDefault();

                element.innerHTML = 'Resending...';
                element.style.pointerEvents = 'none';

                fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            iziToast.success({ ...iziToastSettings, message: data.message });
                            localStorage.setItem('retryTime', data.retryTime);
                            startCountdown(data.retryTime);
                        } else {
                            iziToast.error({ ...iziToastSettings, message: data.message || 'Something went wrong' });
                            element.innerHTML = originalText;
                            element.style.pointerEvents = 'auto';
                        }
                    })
                    .catch(error => {
                        iziToast.error({
                            ...iziToastSettings,
                            message: error || 'An error occurred while resending OTP. Please try again.'
                        });
                        element.innerHTML = originalText;
                        element.style.pointerEvents = 'auto';
                    });
            });
        });
    </script>
@endpush
