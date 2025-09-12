@extends('layouts.user')
@section('content')
    @php
        $name = explode(' ', auth()->user()->name, 2);
        $user_name = $name[0];
    @endphp

    <div class="px-2 md:px-6">
        <div class="w-full custom-bg items-center rounded-2xl flex justify-between px-6 py-10 md:py-16 relative overflow-hidden">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/20 z-0"></div>
            <div class="relative z-50">
                <h1 class="text-white text-xl font-semibold">Welcome back {{ ucfirst($user_name) }} 👋🏻</h1>
                <p class="text-white font-[16px]">Every lesson brings you closer to your goal 🚀</p>
            </div>
            <div class="absolute right-2 z-10">
                <img class="opacity-40 md:opacity-100" src="{{ asset('dashboard_assets/images/img/undraw.png') }}" alt="undraw">
            </div>
        </div>

        <div class="mt-10">
            @if($myLearning->count())
                <!-- Continue Your Journey Section -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6">
                    <div class="mb-4 sm:mb-0">
                        <h3 class="text-xl font-bold text-gray-800">Continue Your Learning Journey</h3>
                        <p class="text-sm text-gray-600 mt-1">Track your learning progress and continue your courses</p>
                    </div>
                    <a href="{{ route('user.my.learning') }}" class="text-[#E68815] hover:text-[#d47a12] font-medium text-sm flex items-center space-x-1 transition-colors">
                        <span>View All Courses</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($myLearning as $purchase)
                        <div class="bg-white border border-[#D9D9D9] rounded-2xl p-6 shadow-inner transition-transform hover:scale-[1.02] duration-300">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    @if(empty($purchase->course->video_url))
                                        <img src="{{ $purchase->course->media->image_url }}" alt="{{ $purchase->course->title }}" class="w-full h-full object-cover">
                                    @else
                                        <a class="block relative w-full h-full glightbox" href="{{ $purchase->course->video_url }}" data-glightbox="type: video; width: 900px;" data-gallery="video">
                                            <img src="{{ $purchase->course->media->image_url }}" alt="{{ $purchase->course->title }}" class="w-full h-full object-cover">
                                            <div class="absolute flex items-center justify-center top-0 left-0 w-full h-full z-10 text-white hover-effect-target">
                                            <span class="bg-white text-gray-900 rounded-full flex items-center justify-center w-8 h-8">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.2A1 1 0 0010 9.8v4.4a1 1 0 001.555.832l3.197-2.2a1 1 0 000-1.664z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </span>
                                            </div>
                                            <span class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-30 z-[5]"></span>
                                        </a>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h2 class="text-lg text-black font-semibold mb-1 line-clamp-2">
                                        <a href="{{ route('user.course.watch', ['slug' => $purchase->course->slug, 'module' => $purchase->module_id]) }}">{{ $purchase->course->title }}</a>
                                    </h2>
                                    <p class="text-sm text-[#A6A6A6] font-medium">
                                        by {{ $purchase->course->profile?->user->name ?? 'Not Assigned' }}
                                    </p>
                                </div>
                            </div>

                            <div class="mb-3 relative">
                                <div class="h-1.5 bg-[#D9D9D9] rounded-full overflow-hidden" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ round($purchase->progress) ?? 0 }}" aria-label="Course progress: {{ round($purchase->progress) ?? 0 }}% complete">
                                    <div class="h-full bg-[#E68815] transition-all duration-300" style="width: {{ round($purchase->progress) ?? 0 }}%"></div>
                                </div>
                                <span class="absolute top-[-20px] right-0 text-xs text-[#E68815] font-medium">{{ round($purchase->progress) ?? 0 }}% Complete</span>
                            </div>

                            <div class="flex items-center justify-between gap-4 mb-4 text-sm text-[#A6A6A6]">
                                <div class="flex justify-center gap-1">
                                    <i class="mdi mdi-book-open-blank-variant-outline w-4 h-4"></i>
                                    <span>{{ $purchase->lessons_completed ?? 0 }}/{{ $purchase->course->modules_count ?? 0 }} Lessons</span>
                                </div>
                                <div class="flex justify-center gap-1">
                                    <i class="mdi mdi-clock-time-eight-outline w-4 h-4"></i>
                                    <span>Last Accessed: {{ $purchase->last_accessed ? $purchase->last_accessed->diffForHumans() : 'Not started' }}</span>
                                </div>
                            </div>

                            <div class="flex justify-start">
                                <a href="{{ route('user.course.watch', ['slug' => $purchase->course->slug, 'module' => $purchase->module_id]) }}" class="text-[#E68815] font-medium hover:underline focus:underline outline-none flex items-center gap-1.5">
                                    {{ (round($purchase->progress) > 0 || $purchase->last_accessed !== null) ? 'Resume Course' : 'Start Learning' }} →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Available Courses Section -->
            <div class="mt-7">
                @if($courses->count())
                    <!-- Available Courses Section -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                        <div class="mb-4 sm:mb-0">
                            <h3 class="text-xl font-semibold text-[#000000]">Discover New Courses</h3>
                            <p class="text-sm text-gray-600 mt-1">Explore a wide range of courses tailored to boost your skills and career.</p>
                        </div>
                        <a href="{{ route('user.courses') }}" class="text-[#E68815] hover:text-[#d47a12] font-medium text-sm flex items-center space-x-1 transition-colors">
                            <span>View All Courses</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @include('user.courses.course-items', ['courses' => $courses])
                    </section>
                @else
                    <section class="flex items-center justify-center min-h-[35vh]">
                        <div class="p-8 max-w-md text-center">
                            <div class="w-16 h-16 rounded-full bg-[#F5CE9F] flex items-center justify-center mb-6 mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-[#8C530D]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12h.01M12 16h.01" />
                                </svg>
                            </div>
                            <h2 class="font-[400] text-[#444444] text-[20px] mb-4">No Courses Uploaded</h2>
                            <p class="text-[14px] text-[#1B1B1B] mb-6">No courses have been uploaded yet. Please check back later for new course offerings.</p>
                        </div>
                    </section>
                @endif
            </div>
        </div>
    </div>
@endsection

<style>
    .custom-bg {
        background: linear-gradient(90deg, #804C0C 0%, #E68815 100%);
    }
</style>
