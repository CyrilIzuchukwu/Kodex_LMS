@php use Carbon\Carbon; @endphp
@extends('layouts.admin')
@section('content')
    <!-- Breadcrumb Navigation -->
    <div class="mb-6">
        <nav
            class="bg-white rounded-[20px] md:rounded-[30px] shadow-sm px-4 md:px-6 py-3 flex items-center justify-start w-full">
            <ol class="flex items-center space-x-2 md:space-x-3 text-sm md:text-base font-medium text-[#141B34]">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                       class="hover:text-[#E68815] transition-colors duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-7 7v-10"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </li>
                <li>
                    <span class="text-[#E68815] font-semibold">Coupons</span>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden">
        <!-- Header Section -->
        <div class="px-6 py-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="text-gray-900">
                    <h1 class="text-3xl font-bold mb-2">Coupons Management</h1>
                    <p class="text-gray-500 text-lg">Create and manage discount coupons for your store</p>
                </div>
                <button id="open-create-modal" class="bg-[#E68815] hover:bg-[#d17710] text-white px-6 py-3 rounded-xl font-semibold flex items-center space-x-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Add New Coupon</span>
                </button>
            </div>
        </div>

        <!-- Content Area -->
        <div class="px-6" id="content-container">
            @if($coupons->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8" id="coupons-container">
                    @foreach($coupons as $coupon)
                        <!-- Coupon Card -->
                        <div class="group relative bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-shadow" data-coupon-id="{{ $coupon->id }}">
                            <!-- Card Header -->
                            <div class="flex items-start justify-between mb-6">
                                <div class="flex items-center space-x-4">
                                    <!-- Coupon Icon -->
                                    <div class="relative">
                                        <div class="w-16 h-16 rounded-2xl overflow-hidden shadow-sm flex items-center justify-center bg-gray-300 from-[#E68815] to-[#d17710]">
                                            @if($coupon->type === 'percentage')
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center space-x-2">
                                    <!-- Edit Button -->
                                    <button class="open-edit-modal p-2 rounded-full hover:bg-gray-200 transition-colors duration-150"
                                        data-coupon-id="{{ $coupon->id }}"
                                        data-coupon-code="{{ $coupon->code }}"
                                        data-coupon-type="{{ $coupon->type }}"
                                        data-coupon-value="{{ $coupon->value }}"
                                        data-coupon-valid-from="{{ $coupon->valid_from }}"
                                        data-coupon-valid-to="{{ $coupon->valid_to }}"
                                        data-coupon-is-active="{{ $coupon->is_active }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>

                                    <!-- Delete Button -->
                                    <button class="delete-coupon p-2 rounded-full hover:bg-red-100 text-red-600 transition-colors duration-150" data-coupon-id="{{ $coupon->id }}" data-coupon-code="{{ $coupon->code }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Coupon Details -->
                            <div class="mb-4">
                                <h3 class="coupon-code text-xl font-bold text-gray-800 mb-2 font-mono bg-gray-100 px-2 py-1 rounded">{{ $coupon->code }}</h3>
                                <div class="text-2xl font-bold text-[#E68815] mb-2">
                                    @if($coupon->type === 'percentage')
                                        {{ number_format($coupon->value) }}% OFF
                                    @else
                                        ₦{{ number_format($coupon->value, 2) }} OFF
                                    @endif
                                </div>
                                <p class="text-gray-500 text-sm">{{ ucfirst($coupon->type) }} Discount</p>
                            </div>

                            <!-- Validity Period -->
                            <div class="mb-4 text-sm">
                                <div class="text-gray-600 mb-1">
                                    <span class="font-medium">Valid:</span> {{ Carbon::parse($coupon->valid_from)->format('M j, Y') }} - {{ Carbon::parse($coupon->valid_to)->format('M j, Y') }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    @php
                                        $now = Carbon::now();
                                        $validFrom = Carbon::parse($coupon->valid_from);
                                        $validTo = Carbon::parse($coupon->valid_to);
                                    @endphp
                                    @if($now->lt($validFrom))
                                        <span class="text-blue-600">Starts in {{ $now->diffForHumans($validFrom) }}</span>
                                    @elseif($now->gt($validTo))
                                        <span class="text-red-600">Expired {{ $validTo->diffForHumans() }}</span>
                                    @else
                                        <span class="text-green-600">Expires {{ $validTo->diffForHumans() }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Status & Type -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <span class="inline-flex items-center h-8 px-3 py-1 rounded-full text-xs font-medium {{ $coupon->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    <i class="uil uil-circle mr-1 text-xs"></i>
                                    {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                </span>

                                <div class="text-right">
                                    <div class="text-xs text-gray-400 uppercase tracking-wide font-semibold">{{ ucfirst($coupon->type) }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div id="pagination">
                    {{ $coupons->links('vendor.pagination.tailwind') }}
                </div>
            @else
                <!-- Empty State -->
                <div id="no-coupons" class="flex flex-col items-center justify-center py-12 sm:py-20">
                    <div class="relative mb-6 sm:mb-8">
                        <div
                            class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl bg-[#E68815] flex items-center justify-center">
                            <svg class="w-10 h-10 sm:w-12 sm:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div
                            class="absolute -top-2 -right-2 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-yellow-400 to-orange-400 flex items-center justify-center">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-700 mb-4 text-center">No Coupons Created</h2>
                    <p class="text-gray-500 text-base sm:text-lg text-center max-w-xs sm:max-w-md mb-6 sm:mb-8 px-4">Get started by creating your first discount coupon to attract more customers.</p>
                    <button id="open-create-modal-empty" class="bg-[#E68815] hover:bg-[#d17710] text-white px-6 py-3 rounded-xl font-semibold flex items-center space-x-2 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Create Your First Coupon</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Create Coupon Modal -->
    <div id="create-modal" class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex justify-center z-[9999] overflow-y-auto pt-2 md:pt-4 pb-2 md:pb-4 hidden">
        <div
            class="modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-[90vw] sm:w-[80vw] md:w-[65vw] lg:w-[60vw] xl:w-[50vw] p-3 md:p-6 lg:p-6 space-y-3 z-[10000] self-start mt-2 md:mt-4 mb-2 md:mb-4 mx-2">
            <!-- Modal Header -->
            <div class="bg-[#E68815] px-4 sm:px-8 py-4 sm:py-6 rounded-t-3xl relative">
                <button id="close-create-modal" class="absolute top-2 sm:top-4 right-2 sm:right-4 w-8 sm:w-10 h-8 sm:h-10 rounded-full bg-white/20 hover:bg-white/30 text-gray-900 flex items-center justify-center transition-colors">
                    <svg class="w-5 sm:w-6 h-5 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4 text-gray-900">
                    <div class="w-10 sm:w-12 h-10 sm:h-12 rounded-2xl bg-white/20 flex items-center justify-center">
                        <svg class="w-6 sm:w-7 h-6 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-xl sm:text-2xl font-bold">Create New Coupon</h3>
                        <p class="text-gray-100 text-sm sm:text-base">Add a new discount coupon</p>
                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <form id="create-form" method="POST" action="{{ route('admin.coupons.store') }}" class="p-4 sm:p-8">
                @csrf

                <div class="space-y-4 sm:space-y-6">
                    <!-- Coupon Code -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="create-coupon-code">Coupon Code *</label>
                        <input name="code" type="text" id="create-coupon-code" class="w-full px-3 sm:px-4 py-2 sm:py-3 text-gray-700 border border-gray-300 rounded-xl text-sm sm:text-base font-mono uppercase" placeholder="e.g. SAVE20, WELCOME10" autocomplete="off">
                        <span class="text-red-500 text-xs sm:text-sm hidden error-message"></span>
                    </div>

                    <!-- Discount Type -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="create-coupon-type">Discount Type *</label>
                        <select name="type" id="create-coupon-type" class="w-full text-gray-700 px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-xl text-sm sm:text-base">
                            <option value="percentage">Percentage (%)</option>
                            <option value="fixed">Fixed Amount ($)</option>
                        </select>
                        <span class="text-red-500 text-xs sm:text-sm hidden error-message"></span>
                    </div>

                    <!-- Discount Value -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="create-coupon-value">Discount Value *</label>
                        <input name="value" type="number" step="0.01" min="0" id="create-coupon-value" class="w-full px-3 sm:px-4 py-2 sm:py-3 text-gray-700 border border-gray-300 rounded-xl text-sm sm:text-base" placeholder="e.g. 20 or 50.00">
                        <span class="text-red-500 text-xs sm:text-sm hidden error-message"></span>
                    </div>

                    <!-- Valid From -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="create-valid-from">Valid From *</label>
                        <input name="valid_from" type="datetime-local" id="create-valid-from" class="w-full px-3 sm:px-4 py-2 sm:py-3 text-gray-700 border border-gray-300 rounded-xl text-sm sm:text-base">
                        <span class="text-red-500 text-xs sm:text-sm hidden error-message"></span>
                    </div>

                    <!-- Valid To -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="create-valid-to">Valid To *</label>
                        <input name="valid_to" type="datetime-local" id="create-valid-to" class="w-full px-3 sm:px-4 py-2 sm:py-3 text-gray-700 border border-gray-300 rounded-xl text-sm sm:text-base">
                        <span class="text-red-500 text-xs sm:text-sm hidden error-message"></span>
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="create-is-active">Status *</label>
                        <select name="is_active" id="create-is-active" class="w-full text-gray-700 px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-xl text-sm sm:text-base">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <span class="text-red-500 text-xs sm:text-sm hidden error-message"></span>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 mt-6 sm:mt-8">
                    <button type="button" id="cancel-create-modal" class="flex-1 px-4 sm:px-6 py-2 sm:py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-semibold transition-colors text-sm sm:text-base">
                        Cancel
                    </button>

                    <button type="submit" class="flex-1 bg-[#E68815] hover:bg-[#d17710] text-white px-4 sm:px-6 py-2 sm:py-3 rounded-xl font-semibold flex items-center justify-center text-sm sm:text-base">
                        <span class="submit-text">Create Coupon</span>
                        <span class="preloader hidden flex items-center space-x-2">
                            <svg class="animate-spin h-4 sm:h-5 w-4 sm:w-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            <span>Creating...</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Coupon Modal -->
    <div id="edit-modal" class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex justify-center z-[9999] overflow-y-auto pt-2 md:pt-4 pb-2 md:pb-4 hidden">
        <div
            class="modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-[90vw] sm:w-[80vw] md:w-[65vw] lg:w-[60vw] xl:w-[50vw] p-3 md:p-6 lg:p-6 space-y-3 z-[10000] self-start mt-2 md:mt-4 mb-2 md:mb-4 mx-2">
            <!-- Modal Header -->
            <div class="bg-[#E68815] px-4 sm:px-8 py-4 sm:py-6 rounded-t-3xl relative">
                <button id="close-edit-modal" class="absolute top-2 sm:top-4 right-2 sm:right-4 w-8 sm:w-10 h-8 sm:h-10 rounded-full bg-white/20 hover:bg-white/30 text-gray-900 flex items-center justify-center transition-colors">
                    <svg class="w-5 sm:w-6 h-5 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4 text-gray-900">
                    <div class="w-10 sm:w-12 h-10 sm:h-12 rounded-2xl bg-white/20 flex items-center justify-center">
                        <svg class="w-6 sm:w-7 h-6 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-xl sm:text-2xl font-bold">Edit Coupon</h3>
                        <p class="text-gray-100 text-sm sm:text-base">Update coupon information</p>
                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <form id="edit-form" method="POST" class="p-4 sm:p-8">
                @csrf
                @method('PUT')

                <div class="space-y-4 sm:space-y-6">
                    <!-- Coupon Code -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="edit-coupon-code">Coupon Code *</label>
                        <input name="code" type="text" id="edit-coupon-code" class="w-full px-3 sm:px-4 py-2 sm:py-3 text-gray-700 border border-gray-300 rounded-xl text-sm sm:text-base font-mono uppercase" placeholder="e.g. SAVE20, WELCOME10" autocomplete="off">
                        <span class="text-red-500 text-xs sm:text-sm hidden error-message"></span>
                    </div>

                    <!-- Discount Type -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="edit-coupon-type">Discount Type *</label>
                        <select name="type" id="edit-coupon-type" class="w-full text-gray-700 px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-xl text-sm sm:text-base">
                            <option value="percentage">Percentage (%)</option>
                            <option value="fixed">Fixed Amount ($)</option>
                        </select>
                        <span class="text-red-500 text-xs sm:text-sm hidden error-message"></span>
                    </div>

                    <!-- Discount Value -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="edit-coupon-value">Discount Value *</label>
                        <input name="value" type="number" step="0.01" min="0" id="edit-coupon-value" class="w-full px-3 sm:px-4 py-2 sm:py-3 text-gray-700 border border-gray-300 rounded-xl text-sm sm:text-base" placeholder="e.g. 20 or 50.00">
                        <span class="text-red-500 text-xs sm:text-sm hidden error-message"></span>
                    </div>

                    <!-- Valid From -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="edit-valid-from">Valid From *</label>
                        <input name="valid_from" type="datetime-local" id="edit-valid-from" class="w-full px-3 sm:px-4 py-2 sm:py-3 text-gray-700 border border-gray-300 rounded-xl text-sm sm:text-base">
                        <span class="text-red-500 text-xs sm:text-sm hidden error-message"></span>
                    </div>

                    <!-- Valid To -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="edit-valid-to">Valid To *</label>
                        <input name="valid_to" type="datetime-local" id="edit-valid-to" class="w-full px-3 sm:px-4 py-2 sm:py-3 text-gray-700 border border-gray-300 rounded-xl text-sm sm:text-base">
                        <span class="text-red-500 text-xs sm:text-sm hidden error-message"></span>
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="edit-is-active">Status *</label>
                        <select name="is_active" id="edit-is-active" class="w-full text-gray-700 px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-xl text-sm sm:text-base">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <span class="text-red-500 text-xs sm:text-sm hidden error-message"></span>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 mt-6 sm:mt-8">
                    <button type="button" id="cancel-edit-modal" class="flex-1 px-4 sm:px-6 py-2 sm:py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-semibold transition-colors text-sm sm:text-base">
                        Cancel
                    </button>

                    <button type="submit" class="flex-1 bg-[#E68815] hover:bg-[#d17710] text-white px-4 sm:px-6 py-2 sm:py-3 rounded-xl font-semibold flex items-center justify-center text-sm sm:text-base">
                        <span class="submit-text">Update Coupon</span>
                        <span class="preloader hidden flex items-center space-x-2">
                            <svg class="animate-spin h-4 sm:h-5 w-4 sm:w-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            <span>Updating...</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-[9999] hidden p-4">
        <div class="modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-full max-w-sm md:max-w-md h-auto p-4 md:p-6 flex flex-col items-center justify-center z-[10000]">
            <!-- Modal Header -->
            <div class="text-center mb-6">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Delete Coupon</h3>
                <p class="text-gray-500">Are you sure you want to delete the coupon <span id="delete-coupon-code" class="font-mono font-bold text-red-600"></span>? This action cannot be undone.</p>
            </div>

            <!-- Modal Footer -->
            <div class="flex space-x-4">
                <button type="button" id="cancel-delete-modal" class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-semibold transition-colors">
                    Cancel
                </button>
                <button type="button" id="confirm-delete-coupon"
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-xl font-semibold flex items-center justify-center">
                    <span class="submit-text">Delete</span>
                    <span class="preloader hidden flex items-center space-x-2">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span>Deleting...</span>
                    </span>
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Modal Elements
            const createModal = document.getElementById('create-modal');
            const editModal = document.getElementById('edit-modal');
            const deleteModal = document.getElementById('delete-modal');

            const openCreateModalBtns = document.querySelectorAll('#open-create-modal, #open-create-modal-empty');
            const closeCreateModalBtn = document.getElementById('close-create-modal');
            const cancelCreateModalBtn = document.getElementById('cancel-create-modal');

            const closeEditModalBtn = document.getElementById('close-edit-modal');
            const cancelEditModalBtn = document.getElementById('cancel-edit-modal');

            const cancelDeleteModalBtn = document.getElementById('cancel-delete-modal');
            const confirmDeleteBtn = document.getElementById('confirm-delete-coupon');

            const createForm = document.getElementById('create-form');
            const editForm = document.getElementById('edit-form');

            // Helper Functions
            function openModal(modal) {
                modal.classList.remove('hidden', 'opacity-0');
                modal.querySelector('.modal-content').classList.remove('scale-95');
            }

            function hideModal(modal) {
                modal.classList.add('opacity-0');
                modal.querySelector('.modal-content').classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }

            function showPreloader(button) {
                button.querySelector('.submit-text').classList.add('hidden');
                button.querySelector('.preloader').classList.remove('hidden');
                button.disabled = true;
            }

            function hidePreloader(button) {
                button.querySelector('.submit-text').classList.remove('hidden');
                button.querySelector('.preloader').classList.add('hidden');
                button.disabled = false;
            }

            function showError(input, message) {
                const errorElement = input.nextElementSibling;
                errorElement.textContent = message;
                errorElement.classList.remove('hidden');
                input.classList.add('border-red-500');
            }

            function clearErrors(form) {
                form.querySelectorAll('.error-message').forEach(error => {
                    error.classList.add('hidden');
                    error.textContent = '';
                });
                form.querySelectorAll('input, select').forEach(input => {
                    input.classList.remove('border-red-500');
                });
            }

            function formatDateTimeForInput(dateTimeString) {
                if (!dateTimeString) return '';
                const date = new Date(dateTimeString);
                return date.toISOString().slice(0, 16);
            }

            // Open Create Modal
            openCreateModalBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    clearErrors(createForm);
                    createForm.reset();
                    // Set default dates
                    const now = new Date();
                    const tomorrow = new Date(now.getTime() + 24 * 60 * 60 * 1000);
                    const nextWeek = new Date(now.getTime() + 7 * 24 * 60 * 60 * 1000);

                    document.getElementById('create-valid-from').value = formatDateTimeForInput(tomorrow);
                    document.getElementById('create-valid-to').value = formatDateTimeForInput(nextWeek);

                    openModal(createModal);
                });
            });

            // Close Create Modal
            closeCreateModalBtn.addEventListener('click', () => hideModal(createModal));
            cancelCreateModalBtn.addEventListener('click', () => hideModal(createModal));

            // Open Edit Modal
            document.querySelectorAll('.open-edit-modal').forEach(button => {
                button.addEventListener('click', () => {
                    clearErrors(editForm);
                    const couponId = button.dataset.couponId;
                    const couponCode = button.dataset.couponCode;
                    const couponType = button.dataset.couponType;
                    const couponValue = button.dataset.couponValue;
                    const validFrom = button.dataset.couponValidFrom;
                    const validTo = button.dataset.couponValidTo;
                    const isActive = button.dataset.couponIsActive;

                    editForm.action = `/admin/coupons/${couponId}/update`;
                    editForm.querySelector('#edit-coupon-code').value = couponCode;
                    editForm.querySelector('#edit-coupon-type').value = couponType;
                    editForm.querySelector('#edit-coupon-value').value = couponValue;
                    editForm.querySelector('#edit-valid-from').value = formatDateTimeForInput(validFrom);
                    editForm.querySelector('#edit-valid-to').value = formatDateTimeForInput(validTo);
                    editForm.querySelector('#edit-is-active').value = isActive;

                    openModal(editModal);
                });
            });

            // Close Edit Modal
            closeEditModalBtn.addEventListener('click', () => hideModal(editModal));
            cancelEditModalBtn.addEventListener('click', () => hideModal(editModal));

            // Delete Coupon
            let couponToDelete = null;
            document.querySelectorAll('.delete-coupon').forEach(button => {
                button.addEventListener('click', () => {
                    couponToDelete = button.dataset.couponId;
                    document.getElementById('delete-coupon-code').textContent = button.dataset.couponCode;
                    openModal(deleteModal);
                });
            });

            // Cancel Delete
            cancelDeleteModalBtn.addEventListener('click', () => {
                hideModal(deleteModal);
                couponToDelete = null;
            });

            // Confirm Delete
            confirmDeleteBtn.addEventListener('click', () => {
                if (!couponToDelete) return;

                showPreloader(confirmDeleteBtn);

                fetch(`/admin/coupons/${couponToDelete}/delete`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        hidePreloader(confirmDeleteBtn);
                        if (data.success) {
                            hideModal(deleteModal);
                            window.location.reload();
                        } else {
                            alertError('Error deleting coupon. Please try again.');
                        }
                    })
                    .catch(error => {
                        hidePreloader(confirmDeleteBtn);
                        console.error('Error:', error);
                        alertError('Error deleting coupon. Please try again.');
                    });
            });

            // Handle Create Form Submission
            createForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const submitButton = this.querySelector('button[type="submit"]');
                showPreloader(submitButton);
                clearErrors(this);

                const formData = new FormData(this);
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        hidePreloader(submitButton);
                        if (data.success) {
                            hideModal(createModal);
                            window.location.reload();
                        } else {
                            if (data.errors) {
                                Object.keys(data.errors).forEach(field => {
                                    const input = createForm.querySelector(`[name="${field}"]`);
                                    showError(input, data.errors[field][0]);
                                });
                            }
                        }
                    })
                    .catch(error => {
                        hidePreloader(submitButton);
                        console.error('Error:', error);
                    });
            });

            // Handle Edit Form Submission
            editForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const submitButton = this.querySelector('button[type="submit"]');
                showPreloader(submitButton);
                clearErrors(this);

                const formData = new FormData(this);
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-HTTP-Method-Override': 'PUT'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        hidePreloader(submitButton);
                        if (data.success) {
                            hideModal(editModal);
                            window.location.reload();
                        } else {
                            if (data.errors) {
                                Object.keys(data.errors).forEach(field => {
                                    const input = editForm.querySelector(`[name="${field}"]`);
                                    showError(input, data.errors[field][0]);
                                });
                            }
                        }
                    })
                    .catch(error => {
                        hidePreloader(submitButton);
                        console.error('Error:', error);
                    });
            });

            // Auto-uppercase coupon codes
            document.querySelectorAll('#create-coupon-code, #edit-coupon-code').forEach(input => {
                input.addEventListener('input', function () {
                    this.value = this.value.toUpperCase();
                });
            });

            // Close modals when clicking outside
            [createModal, editModal, deleteModal].forEach(modal => {
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) {
                        hideModal(modal);
                    }
                });
            });

            // Toast notification function
            const alertError = (message) => {
                iziToast.error({ ...iziToastSettings, message });
            };
        });
    </script>
@endpush
