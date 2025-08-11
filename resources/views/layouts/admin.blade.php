<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light scroll-smooth" dir="ltr">

<head>
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Css -->
    <link href="{{ asset('dashboard_assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard_assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard_assets/libs/%40iconscout/unicons/css/line.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('dashboard_assets/libs/%40mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('dashboard_assets/css/tailwind.min.css') }}">

    @stack('styles')
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

    <!-- Scripts -->
    @include('partials.admin.scripts')
    @stack('scripts')
</body>
</html>
