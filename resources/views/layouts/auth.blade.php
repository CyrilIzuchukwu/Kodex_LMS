
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- SEO Meta Tags -->
        <title>{{ $title }} | {{ config('app.name') }}</title>

        <link rel="stylesheet" href="{{ asset('assets/css/iziToast.min.css') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
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
