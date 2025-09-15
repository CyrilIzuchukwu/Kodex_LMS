@extends('layouts.instructor')
@section('content')
    <div class="">
        <h1 class="text-[#1B1B1B] text-xl font-semibold">Welcome back, <span>{{ auth()->user()->name }} <span class="text-2xl text-gray-300">&#x1F44B;</span></span></h1>
        <p class="text-[#848484] font-[16px]">You're logged in to the {{ site_settings()->site_name ?? config('app.name') }} Control Center.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6 px-0 sm:px-0 lg:px-0">



    </div>
@endsection


