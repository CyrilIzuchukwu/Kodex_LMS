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

        <div class="mt-6">
            <!-- Continue Your Journey Section -->
            <div class="flex justify-between items-center mb-4">
                <p class="text-[#000000] text-xl font-medium">Continue Your Journey</p>
                <a href="{{ route('user.my.learning') }}" class="text-[#E68815] font-medium text-sm hover:underline">View More</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-[#ffffff] border border-[#D9D9D9] rounded-2xl p-6 shadow-inner">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0">
                            <img src="{{ asset('dashboard_assets/images/img/aws.png') }}" alt="aws">
                        </div>
                        <div class="flex-1 min-w-0">
                            <h2 class="text-lg text-black font-semibold mb-1">Cloud Computing with AWS and DevOps Basics</h2>
                            <p class="text-sm text-[#A6A6A6] font-medium">by Prince Nuel</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="h-2 bg-[#D9D9D9] rounded-full overflow-hidden" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="45" aria-label="Course progress: 45% complete">
                            <div class="h-full bg-[#D97706] transition-all duration-300" style="width: 45%"></div>
                        </div>
                    </div>

                    <div class="flex items-center justify-center gap-4 mb-4 text-sm text-[#A6A6A6]">
                        <div class="flex justify-center gap-1">
                            <i class="mdi mdi-book-open-blank-variant-outline w-4 h-4"></i>
                            <span>16/40 Lessons</span>
                        </div>
                        <div class="flex justify-center gap-1">
                            <i class="mdi mdi-clock-time-eight-outline w-4 h-4"></i>
                            <span>20 hours left</span>
                        </div>
                    </div>

                    <div class="flex justify-start">
                        <a href="#" class="text-[#8C530D] font-medium hover:underline focus:underline outline-none">
                            Resume Course →
                        </a>
                    </div>
                </div>

                <div class="bg-[#ffffff] border border-[#D9D9D9] rounded-2xl p-6 shadow-inner">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0">
                            <img src="{{ asset('dashboard_assets/images/img/ui.png') }}" alt="ui">
                        </div>
                        <div class="flex-1 min-w-0">
                            <h2 class="text-lg text-black font-semibold mb-1">UI/UX Design Fundamentals for Beginners</h2>
                            <p class="text-sm text-[#A6A6A6] font-medium">by Ejike Mike</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="h-2 bg-[#D9D9D9] rounded-full overflow-hidden" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="45" aria-label="Course progress: 45% complete">
                            <div class="h-full bg-[#D97706] transition-all duration-300" style="width: 45%"></div>
                        </div>
                    </div>

                    <div class="flex items-center justify-center gap-4 mb-4 text-sm text-[#A6A6A6]">
                        <div class="flex justify-center gap-1">
                            <i class="mdi mdi-book-open-blank-variant-outline w-4 h-4"></i>
                            <span>16/40 Lessons</span>
                        </div>
                        <div class="flex justify-center gap-1">
                            <i class="mdi mdi-clock-time-eight-outline w-4 h-4"></i>
                            <span>20 hours left</span>
                        </div>
                    </div>

                    <div class="flex justify-start">
                        <a href="#" class="text-[#8C530D] font-medium hover:underline focus:underline outline-none">
                            Resume Course →
                        </a>
                    </div>
                </div>

                <div class="bg-[#ffffff] border border-[#D9D9D9] rounded-2xl p-6 shadow-inner">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0">
                            <img src="{{ asset('dashboard_assets/images/img/shop.png') }}" alt="shop">
                        </div>
                        <div class="flex-1 min-w-0">
                            <h2 class="text-lg text-black font-semibold mb-1">Adobe Photoshop Essentials for Beginners</h2>
                            <p class="text-sm text-[#A6A6A6] font-medium">by Purpose Walks</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="h-2 bg-[#D9D9D9] rounded-full overflow-hidden" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="45" aria-label="Course progress: 45% complete">
                            <div class="h-full bg-[#D97706] transition-all duration-300" style="width: 45%"></div>
                        </div>
                    </div>

                    <div class="flex items-center justify-center gap-4 mb-4 text-sm text-[#A6A6A6]">
                        <div class="flex justify-center gap-1">
                            <i class="mdi mdi-book-open-blank-variant-outline w-4 h-4"></i>
                            <span>16/40 Lessons</span>
                        </div>
                        <div class="flex justify-center gap-1">
                            <i class="mdi mdi-clock-time-eight-outline w-4 h-4"></i>
                            <span>20 hours left</span>
                        </div>
                    </div>

                    <div class="flex justify-start">
                        <a href="#" class="text-[#8C530D] font-medium hover:underline focus:underline outline-none">
                            Resume Course →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Available Courses Section -->
            <div class="mt-7">
                @if($courses->count())
                    <div class="flex justify-between items-center mb-4">
                        <p class="text-[#000000] text-xl font-medium">Available Courses</p>
                        <a href="{{ route('user.courses') }}" class="text-[#E68815] font-medium text-sm hover:underline">View More</a>
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
