@extends('layouts.user')
@section('content')
    <!-- Breadcrumb Navigation -->
    <div class="mb-6">
        <nav class="bg-white rounded-[20px] md:rounded-[30px] shadow-sm px-4 md:px-6 py-3 flex items-center justify-start w-full">
            <ol class="flex items-center space-x-2 md:space-x-3 text-sm md:text-base font-medium text-[#141B34]">
                <li>
                    <a href="{{ route('user.dashboard') }}" class="hover:text-[#E68815] transition-colors duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-7 7v-10"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </li>
                <li>
                    <span class="text-[#E68815] font-semibold">My Certificates</span>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-2xl md:rounded-3xl border border-gray-100 overflow-hidden">
        <!-- Header Section -->
        <div class="px-4 md:px-8 py-6 md:py-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 md:gap-6">
                <div class="text-gray-900">
                    <h1 class="text-2xl md:text-3xl font-bold mb-2">My Certificates</h1>
                    <p class="text-gray-500 text-base md:text-lg">View and download your earned certificates</p>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="p-4 md:p-8" id="content-container">
            @if($certificates->count())
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-6 lg:gap-8 mb-8" id="certificates-container">
                    @foreach($certificates as $certificate)
                        <!-- Certificate -->
                        <div class="group relative bg-white rounded-b-2xl md:rounded-b-3xl border-2 border-gray-100 shadow-sm w-full max-w-md mx-auto">
                            <div class="w-full h-48 md:h-64 overflow-hidden bg-cover bg-center bg-no-repeat relative aspect-w-16 aspect-h-9">
                                <img class="w-full h-full object-cover object-center" src="{{ asset($certificate->thumbnail_path) }}" alt="{{ $certificate->course->title }} Certificate" loading="lazy">
                            </div>

                            <!-- Certificate Information -->
                            <div class="p-4 md:p-5">
                                <!-- Certificate ID -->
                                <div class="mb-3">
                                    <p class="text-xs md:text-sm font-mono bg-gray-50 text-gray-700 px-2 md:px-3 py-1 rounded-lg border truncate">{{ $certificate->certificate_id }}</p>
                                </div>

                                <!-- Course Title -->
                                <div class="mb-3">
                                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Course Title</span>
                                    <h3 class="text-base md:text-lg font-bold text-gray-800 mt-1 line-clamp-2 leading-tight">{{ $certificate->course->title }}</h3>
                                </div>

                                <!-- Date Earned -->
                                <div class="mb-4">
                                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Date Earned</span>
                                    <div class="flex items-center mt-1">
                                        <svg class="w-4 h-4 text-[#E68815] mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-sm font-semibold text-gray-700">{{ $certificate->enrollment->updated_at->format('M j, Y') }}</p>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                                    <a href="{{ route('user.course.certificate.download', $certificate->course_id) }}" class="flex-1 bg-brand hover:bg-[#d67a13] text-white px-3 py-2 rounded-xl font-semibold shadow-md transition-all duration-200 text-center text-sm">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download
                                    </a>

                                    <a href="{{ asset($certificate->certificate_path) }}" target="_blank" class="flex-1 px-3 py-2 border-2 border-gray-200 hover:border-[#E68815] text-gray-600 hover:text-[#E68815] rounded-xl font-semibold transition-all duration-200 text-center text-sm">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span class="sm:inline">View</span>
                                        <span class="sm:hidden">Preview</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="col-span-full">
                    <section class="flex items-center justify-center min-h-[50vh] bg-white rounded-[20px] md:rounded-[30px] ">
                        <!-- Empty State -->
                        <div class="flex flex-col items-center justify-center py-12 sm:py-10 bg-white rounded-[20px] md:rounded-[30px] shadow-sm">
                            <div class="relative mb-6 sm:mb-8">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl bg-[#E68815] flex items-center justify-center">
                                    <svg class="w-10 h-10 sm:w-12 sm:h-12 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                </div>
                                <div class="absolute -top-2 -right-2 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-yellow-400 to-orange-400 flex items-center justify-center">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-gray-700 mb-4 text-center">No Certificates Earned Yet</h2>
                            <p class="text-gray-500 text-base sm:text-lg text-center max-w-xs sm:max-w-md mb-6 sm:mb-8 px-4">
                                You haven't earned any certificates yet. Complete courses to earn your certificates!
                            </p>
                            <a href="{{ route('user.course.my.learning') }}" class="inline-block bg-[#E68815] hover:bg-[#ffad48] text-white py-3 px-8 rounded-[100px] font-semibold text-base transition-colors shadow-sm hover:shadow-md">Learning Journey</a>
                        </div>
                    </section>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Additional styles for better mobile experience */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Ensure proper spacing on very small screens */
        @media (max-width: 320px) {
            .grid {
                gap: 0.75rem;
            }

            .px-4 {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
        }
    </style>
@endpush
