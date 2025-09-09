@extends('layouts.user')
@section('content')
    <div class="space-y-12 px-1 md:px-6 lg:px-12">
        <!-- Hero Section -->
        <div class="custom-bg2 p-8 sm:p-12 md:p-16 rounded-[30px]">
            <h1 class="text-white text-3xl sm:text-4xl lg:text-5xl font-semibold max-w-3xl leading-tight sm:leading-snug">
                {{ $course->title }}
            </h1>

            <p class="text-white text-base sm:text-lg lg:text-xl font-normal max-w-3xl mt-4 mb-8">
                {{ $course->subtitle }}
            </p>

            <div class="space-y-6">
                <h2 class="text-lg sm:text-xl font-semibold text-white">Skills You'll Gain</h2>
                <div class="flex flex-wrap gap-3 sm:gap-4">
                    @foreach($course_outcomes->take(6) as $outcome)
                        <div class="px-4 py-2.5 bg-white text-slate-900 rounded-full font-medium text-sm sm:text-base hover:scale-105 transition-transform duration-200 cursor-pointer shadow-sm hover:bg-gray-200">
                            {{ $outcome->outcome }}
                        </div>
                    @endforeach

                    @if($course_outcomes->count() > 6)
                        <div class="px-4 py-2.5 bg-white text-slate-900 rounded-full font-medium text-sm sm:text-base hover:scale-105 transition-transform duration-200 cursor-pointer shadow-sm hover:bg-gray-200">
                            +{{ $course_outcomes->count() - 6 }} More Skills
                        </div>
                    @endif
                </div>

                <div class="pt-6">
                    <button id="add-to-cart" class="inline-flex items-center justify-center bg-[#E68815] hover:bg-[#ffad48] text-white text-base sm:text-lg font-semibold px-8 py-4 rounded-[100px] shadow-lg hover:shadow-xl transition-all duration-300 w-full sm:w-auto" data-course="{{ $course->id }}">
                        <svg class="uil-shopping-cart w-7 h-7 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>

        <!-- Course Includes -->
        <div>
            <h2 class="text-[#1B1B1B] text-xl sm:text-2xl font-semibold mb-6">This Course Includes</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white border border-[#D9D9D9] rounded-2xl p-5 flex items-start hover:scale-[1.02] transition-transform duration-200 cursor-pointer shadow-sm hover:bg-gray-50">
                    <img src="{{ asset('dashboard_assets/images/img/pdf.png') }}" alt="pdf" class="w-10 h-10 sm:w-12 sm:h-12">
                    <div class="ml-4">
                        <h3 class="text-base sm:text-lg font-semibold text-[#1B1B1B] mb-2">Downloadable Resources</h3>
                        <p class="text-sm text-[#767676]">Access templates, guides, and materials anytime.</p>
                    </div>
                </div>
                <div class="bg-white border border-[#D9D9D9] rounded-2xl p-5 flex items-start hover:scale-[1.02] transition-transform duration-200 cursor-pointer shadow-sm hover:bg-gray-50">
                    <img src="{{ asset('dashboard_assets/images/img/mod.png') }}" alt="mod" class="w-10 h-10 sm:w-12 sm:h-12">
                    <div class="ml-4">
                        <h3 class="text-base sm:text-lg font-semibold text-[#1B1B1B] mb-2">{{ $course->modules_count }} Modules</h3>
                        <p class="text-sm text-[#767676]">Step-by-step modules for guided learning.</p>
                    </div>
                </div>
                <div class="bg-white border border-[#D9D9D9] rounded-2xl p-5 flex items-start hover:scale-[1.02] transition-transform duration-200 cursor-pointer shadow-sm hover:bg-gray-50">
                    <img src="{{ asset('dashboard_assets/images/img/cert.png') }}" alt="cert" class="w-10 h-10 sm:w-12 sm:h-12">
                    <div class="ml-4">
                        <h3 class="text-base sm:text-lg font-semibold text-[#1B1B1B] mb-2">Certificate</h3>
                        <p class="text-sm text-[#767676]">Shareable certificate on completion.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Description -->
        <div>
            <h2 class="text-[#1B1B1B] text-xl sm:text-2xl font-semibold mb-6">Course Description</h2>
            <div class="text-[#1B1B1B] text-base max-w-4xl leading-relaxed mb-8">
                {!! $course->summary !!}
            </div>
            <h2 class="text-[#1B1B1B] text-xl sm:text-2xl font-semibold mb-6">What You Will Learn</h2>
            <ul class="list-disc pl-6 space-y-3 text-base text-[#1B1B1B]">
                @foreach($course_outcomes as $outcome)
                    <li>{{ $outcome->outcome }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Course Modules -->
        <div>
            <h2 class="text-[#1B1B1B] text-xl sm:text-2xl font-semibold mb-6">Course Modules</h2>
            <div class="space-y-4">
                @foreach($course_modules as $index => $module)
                    <div class="bg-white border border-[#D9D9D9] rounded-2xl p-4 sm:p-5 flex items-center hover:scale-[1.02] transition-transform duration-200 cursor-pointer shadow-sm hover:bg-gray-50">
                        <div class="bg-[#E68815] w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center text-white">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 006 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"></path>
                            </svg>
                        </div>
                        <div class="ml-3 sm:ml-4">
                            <h3 class="text-base sm:text-lg font-semibold text-[#1B1B1B] mb-1">Module {{ $index + 1 }}</h3>
                            <p class="text-sm text-[#1B1B1B]">{{ $module->title }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Instructor -->
        <div>
            <h2 class="text-[#1B1B1B] text-xl sm:text-2xl font-semibold mb-6">Instructor</h2>
            <div class="flex items-center gap-4 mb-4">
                <img src="{{ $course->profile && $course->profile->profile_photo_path ? asset($course->profile->profile_photo_path) : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($course->profile?->user->name ?? 'N', 0, 1) }}" alt="{{ $course->profile?->user->name ?? 'Not Assigned' }}" class="w-16 h-16 sm:w-20 sm:h-20 rounded-full">
                <div>
                    <h3 class="text-lg sm:text-xl font-semibold text-[#A15F0F]">{{ $course->profile?->user->name ?? 'Not Assigned' }}</h3>
                    <p class="text-sm text-[#1B1B1B]">{{ $course->profile->course?->title ?? 'Not Assigned' }}</p>
                </div>
            </div>
            <p class="text-base text-[#1B1B1B] max-w-4xl leading-relaxed">
                {{ $course->profile?->biography ?? 'Not Assigned' }}
            </p>
        </div>

        <!-- Related Courses -->
        @if($relatedCourses->count())
            <div>
                <h2 class="text-[#1B1B1B] text-xl sm:text-2xl font-semibold mb-6">Related Courses</h2>
                <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @include('user.courses.course-items', ['courses' => $relatedCourses])
                </section>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .custom-bg {
            background: linear-gradient(90deg, #804C0C 0%, #E68815 100%);
        }

        .custom-bg2 {
            background-image: url("{{ $course->media->image_url }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-blend-mode: overlay;
            background-color: #00000099;
        }

        @media screen and (max-width: 768px) {
            .custom-bg2 {
                background-image: url("{{ $course->media->image_url }}");
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                background-blend-mode: overlay;
                background-color: #00000099;
            }
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush
