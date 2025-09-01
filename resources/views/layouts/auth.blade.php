
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

        <!-- SEO Meta Tags -->
        <title>{{ $title . ' | ' . (site_settings()->site_name ?? config('app.name')) ?? (seo_settings()?->meta_title ?? 'Default Site Title') }}</title>
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

        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/iziToast.min.css') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')
    </head>
    <body class="bg-white text-neutral-900">
        <div class="min-h-screen grid md:grid-cols-2">
            <!--Page body-->
            @yield('content')
        </div>

        <!-- Page Level js -->
        <script src="{{ asset('assets/js/iziToast.min.js') }}"></script>

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
