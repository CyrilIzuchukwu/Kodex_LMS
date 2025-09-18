@extends('layouts.admin')
@section('content')
    <div class="min-h-screen bg-white">
        <div class="w-full px-4 sm:px-6 py-6 sm:py-8">
            <div class="mx-auto">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Transaction Management</h1>
                        <p class="text-gray-500 mt-1 sm:mt-2 text-sm sm:text-base">Review and manage payment transactions</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.reports.transactions') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700 transition-colors">
                            Back to Transactions
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-1 sm:px-6 pb-12">
            <div class="mx-auto max-w-5xl">
                <div class="flex justify-center">
                    <div class="w-full max-w-4xl">
                        <!-- Admin Action Panel -->
                        @if($payment->status === 'pending')
                            <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-6 overflow-hidden">
                                <div class="bg-gray-500 px-6 py-4">
                                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                        Admin Actions Required
                                    </h2>
                                    <p class="text-blue-100 text-sm mt-1">This transaction is pending approval</p>
                                </div>

                                <div class="p-6">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <!-- Approve Transaction -->
                                        <form action="{{ route('admin.reports.transaction.approve', $payment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-full bg-green-600 text-white px-4 py-3 rounded-lg font-medium hover:bg-green-700 transition-colors flex items-center justify-center">
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                Approve Payment
                                            </button>
                                        </form>

                                        <!-- Cancel Transaction -->
                                        <form action="{{ route('admin.reports.transaction.cancel', $payment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-full bg-red-600 text-white px-4 py-3 rounded-lg font-medium hover:bg-red-700 transition-colors flex items-center justify-center" onclick="return confirm('Are you sure you want to cancel this transaction?')">
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                </svg>
                                                Cancel Payment
                                            </button>
                                        </form>

                                        <!-- Mark as Under Review -->
                                        <form action="{{ route('admin.reports.transaction.review', $payment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-full bg-yellow-600 text-white px-4 py-3 rounded-lg font-medium hover:bg-yellow-700 transition-colors flex items-center justify-center">
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                                Mark Under Review
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Admin Notes Section -->
                                    <div class="mt-6 border-t pt-6">
                                        <form action="{{ route('admin.reports.transaction.note', $payment->id) }}" method="POST">
                                            @csrf
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Add Admin Note</label>
                                            <div class="flex gap-3">
                                                <textarea name="admin_note" rows="2" class="flex-1 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Add internal note about this transaction..."></textarea>
                                                <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-gray-700 transition-colors">
                                                    Add Note
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Transaction Invoice -->
                        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                            <!-- Status Header -->
                            @if($payment->status === 'completed' || $payment->status === 'success' || $payment->status === 'approved')
                                <div class="bg-gray-500 p-6 sm:p-8 relative">
                                    <!-- Success Status Icon -->
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
                                                <div class="mt-4">
                                                    <h2 class="text-xl sm:text-2xl font-bold text-white">Payment Approved</h2>
                                                    <p class="text-green-100 mt-1">Transaction has been successfully processed and approved.</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <span class="bg-white bg-opacity-20 text-white px-3 py-1 rounded-full text-sm font-medium">
                                                    Admin Approved
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($payment->status === 'pending')
                                <div class="bg-gray-500 p-6 sm:p-8 relative">
                                    <!-- Pending Status Icon -->
                                    <div class="absolute top-0 right-0 opacity-10">
                                        <svg class="w-32 sm:w-48 lg:w-64 h-32 sm:h-48 lg:h-64" viewBox="0 0 200 200" fill="white">
                                            <circle cx="100" cy="100" r="80" stroke="white" stroke-width="8" fill="none"/>
                                            <circle cx="100" cy="100" r="20" fill="white"/>
                                            <path d="M100 60v40M140 100h-40" stroke="white" stroke-width="6" stroke-linecap="round"/>
                                        </svg>
                                    </div>

                                    <div class="relative z-10">
                                        <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                                            <div>
                                                <img class="h-10 sm:h-12" src="{{ asset('dashboard_assets/images/img/Kodex.png') }}" alt="Kodex Logo">
                                                <div class="mt-4">
                                                    <h2 class="text-xl sm:text-2xl font-bold text-white">Pending Approval</h2>
                                                    <p class="text-yellow-100 mt-1">This transaction requires admin review and approval.</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <span class="bg-white bg-opacity-20 text-white px-3 py-1 rounded-full text-sm font-medium">
                                                    Awaiting Review
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($payment->status === 'under_review')
                                <div class="bg-gray-500 p-6 sm:p-8 relative">
                                    <!-- Review Status Icon -->
                                    <div class="absolute top-0 right-0 opacity-10">
                                        <svg class="w-32 sm:w-48 lg:w-64 h-32 sm:h-48 lg:h-64" viewBox="0 0 200 200" fill="white">
                                            <circle cx="100" cy="100" r="80" stroke="white" stroke-width="8" fill="none"/>
                                            <path d="M100 60v40l20 20" stroke="white" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>

                                    <div class="relative z-10">
                                        <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                                            <div>
                                                <img class="h-10 sm:h-12" src="{{ asset('dashboard_assets/images/img/Kodex.png') }}" alt="Kodex Logo">
                                                <div class="mt-4">
                                                    <h2 class="text-xl sm:text-2xl font-bold text-white">Under Review</h2>
                                                    <p class="text-blue-100 mt-1">Transaction is currently being reviewed by admin.</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <span class="bg-white bg-opacity-20 text-white px-3 py-1 rounded-full text-sm font-medium">
                                                    In Review
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="bg-gray-500 p-6 sm:p-8 relative">
                                    <!-- Failed/Cancelled Status Icon -->
                                    <div class="absolute top-0 right-0 opacity-10">
                                        <svg class="w-32 sm:w-48 lg:w-64 h-32 sm:h-48 lg:h-64" viewBox="0 0 200 200" fill="white">
                                            <circle cx="100" cy="100" r="80" stroke="white" stroke-width="8" fill="none"/>
                                            <path d="M80 80l40 40M120 80l-40 40" stroke="white" stroke-width="8" stroke-linecap="round"/>
                                        </svg>
                                    </div>

                                    <div class="relative z-10">
                                        <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                                            <div>
                                                <img class="h-10 sm:h-12" src="{{ asset('dashboard_assets/images/img/Kodex.png') }}" alt="Kodex Logo">
                                                <div class="mt-4">
                                                    <h2 class="text-xl sm:text-2xl font-bold text-white">
                                                        {{ $payment->status === 'cancelled' ? 'Payment Cancelled' : 'Payment Failed' }}
                                                    </h2>
                                                    <p class="text-red-100 mt-1">
                                                        {{ $payment->status === 'cancelled' ? 'This transaction has been cancelled by admin.' : 'This transaction could not be completed.' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <span class="bg-white bg-opacity-20 text-white px-3 py-1 rounded-full text-sm font-medium">
                                                    {{ ucfirst($payment->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Transaction Details -->
                            <div class="p-6 sm:p-8 lg:p-10 bg-white">
                                <!-- Admin Information Bar -->
                                <div class="bg-gray-100 border-l-4 border-blue-500 p-4 mb-6">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Admin View</h4>
                                            <p class="text-sm text-gray-700 mt-1">
                                                You are viewing this transaction as an administrator.
                                                @if($payment->status === 'pending')
                                                    Take action using the controls above.
                                                @else
                                                    Status: <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $payment->status)) }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Transaction Summary -->
                                <div class="bg-gray-50 rounded-lg p-6 mb-8 border border-gray-200">
                                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-4">Transaction Details</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                        <div>
                                            <p class="text-xs text-gray-500">Student Name</p>
                                            <p class="text-base font-semibold text-gray-800">{{ $payment->user->name }}</p>
                                        </div>

                                        <div>
                                            <p class="text-xs text-gray-500">E-mail</p>
                                            <p class="text-base font-semibold text-gray-800">{{ $payment->user->email }}</p>
                                        </div>

                                        <div>
                                            <p class="text-xs text-gray-500">Phone Number</p>
                                            <p class="text-base font-semibold text-gray-800 break-all">
                                                {{ $payment->user->profile->phone_number ?? 'N/A'  }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-xs text-gray-500">Transaction ID</p>
                                            <p class="text-base font-semibold text-gray-800">{{ $payment->transaction_reference ?? 'N/A' }}</p>
                                        </div>

                                        <div>
                                            <p class="text-xs text-gray-500">Payment Method</p>
                                            <p class="text-base font-semibold text-gray-800">{{ strtoupper($payment->payment_method) }}</p>
                                        </div>

                                        <div>
                                            <p class="text-xs text-gray-500">Status</p>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($payment->status === 'completed' || $payment->status === 'success' || $payment->status === 'approved')
                                                    bg-green-100 text-green-800
                                                @elseif($payment->status === 'pending')
                                                    bg-yellow-100 text-yellow-800
                                                @elseif($payment->status === 'under_review')
                                                    bg-blue-100 text-blue-800
                                                @else
                                                    bg-red-100 text-red-800
                                                @endif
                                            ">
                                                {{ ucfirst(str_replace('_', ' ', $payment->status)) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Course Items -->
                                <div class="mb-8">
                                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-4">Purchase Details</h3>

                                    <div class="overflow-x-auto rounded-xl border border-gray-300">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Course</th>
                                                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Price</th>
                                                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">VAT</th>
                                                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Subtotal</th>
                                                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Access Status</th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($courses as $course)
                                                <tr>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center">
                                                            <div class="w-1 h-12 rounded-full mr-3
                                                                    @if($payment->status === 'completed' || $payment->status === 'success' || $payment->status === 'approved')
                                                                        bg-green-500
                                                                    @elseif($payment->status === 'pending' || $payment->status === 'under_review')
                                                                        bg-yellow-500
                                                                    @else
                                                                        bg-red-500
                                                                    @endif
                                                                "></div>
                                                            <div>
                                                                <p class="text-sm font-medium text-gray-900">{{ $course->title }}</p>
                                                                <p class="text-xs text-gray-500">@truncate($course->subtitle, 45)</p>
                                                                <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full text-xs mt-1 inline-block">{{ $course->category->name }}</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="px-6 py-4 text-right text-sm text-gray-900">
                                                        ₦{{ number_format($course->price, 2) }}
                                                    </td>

                                                    <td class="px-6 py-4 text-right text-sm text-gray-900">
                                                        @php
                                                            $vat = $course->price * config('settings.vat_rate', 0.075);
                                                        @endphp
                                                        ₦{{ number_format($vat, 2) }}
                                                    </td>

                                                    <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                                                        @php
                                                            $subtotal = $course->price + $vat;
                                                        @endphp
                                                        ₦{{ number_format($subtotal, 2) }}
                                                    </td>

                                                    <td class="px-6 py-4 text-center">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                            @if($payment->status === 'completed' || $payment->status === 'success' || $payment->status === 'approved')
                                                                bg-green-100 text-green-800
                                                            @elseif($payment->status === 'pending' || $payment->status === 'under_review')
                                                                bg-yellow-100 text-yellow-800
                                                            @else
                                                                bg-red-100 text-red-800
                                                            @endif
                                                        ">
                                                            @if($payment->status === 'completed' || $payment->status === 'success' || $payment->status === 'approved')
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v2h1V6a3 3 0 116 0v2h1V6a4 4 0 00-4-4zm-5 8a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H7a2 2 0 01-2-2v-6z" clip-rule="evenodd"/>
                                                                </svg>
                                                                Purchased
                                                            @elseif($payment->status === 'pending' || $payment->status === 'under_review')
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                                </svg>
                                                                Pending
                                                            @else
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                                </svg>
                                                                Cancelled
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            <tr class="bg-gray-50">
                                                <td colspan="3" class="px-6 py-4 text-right text-sm text-gray-500 font-medium">Discount Applied</td>
                                                <td class="px-6 py-4 text-right text-sm text-gray-500 font-medium">- ₦{{ number_format($payment->discount, 2) }}</td>
                                                <td class="px-6 py-4"></td>
                                            </tr>
                                            </tbody>

                                            <tfoot>
                                            <tr class="
                                                    @if($payment->status === 'completed' || $payment->status === 'success' || $payment->status === 'approved')
                                                        bg-green-600 text-white
                                                    @elseif($payment->status === 'pending')
                                                        bg-yellow-500 text-white
                                                    @elseif($payment->status === 'under_review')
                                                        bg-blue-500 text-white
                                                    @else
                                                        bg-red-500 text-white
                                                    @endif
                                                ">
                                                <td colspan="3" class="px-6 py-4 text-right font-semibold text-lg">
                                                    Total Amount
                                                </td>
                                                <td class="px-6 py-4 text-right font-bold text-xl">₦{{ number_format($payment->total, 2) }}</td>
                                                <td class="px-6 py-4"></td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <!-- Admin Notes Section -->
                                @if($payment->admin_notes && count($payment->admin_notes) > 0)
                                    <div class="bg-blue-50 rounded-lg p-6 mb-8 border border-blue-200">
                                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-4">Admin Notes</h3>
                                        <div class="space-y-3">
                                            @foreach($payment->admin_notes as $note)
                                                <div class="bg-white rounded-lg p-3 border border-blue-200">
                                                    <p class="text-sm text-gray-700">{{ $note->note }}</p>
                                                    <div class="flex justify-between items-center mt-2 text-xs text-gray-500">
                                                        <span>By: {{ $note->admin->name ?? 'System' }}</span>
                                                        <span>{{ $note->created_at->format('d M Y, h:i A') }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Payment Timeline -->
                                <div class="bg-gray-50 rounded-lg p-6 mb-8 border border-gray-200">
                                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-4">Transaction Timeline</h3>
                                    <div class="space-y-4">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-900">Transaction Initiated</p>
                                                <p class="text-xs text-gray-500">{{ $payment->created_at->format('d M Y, h:i A') }}</p>
                                            </div>
                                        </div>

                                        @if($payment->status !== 'pending')
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 w-8 h-8
                                                    @if($payment->status === 'completed' || $payment->status === 'success' || $payment->status === 'approved')
                                                        bg-green-100
                                                    @elseif($payment->status === 'under_review')
                                                        bg-yellow-100
                                                    @else
                                                        bg-red-100
                                                    @endif
                                                    rounded-full flex items-center justify-center">
                                                    @if($payment->status === 'completed' || $payment->status === 'success' || $payment->status === 'approved')
                                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                    @elseif($payment->status === 'under_review')
                                                        <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                        </svg>
                                                    @else
                                                        <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-gray-900">
                                                        Status Updated: {{ ucfirst(str_replace('_', ' ', $payment->status)) }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">{{ $payment->updated_at->format('d M Y, h:i A') }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Additional Admin Actions for Non-Pending Transactions -->
                                @if($payment->status !== 'pending')
                                    <div class="bg-gray-50 rounded-lg p-6 mb-8 border border-gray-200">
                                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-4">Additional Actions</h3>
                                        <div class="flex flex-wrap gap-3">
                                            @if($payment->status === 'cancelled' || $payment->status === 'failed')
                                                <form action="#" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                                                        Reactivate Transaction
                                                    </button>
                                                </form>
                                            @endif

                                            @if($payment->status === 'approved' || $payment->status === 'completed')
                                                <form action="#" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-700 transition-colors" onclick="return confirm('Are you sure you want to revoke access for this transaction?')">
                                                        Revoke Access
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="#" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700 transition-colors">
                                                    Resend Receipt
                                                </button>
                                            </form>

                                            <a href="{{ route('admin.students.show', $payment->user->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                                                View Student Profile
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <!-- Payment Information -->
                                <div class="bg-gray-50 rounded-lg p-6 mb-8 border border-gray-200">
                                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-4">Payment Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="flex items-center space-x-4">
                                            <div class="bg-white rounded-lg p-3 shadow-sm border border-gray-200">
                                                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ strtoupper($payment->payment_method) }}</p>
                                                <p class="text-xs text-gray-500">{{ strtoupper($payment->channel ?? 'N/A') }}</p>
                                                @if($payment->gateway_response)
                                                    <p class="text-xs text-gray-400">Response: {{ $payment->gateway_response }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-left md:text-right">
                                            <p class="text-xs text-gray-500">Transaction Date</p>
                                            <p class="text-sm font-medium text-gray-900">{{ $payment->created_at->format('d M Y, h:i A') }}</p>
                                            @if($payment->created_at != $payment->updated_at)
                                                <p class="text-xs text-gray-500 mt-1">Last Updated: {{ $payment->updated_at->format('d M Y, h:i A') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="border-t border-gray-200 pt-6">
                                    <div class="text-center text-sm text-gray-500">
                                        <p class="font-medium">Admin Dashboard - Transaction Management</p>
                                        <p class="mt-2">
                                            @if($payment->status === 'completed' || $payment->status === 'success' || $payment->status === 'approved')
                                                Student has been granted access to purchased courses.
                                            @elseif($payment->status === 'pending')
                                                Transaction requires admin approval before course access is granted.
                                            @elseif($payment->status === 'under_review')
                                                Transaction is currently under admin review.
                                            @else
                                                Student access has been {{ $payment->status === 'cancelled' ? 'cancelled' : 'denied' }} for this transaction.
                                            @endif
                                        </p>
                                        <p class="mt-2 text-xs">
                                            For technical support, contact the development team at {{ site_settings()->support_email ?? site_settings()->site_email }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
