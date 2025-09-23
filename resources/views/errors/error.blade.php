<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'Error ' . ($code ?? '500') }} - {{ config('app.name') }}</title>

        <meta name="description" content="{{ seo_settings()?->meta_description ?? 'Master web development with our online courses.' }}">
        <meta name="keywords" content="{{ seo_settings()?->meta_keywords ?? 'online learning, web development, e-learning' }}">
        <meta name="robots" content="{{ seo_settings()?->robots ?? 'index,follow' }}">

        <!-- Open Graph Meta Tags -->
        <meta property="og:title" content="{{ seo_settings()?->og_title ?? seo_settings()?->meta_title ?? ($title . ' | ' . (site_settings()->site_name ?? config('app.name'))) }}">
        <meta property="og:description" content="{{ seo_settings()?->og_description ?? seo_settings()?->meta_description ?? 'Join our online learning platform to master web development.' }}">
        <meta property="og:image" content="{{ seo_settings()?->seo_image ? asset(seo_settings()->seo_image) : asset('assets/images/default-og-image.jpg') }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">

        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="{{ seo_settings()?->twitter_card ?? 'summary_large_image' }}">
        <meta name="twitter:title" content="{{ seo_settings()?->og_title ?? seo_settings()?->meta_title ?? ($title . ' | ' . (site_settings()->site_name ?? config('app.name'))) }}">
        <meta name="twitter:description" content="{{ seo_settings()?->og_description ?? seo_settings()?->meta_description ?? 'Join our online learning platform to master web development.' }}">
        <meta name="twitter:image" content="{{ seo_settings()?->seo_image ? asset(seo_settings()->seo_image) : asset('assets/images/default-og-image.jpg') }}">

        <!-- Tailwind CSS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Unicons -->
        <link href="{{ asset('dashboard_assets/libs/%40iconscout/unicons/css/line.css') }}" type="text/css" rel="stylesheet">

        <!-- Custom Styles -->
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

            body {
                font-family: 'Inter', sans-serif;
                background: white;
            }

            .accent-color {
                color: #E68815;
            }

            .accent-bg {
                background: #E68815;
            }

            .accent-border {
                border-color: #E68815;
            }

            /* Error Code Specific Colors */
            .error-400 {
                background: linear-gradient(135deg, #E68815 0%, #dc2626 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .error-401 {
                background: linear-gradient(135deg, #E68815 0%, #dc2626 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .error-403 {
                background: linear-gradient(135deg, #E68815 0%, #dc2626 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .error-404 {
                background: linear-gradient(135deg, #E68815 0%, #dc2626 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .error-419 {
                background: linear-gradient(135deg, #E68815 0%, #dc2626 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .error-422 {
                background: linear-gradient(135deg, #E68815 0%, #dc2626 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .error-429 {
                background: linear-gradient(135deg, #E68815 0%, #dc2626 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .error-500 {
                background: linear-gradient(135deg, #E68815 0%, #dc2626 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .error-503 {
                background: linear-gradient(135deg, #E68815 0%, #dc2626 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            /* Icon background colors */
            .icon-400 { background: #fef3c7; }
            .icon-401 { background: #f5f3ff; }
            .icon-403 { background: #eff6ff; }
            .icon-404 { background: #fff7ed; }
            .icon-419 { background: #f0fdf4; }
            .icon-422 { background: #fef2f2; }
            .icon-429 { background: #faf5ff; }
            .icon-500 { background: #fef2f2; }
            .icon-503 { background: #f5f3ff; }

            /* Responsive Design */
            @media (max-width: 768px) {
                .error-code {
                    font-size: 6rem;
                }

                .error-title {
                    font-size: 1.5rem;
                }

                .error-description {
                    font-size: 0.875rem;
                }
            }

            /* Maintenance Mode Specific Styling */
            .maintenance-end {
                color: #4b5563;
                font-weight: 500;
                font-size: 0.9rem;
                background: #f5f3ff;
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                display: inline-block;
            }
        </style>
    </head>

    <body>
        <div class="min-h-screen flex items-center justify-center p-4 md:p-8">
            <div class="p-8 md:p-12 max-w-2xl w-full">
                <div class="text-center">
                    <!-- Error Code -->
                    <div class="mb-8">
                        @php
                            $errorCode = $code ?? 500;
                            $errorClass = "error-$errorCode";
                        @endphp

                        <h1 class="error-code text-8xl md:text-9xl font-black {{ $errorClass }}">
                            {{ $errorCode }}
                        </h1>
                    </div>

                    <!-- Error Icon -->
                    <div class="mb-6">
                        @php
                            $icon = match($errorCode) {
                                400 => 'uil-exclamation-circle',
                                401 => 'uil-user-exclamation',
                                403 => 'uil-lock',
                                404 => 'uil-search',
                                419 => 'uil-shield-exclamation',
                                422 => 'uil-clipboard-alt',
                                429 => 'uil-clock',
                                500 => 'uil-server-network-alt',
                                503 => 'uil-constructor',
                                default => 'uil-exclamation-triangle'
                            };
                            $iconBg = "icon-$errorCode";
                        @endphp

                        <div class="inline-block p-5 {{ $iconBg }} rounded-full">
                            <i class="{{ $icon }} text-3xl md:text-4xl accent-color"></i>
                        </div>
                    </div>

                    <!-- Error Title -->
                    <h2 class="error-title text-2xl md:text-3xl font-bold text-gray-800 mb-4">
                        @if(isset($title))
                            {{ $title }}
                        @else
                            @switch($errorCode)
                                @case(400)
                                    Bad Request
                                    @break
                                @case(401)
                                    Unauthorized Access
                                    @break
                                @case(403)
                                    Access Forbidden
                                    @break
                                @case(404)
                                    Page Not Found
                                    @break
                                @case(419)
                                    Session Expired
                                    @break
                                @case(422)
                                    Unprocessable Entity
                                    @break
                                @case(429)
                                    Too Many Requests
                                    @break
                                @case(500)
                                    Internal Server Error
                                    @break
                                @case(503)
                                    Service Unavailable
                                    @break
                                @default
                                    Something Went Wrong
                            @endswitch
                        @endif
                    </h2>

                    <!-- Error Description -->
                    <p class="error-description text-base md:text-lg text-gray-600 mb-8 max-w-lg mx-auto leading-relaxed">
                        @if(isset($message))
                            {{ $message }}
                        @else
                            @switch($errorCode)
                                @case(400)
                                    The request could not be understood due to malformed syntax.
                                    @break
                                @case(401)
                                    You need to be authenticated to access this resource.
                                    @break
                                @case(403)
                                    You don't have permission to access this resource.
                                    @break
                                @case(404)
                                    The page you're looking for could not be found.
                                    @break
                                @case(419)
                                    Your session has expired for security reasons.
                                    @break
                                @case(422)
                                    There were validation errors in your request.
                                    @break
                                @case(429)
                                    Too many requests. Please try again later.
                                    @break
                                @case(500)
                                    Our server encountered an unexpected error.
                                    @break
                                @case(503)
                                    The service is temporarily unavailable due to scheduled maintenance. We’ll be back soon!
                                    @break
                                @default
                                    An unexpected error occurred.
                            @endswitch
                        @endif
                    </p>

                    <!-- Maintenance Mode Specific Information -->
                    @if($errorCode == 503 && isset($maintenance_end))
                        <p class="maintenance-end mb-8">
                            <span id="countdown" class="font-mono"></span>
                        </p>
                        <script>
                            // Initialize countdown timer for maintenance mode
                            function startCountdown(secondsRemaining) {
                                const countdownElement = document.getElementById('countdown');
                                if (!countdownElement || !secondsRemaining) return;

                                let timeLeft = parseFloat(secondsRemaining);

                                const updateCountdown = () => {
                                    if (timeLeft <= 0) {
                                        countdownElement.textContent = 'Maintenance has ended. Please refresh the page.';
                                        return;
                                    }

                                    const days = Math.floor(timeLeft / (60 * 60 * 24));
                                    const hours = Math.floor((timeLeft % (60 * 60 * 24)) / (60 * 60));
                                    const minutes = Math.floor((timeLeft % (60 * 60)) / 60);
                                    const seconds = Math.floor(timeLeft % 60);

                                    countdownElement.textContent =
                                        `Maintenance ends in: ${days > 0 ? days + 'd ' : ''}` +
                                        `${hours > 0 ? hours + 'h ' : ''}` +
                                        `${minutes > 0 ? minutes + 'm ' : ''}` +
                                        `${seconds}s`;

                                    timeLeft -= 1;
                                };

                                // Update immediately and then every second
                                updateCountdown();
                                const interval = setInterval(() => {
                                    updateCountdown();
                                    if (timeLeft <= 0) {
                                        clearInterval(interval);
                                    }
                                }, 1000);
                            }

                            // Start countdown with maintenance_end duration in seconds
                            document.addEventListener('DOMContentLoaded', () => {
                                startCountdown({{ $maintenance_end }});
                            });
                        </script>
                    @elseif($errorCode == 503)
                        <p class="maintenance-end mb-8">
                            Expected to be back soon.
                        </p>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                        <!-- Primary Action -->
                        @if($errorCode == 419)
                            <button onclick="window.location.reload()" class="accent-bg text-white px-8 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                                <span class="flex items-center space-x-2">
                                    <i class="uil uil-refresh"></i>
                                    <span>Refresh Page</span>
                                </span>
                            </button>
                        @elseif($errorCode == 401)
                            <a href="{{ route('login') ?? '/login' }}" class="accent-bg text-white px-8 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                                <span class="flex items-center space-x-2">
                                    <i class="uil uil-sign-in-alt"></i>
                                    <span>Login</span>
                                </span>
                            </a>
                        @elseif($errorCode == 503)
                            <a href="/" class="accent-bg text-white px-8 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                                <span class="flex items-center space-x-2">
                                    <i class="uil uil-house-user"></i>
                                    <span>Go Home</span>
                                </span>
                            </a>
                        @else
                            <a href="/" class="accent-bg text-white px-8 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                                <span class="flex items-center space-x-2">
                                    <i class="uil uil-house-user"></i>
                                    <span>Go Home</span>
                                </span>
                            </a>
                        @endif

                        <!-- Secondary Action -->
                        <button onclick="history.back()" class="bg-gray-100 text-gray-700 px-8 py-3 rounded-lg font-semibold shadow-md hover:bg-gray-200 hover:shadow-lg transition-all duration-200">
                            <span class="flex items-center space-x-2">
                                <i class="uil uil-arrow-left"></i>
                                <span>Go Back</span>
                            </span>
                        </button>
                    </div>

                    <!-- Footer Info -->
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <p class="text-sm text-gray-500 mb-2">
                            Error Code: <span class="font-mono accent-color font-medium">{{ $errorCode }}</span>
                        </p>
                        <p class="text-xs text-gray-400">
                            If this problem persists, please contact our support team.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
