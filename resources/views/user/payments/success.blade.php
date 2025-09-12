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

                    <a href="{{ route('user.courses') }}" class="bg-[#E68815] hover:bg-[#d47a12] text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl w-full sm:w-auto">
                        <span class="flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span>Browse Courses</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <div class="px-1 sm:px-6 pb-12">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-gray-500 rounded-xl sm:rounded-2xl shadow-xl sm:shadow-2xl overflow-hidden border border-gray-200">
                            <!-- Status Header -->
                            <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 sm:p-8 relative">
                                <!-- Status Icon -->
                                <div class="absolute top-0 right-0 opacity-10">
                                    <svg class="w-32 sm:w-48 lg:w-64 h-32 sm:h-48 lg:h-64" viewBox="0 0 200 200" fill="white">
                                        <circle cx="100" cy="100" r="80" stroke="white" stroke-width="8" fill="none"/>
                                        <path d="M80 110l20 20l40-40" stroke="white" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>

                                <div class="relative z-10">
                                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                                        <div>
                                            <img class="h-10 sm:h-12" src="{{ asset('dashboard_assets/images/img/Kodex.png') }}" alt="Kodex Logo">
                                        </div>

                                        <div class="text-left sm:text-right">
                                            <span class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm font-medium bg-white/20 backdrop-blur-sm text-white border border-white/30">
                                                <span class="w-2 h-2 bg-green-300 rounded-full mr-2 animate-pulse"></span>
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
                                            <div class="bg-gray-100 rounded-lg p-4 border-l-4 border-green-500 border">
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
                                                                    <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v2h1V6a3 3 0 013-3h3a3 3 0 013 3v2h1V6a4 4 0 00-4-4zm-5 8a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H7a2 2 0 01-2-2v-6z" clip-rule="evenodd"/>
                                                                </svg>
                                                                Purchased
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
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-4 lg:px-6 py-3 lg:py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Course</th>
                                                <th scope="col" class="px-4 lg:px-6 py-3 lg:py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Price</th>
                                                <th scope="col" class="px-4 lg:px-6 py-3 lg:py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Subtotal</th>
                                                <th scope="col" class="px-4 lg:px-6 py-3 lg:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($courses as $course)
                                                <tr>
                                                    <td class="px-4 lg:px-6 py-3 lg:py-4">
                                                        <div class="flex items-center">
                                                            <div class="w-1 h-12 rounded-full mr-3 bg-green-500"></div>
                                                            <div>
                                                                <p class="text-sm font-medium text-gray-900">{{ $course->title }}</p>
                                                                <p class="text-xs text-gray-500">@truncate($course->subtitle, 45)</p>
                                                                <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full text-xs mt-1 inline-block">{{ $course->category->name }}</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="px-4 lg:px-6 py-3 lg:py-4 text-right text-sm text-gray-900">
                                                        <div class="flex flex-col items-end">
                                                            <span>₦{{ number_format($course->price, 2) }}</span>
                                                            @php
                                                                $vat = $course->price * config('settings.vat_rate', 0.075);
                                                            @endphp
                                                            <span class="text-xs text-gray-500">+ ₦{{ number_format($vat, 2) }} VAT</span>
                                                        </div>
                                                    </td>

                                                    <td class="px-4 lg:px-6 py-3 lg:py-4 text-right text-sm font-medium text-gray-900">
                                                        @php
                                                            $subtotal = $course->price + $vat;
                                                        @endphp
                                                        ₦{{ number_format($subtotal, 2) }}
                                                    </td>

                                                    <td class="px-4 lg:px-6 py-3 lg:py-4 text-center">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v2h1V6a3 3 0 116 0v2h1V6a4 4 0 00-4-4zm-5 8a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H7a2 2 0 01-2-2v-6z" clip-rule="evenodd"/>
                                                            </svg>
                                                            Purchased
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            <tr class="bg-gray-50">
                                                <td colspan="3" class="px-4 lg:px-6 py-3 lg:py-4 text-right text-sm text-gray-500">Discount</td>
                                                <td class="px-4 lg:px-6 py-3 lg:py-4 text-right text-sm text-gray-500">- ₦{{ number_format($payment->discount, 2) }}</td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr class="bg-[#E68815] text-white">
                                                <td colspan="3" class="px-4 lg:px-6 py-3 lg:py-4 text-right font-semibold text-base lg:text-lg">Total Paid</td>
                                                <td class="px-4 lg:px-6 py-3 lg:py-4 text-right font-bold text-lg lg:text-xl">₦{{ number_format($payment->total, 2) }}</td>
                                            </tr>
                                            </tfoot>
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

@push('styles')
    <style>
        .cp-dwp--popup{
            display: none !important;
        }
        a[href="https://confettipage.com"][target="_blank"] {
            display: none !important;
        }
    </style>
@endpush

@push('scripts')
    @if(session('show_confetti'))
        <script src="https://run.confettipage.com/here.js" data-confetticode="U2FsdGVkX1+uarLIXjpz8KMb3BuJCvqsgFESX2e381w55IXrc0wLxyUYYfdDZ/dz0lDQLIe03dQJSq7FhMqo+eYeW9ON/iu96G1Cz8NVARge2TwenuHuiDV56HF6PEN6n8wRBgJ762kdDpq1llR4wf42tbiR6cMJLcKGrylbMhbFOnPC5NUcE4zz6UpCeqK9Bfuymx7DeEuMp805rQInZERpaWH9w2XrAzBYRRvq15fmZT/in/Yhovxzx31/HCVHlsdL7HNIFI7nWFdCNOl5POSLrkhJPmQap0dTK4zRrK5TLksdAkHHSZM27sMYv3D2YYfzJP5jfVfG1copCn7X6ASkhi8uOy0lP5SEJgcJjEoy6qyq9Tvpbx3rPp0qk7x/lpx4oSuGQQbp+1bULhLyAatpoX3D7vumLP7LQP/cRvPSoANakCndAUfezcOBZ6a8ObC/DaWLs+oEWuJ27izlDE2yo2lGguJ6yNNOU67oaxT9SwZ3sbe0b5Eyqm4088BF8aO+fIVI0r5xobmJb0Q7lA+MuBCCNr35yAkXLPkStCOE5d3xNEL8FdEhcyx8UXcHSIsJ9s3cYerTYX6X7UaYU4ZRk/7psX0Ot2HcEJ15JszX1MRW9pv8fReOPYMI7uQK8nR6BPfP+8EtM842Dt0VgKlXFs1t4WWSyBKVSlFe7xIPcapq2btGAyrczrlmjRo+krNHocWepacDRjUsK9qVfdaQVmzQetmYbCzdEuqqM8xpZzzQUSch8x1u/48GxQY3+2+X8i6wzvn5mfCZTy56W7vjvK6K1zkerL6fG+akwvmdZefg2nSKia/JcxLAF4Pl"></script>
    @endif

    <script type="text/javascript">
        // Hide ALL links pointing to confettipage.com
        document.querySelectorAll('a[href*="confettipage.com"]').forEach(link => {
            link.style.display = 'none';
        });

        // OR hide only the specific one with fixed positioning
        const confettiLink = document.querySelector('a[href="https://confettipage.com"][style*="position: fixed"]');
        if (confettiLink) {
            confettiLink.style.display = 'none';
        }

        document.querySelectorAll('a[style*="position: fixed"][style*="bottom: 0"]').forEach(link => {
            link.style.display = 'none';
        });
    </script>
@endpush
