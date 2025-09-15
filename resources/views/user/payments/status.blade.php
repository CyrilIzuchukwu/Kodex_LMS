@extends('layouts.user')
@section('content')
    <div class="min-h-screen bg-white">
        <div class="w-full px-4 sm:px-6 py-6 sm:py-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Transaction Status</h1>
                        <p class="text-gray-500 mt-1 sm:mt-2 text-sm sm:text-base">Track your payment and order details</p>
                    </div>

                    @if($retry)
                        <a href="{{ route('user.cart') }}" class="bg-[#E68815] hover:bg-[#d47a12] text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl w-full sm:w-auto">
                            <span class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                <span>Try Again</span>
                            </span>
                        </a>
                    @else
                        <a href="{{ route('user.courses') }}" class="bg-[#E68815] hover:bg-[#d47a12] text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl w-full sm:w-auto">
                            <span class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <span>Browse Courses</span>
                            </span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="px-1 sm:px-6 pb-12">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-gray-500 rounded-xl sm:rounded-2xl shadow-xl sm:shadow-2xl overflow-hidden border border-gray-200">
                            <!-- Status Header -->
                            <div class="bg-gradient-to-r
                                @if($title == 'Payment Cancelled')
                                    from-yellow-500 to-yellow-600
                                @elseif($title == 'Payment Error')
                                    from-red-500 to-red-600
                                @else
                                    from-red-500 to-red-600
                                @endif
                                p-6 sm:p-8 relative">

                                <!-- Status Icon -->
                                <div class="absolute top-0 right-0 opacity-10">
                                    @if($title == 'Payment Cancelled')
                                        <svg class="w-32 sm:w-48 lg:w-64 h-32 sm:h-48 lg:h-64" viewBox="0 0 200 200" fill="white">
                                            <circle cx="100" cy="100" r="80" stroke="white" stroke-width="8" fill="none"/>
                                            <circle cx="100" cy="100" r="8" fill="white"/>
                                            <path d="M100 60v40" stroke="white" stroke-width="6" stroke-linecap="round"/>
                                        </svg>
                                    @elseif($title == 'Payment Error')
                                        <svg class="w-32 sm:w-48 lg:w-64 h-32 sm:h-48 lg:h-64" viewBox="0 0 200 200" fill="white">
                                            <circle cx="100" cy="100" r="80" stroke="white" stroke-width="8" fill="none"/>
                                            <path d="M70 70l60 60M130 70l-60 60" stroke="white" stroke-width="8" stroke-linecap="round"/>
                                        </svg>
                                    @else
                                        <svg class="w-32 sm:w-48 lg:w-64 h-32 sm:h-48 lg:h-64" viewBox="0 0 200 200" fill="white">
                                            <circle cx="100" cy="100" r="80" stroke="white" stroke-width="8" fill="none"/>
                                            <path d="M70 70l60 60M130 70l-60 60" stroke="white" stroke-width="8" stroke-linecap="round"/>
                                        </svg>
                                    @endif
                                </div>

                                <div class="relative z-10">
                                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                                        <div>
                                            <img class="h-10 sm:h-12" src="{{ asset('dashboard_assets/images/img/Kodex.png') }}" alt="Kodex Logo">
                                        </div>

                                        <div class="text-left sm:text-right">
                                            <span class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm font-medium bg-white/20 backdrop-blur-sm text-white border border-white/30">
                                                <span class="w-2 h-2
                                                    @if($title == 'Payment Cancelled')
                                                        bg-yellow-300
                                                    @elseif($title == 'Payment Error')
                                                        bg-red-300
                                                    @else
                                                        bg-red-300
                                                    @endif rounded-full mr-2 animate-pulse"></span>
                                                {{ ucfirst($title) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Status Message -->
                                    <div class="mt-6 sm:mt-8">
                                        <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                                            {{ $title }}
                                        </h2>
                                        <p class="text-white text-sm sm:text-base opacity-90 max-w-2xl">
                                            {{ $errorMessage }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Transaction Details -->
                            <div class="p-6 sm:p-8 lg:p-10 bg-white">
                                <!-- Transaction Summary -->
                                <div class="bg-gray-100 rounded-lg sm:rounded-xl p-4 sm:p-6 mb-6 sm:mb-8 border border-gray-200">
                                    <h3 class="text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wider mb-3 sm:mb-4">Transaction Details</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                        <div>
                                            <p class="text-xs sm:text-sm text-gray-500">Student Name</p>
                                            <p class="text-base sm:text-lg font-semibold text-gray-800">{{ $payment->user->name }}</p>
                                        </div>

                                        <div>
                                            <p class="text-xs sm:text-sm text-gray-500">E-mail</p>
                                            <p class="text-base sm:text-lg font-semibold text-gray-800">{{ $payment->user->email }}</p>
                                        </div>

                                        <div>
                                            <p class="text-xs sm:text-sm text-gray-500">Phone Number</p>
                                            <p class="text-base sm:text-lg font-semibold text-gray-800 break-all">
                                                {{ $payment->user->profile->phone_number ?? 'N/A'  }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-xs sm:text-sm text-gray-500">Transaction ID</p>
                                            <p class="text-base sm:text-lg font-semibold text-gray-800">{{ $payment->transaction_reference ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Course Items -->
                                <div class="mb-6 sm:mb-8">
                                    <h3 class="text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wider mb-3 sm:mb-4">Purchase Details</h3>

                                    <!-- Mobile View -->
                                    <div class="block md:hidden space-y-3">
                                        @foreach($courses as $course)
                                            <div class="bg-gray-100 rounded-lg p-4 border-l-4
                                                @if($title == 'Payment Cancelled') border-yellow-500
                                                @elseif($title == 'Payment Error') border-red-500
                                                @else border-red-500 @endif border">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <p class="font-medium text-gray-900 mb-1">{{ $course->title }}</p>
                                                        <p class="text-xs text-gray-500 mb-2">@truncate($course->subtitle, 50)</p>
                                                        <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full text-xs border border-gray-300">{{ $course->category->name }}</span>
                                                    </div>
                                                    <div class="text-right ml-4">
                                                        <p class="font-medium text-gray-900">₦{{ number_format($course->price, 2) }}</p>
                                                        <div class="mt-1">
                                                            <span class="inline-flex items-center text-xs text-gray-600">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                                                </svg>
                                                                Locked
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Desktop View -->
                                    <div class="hidden md:block overflow-x-auto rounded-xl border border-gray-300">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th scope="col" class="px-4 lg:px-6 py-3 lg:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Course</th>
                                                    <th scope="col" class="px-4 lg:px-6 py-3 lg:py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Price</th>
                                                    <th scope="col" class="px-4 lg:px-6 py-3 lg:py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($courses as $course)
                                                    <tr>
                                                        <td class="px-4 lg:px-6 py-3 lg:py-4">
                                                            <div class="flex items-center">
                                                                <div class="w-1 h-12 rounded-full mr-3 @if($title == 'Payment Cancelled') bg-yellow-500 @elseif($title == 'Payment Error') bg-red-500 @else bg-red-500 @endif"></div>
                                                                <div>
                                                                    <p class="text-sm font-medium text-gray-900">{{ $course->title }}</p>
                                                                    <p class="text-xs text-gray-500">@truncate($course->subtitle, 50)</p>
                                                                    <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full text-xs mt-1 inline-block border border-gray-300">{{ $course->category->name }}</span>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td class="px-4 lg:px-6 py-3 lg:py-4 text-right text-sm font-medium text-gray-900">
                                                            ₦{{ number_format($course->price, 2) }}
                                                        </td>

                                                        <td class="px-4 lg:px-6 py-3 lg:py-4 text-center">
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-700 border border-gray-300">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                                                </svg>
                                                                Locked
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Payment Method Info -->
                                <div class="bg-blue-50 rounded-lg sm:rounded-xl p-4 sm:p-6 mb-6 sm:mb-8 border border-blue-200">
                                    <h3 class="text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wider mb-3 sm:mb-4">Payment Information</h3>
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                        <div class="flex items-center space-x-3 sm:space-x-4">
                                            <div class="bg-white rounded-lg p-2 sm:p-3 shadow-sm border border-gray-200">
                                                <svg class="w-6 sm:w-8 h-6 sm:h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ strtoupper($payment->payment_method) }}</p>
                                                <p class="text-xs text-gray-500">{{ strtoupper($payment->channel ?? 'N/A') }}</p>
                                            </div>
                                        </div>
                                        <div class="text-left sm:text-right">
                                            <p class="text-xs text-gray-500">Processed on</p>
                                            <p class="text-sm font-medium text-gray-900">{{ $payment->created_at->format('d M Y, h:i A') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                @if($retry)
                                    <div class="flex flex-col sm:flex-row gap-4 mb-6">
                                        <a href="{{ route('user.cart') }}" class="flex-1 bg-[#E68815] hover:bg-[#d47a12] text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 text-center shadow-lg hover:shadow-xl">
                                            Try Again
                                        </a>
                                        <a href="{{ route('user.dashboard') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-medium transition-all duration-200 text-center border border-gray-300">
                                            Go to Dashboard
                                        </a>
                                    </div>
                                @endif

                                <!-- Footer -->
                                <div class="mt-1 sm:mt-8 pt-6 sm:pt-8 border-t border-gray-200">
                                    <div class="text-center text-xs sm:text-sm text-gray-500">
                                        <p>Need help? We're here to assist you.</p>
                                        <p class="mt-2">For support, contact us at {{ site_settings()->site_email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-gradient-to-br from-purple-50 to-blue-50 rounded-xl p-4 sm:p-6 sticky top-6 border border-gray-200">
                            <div class="flex items-center justify-between mb-4 sm:mb-6">
                                <div>
                                    <h3 class="text-lg sm:text-xl font-bold text-gray-800">
                                        Explore Courses
                                    </h3>
                                    <p class="text-xs sm:text-sm text-gray-600 mt-1">
                                        You might be interested in
                                    </p>
                                </div>

                                <a href="{{ route('user.courses') }}" class="text-[#E68815] hover:text-[#d47a12] font-medium text-xs sm:text-sm flex items-center space-x-1 transition-colors">
                                    <span>Explore</span>
                                    <svg class="w-3 sm:w-4 h-3 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>

                            <div class="space-y-4">
                                @include('user.courses.course-items', ['courses' => $relatedCourses])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
