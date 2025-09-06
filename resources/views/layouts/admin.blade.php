<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light scroll-smooth" dir="ltr">

<head>
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- SEO Meta Tags -->
    <title>
        {{ $title . ' | ' . (site_settings()->site_name ?? config('app.name')) ?? (seo_settings()?->meta_title ?? 'Default Site Title') }}
    </title>
    <meta name="description"
        content="{{ seo_settings()?->meta_description ?? 'Master web development with our online courses.' }}">
    <meta name="keywords"
        content="{{ seo_settings()?->meta_keywords ?? 'online learning, web development, e-learning' }}">
    <meta name="robots" content="{{ seo_settings()?->robots ?? 'index,follow' }}">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title"
        content="{{ seo_settings()?->og_title ?? (seo_settings()?->meta_title ?? $title . ' | ' . (site_settings()->site_name ?? config('app.name'))) }}">
    <meta property="og:description"
        content="{{ seo_settings()?->og_description ?? (seo_settings()?->meta_description ?? 'Join our online learning platform to master web development.') }}">
    <meta property="og:image"
        content="{{ seo_settings()?->seo_image ? asset(seo_settings()->seo_image) : asset('assets/images/default-og-image.jpg') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="{{ seo_settings()?->twitter_card ?? 'summary_large_image' }}">
    <meta name="twitter:title"
        content="{{ seo_settings()?->og_title ?? (seo_settings()?->meta_title ?? $title . ' | ' . (site_settings()->site_name ?? config('app.name'))) }}">
    <meta name="twitter:description"
        content="{{ seo_settings()?->og_description ?? (seo_settings()?->meta_description ?? 'Join our online learning platform to master web development.') }}">
    <meta name="twitter:image"
        content="{{ seo_settings()?->seo_image ? asset(seo_settings()->seo_image) : asset('assets/images/default-og-image.jpg') }}">

    <!-- CSS -->
    <link href="{{ asset('dashboard_assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard_assets/libs/%40iconscout/unicons/css/line.css') }}" type="text/css"
        rel="stylesheet">
    <link href="{{ asset('dashboard_assets/libs/%40mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet"
        type="text/css">
    <link rel="stylesheet" href="{{ asset('dashboard_assets/css/tailwind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard_assets/css/quill.snow.css') }}">

    {{-- huge icon   --}}
    <link rel="stylesheet" href="{{ asset('dashboard_assets/css/huge-icon.css') }}">
    <link rel="stylesheet" href="https://use.hugeicons.com/font/icons.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="font-nunito text-base text-slate-900 dark:text-white">
    <!-- Loader -->
    @include('partials.admin.loader')

    <div class="page-wrapper toggled">
        <!-- Sidebar -->
        @include('partials.admin.sidebar')

        <!-- Start Page Content -->
        <main class="page-content bg-[#F9F8F7] dark:bg-slate-800">
            <!-- Top Header -->
            @include('partials.admin.topbar')

            <div class="container-fluid relative px-3 bg-[#F9F8F7] ">
                <div class="layout-specing">
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            @include('partials.admin.footer')
        </main>
    </div>

    @include('partials.modals')

    <!-- Scripts -->
    @include('partials.admin.scripts')

    <!-- Scripts -->
    @stack('scripts')

    <!-- Sessions Message -->
    @include('partials.message')

    <script>
        const iziToastSettings = {
            position: "topRight",
            timeout: 5000,
            resetOnHover: true,
            transitionIn: "flipInX",
            transitionOut: "flipOutX"
        };
    </script>
</body>

</html>
