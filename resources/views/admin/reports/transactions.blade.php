@extends('layouts.admin')
@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="w-full px-6 py-8">
            <div class="mx-auto">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Transaction History</h1>
                        <p class="text-gray-500 mt-2">View and manage your course purchase history</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 mb-8">
            <div class="mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Total Revenue</p>
                                <p class="text-2xl font-bold text-gray-800 mt-1">
                                    ₦{{ number_format($completed_payments) }}
                                </p>
                            </div>
                            <div class="bg-green-100 rounded-full p-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Courses Purchased</p>
                                <p class="text-2xl font-bold text-gray-800 mt-1">
                                    {{ $purchased_courses_count }}
                                </p>
                            </div>
                            <div class="bg-blue-100 rounded-full p-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">This Month</p>
                                <p class="text-2xl font-bold text-gray-800 mt-1">
                                    ₦{{ number_format($payments_this_month) }}
                                </p>
                            </div>
                            <div class="bg-orange-100 rounded-full p-3">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 pb-12">
            <div class="mx-auto">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Transactions</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Course Details</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date & Time</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Payment Method</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($payments as $payment)
                                    @php
                                        $cartItems = json_decode($payment->cart_items, true) ?? [];
                                        $firstCourse = !empty($cartItems) ? $courses->firstWhere('id', $cartItems[0]['course_id'] ?? null) : null;
                                        $courseCount = count($cartItems);
                                        $courseTitle = $firstCourse ? $firstCourse->title . ($courseCount > 1 ? ' + ' . ($courseCount - 1) . ' more' : '') : 'Unknown Course';
                                        $courseCategory = $firstCourse && $firstCourse->category ? $firstCourse->category->name . ($courseCount > 1 ? ' + ' . ($courseCount - 1) . ' more' : '') : 'No Category';
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-shrink-0 w-12 h-12 bg-gray-50 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-semibold text-gray-900">{{ $courseTitle }}</h4>
                                                    <p class="text-xs text-gray-500">{{ $courseCategory }}</p>
                                                    <p class="text-xs text-gray-400 mt-1">{{ $payment->transaction_reference ?: 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">{{ date('M d, Y', strtotime($payment->created_at)) }}</div>
                                            <div class="text-xs text-gray-500">{{ date('h:i A', strtotime($payment->created_at)) }}</div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="text-sm font-semibold text-gray-900">₦{{ number_format($payment->amount, 2) }}</div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $payment->status == 'completed' ? 'bg-green-100 text-green-800' : ($payment->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                <span class="w-1.5 h-1.5 {{ $payment->status == 'completed' ? 'bg-green-500' : ($payment->status == 'pending' ? 'bg-yellow-500 animate-pulse' : 'bg-red-500') }} rounded-full mr-2"></span>
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="text-xs text-gray-900">{{ $payment->payment_method ?? 'N/A' }}</div>
                                                    <div class="text-xs text-gray-500">{{ $payment->channel ?: 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="{{ route('admin.reports.transaction.show', $payment->id) }}" class="bg-[#E68815] hover:bg-[#d47a12] text-white px-3 py-2 rounded-lg text-xs font-medium transition-all duration-200">
                                                    View Invoice
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            No transactions found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $payments->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
