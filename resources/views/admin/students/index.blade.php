@extends('layouts.admin')
@section('content')
    <div id="studentManagement">
        <!-- Page Header -->
        <p class="text-base md:text-lg font-medium text-[#5D5D5D] mb-8 md:mb-16">
            User Management > <span class="text-[#848484]">Students</span>
        </p>

        <!-- Action Bar -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full lg:w-auto">
                <button id="addStudentBtn" class="bg-[#E68815] px-4 md:px-6 py-3 rounded-full text-sm md:text-base font-medium text-white hover:bg-[#cc6f0f] transition-colors">
                    + Add Student
                </button>

                <div class="w-full sm:w-auto">
                    <span class="flex items-center bg-[#EDEDED] rounded-full px-4 w-full sm:w-[280px] lg:w-[20vw]">
                        <i class="uil uil-search text-[#141B34] text-lg mr-2"></i>
                        <input type="search" placeholder="Search" class="bg-transparent outline-none border-0 w-full py-3 text-[#141B34] font-medium text-sm md:text-base">
                    </span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                <button class="bg-[#F5CE9F] text-[#8C530D] text-sm md:text-base px-6 md:px-10 py-3 rounded-full font-medium hover:bg-[#e6bb85] transition-colors">
                    All
                </button>

                <div class="relative w-full sm:w-64">
                    <button id="courseDropdown" class="w-full bg-[#EDEDED] rounded-full px-4 md:px-7 py-3 text-[#141B34] font-medium hover:bg-gray-300 transition-all flex justify-between items-center text-sm md:text-base">
                        <span id="selectedCourse">Status</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" id="dropdownIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="dropdownMenu" class="absolute mt-2 w-full bg-white text-black text-sm rounded-2xl shadow-lg overflow-hidden z-50 hidden">
                        <ul>
                            <li class="dropdown-option px-4 md:px-7 py-3 hover:bg-[#E68815] hover:text-white font-medium cursor-pointer transition-colors" data-value="Active Users">
                                Active Users
                            </li>
                            <li class="dropdown-option px-4 md:px-7 py-3 hover:bg-[#E68815] hover:text-white font-medium cursor-pointer transition-colors" data-value="Banned">
                                Banned
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="w-auto bg-white rounded-[20px] md:rounded-[30px] px-2 md:px-3 py-3 shadow-sm overflow-hidden">
            <div class="overflow-x-auto bg-white mb-10 md:mb-20 rounded-[20px] md:rounded-[30px]">
                <table class="min-w-full divide-y divide-gray-200 border-collapse">
                    <thead class="bg-[#EDEDED]">
                    <tr>
                        <th class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center">#</th>
                        <th class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-left">Student Name</th>
                        <th class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center hidden sm:table-cell">Email</th>
                        <th class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center hidden md:table-cell">Phone</th>
                        <th class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center hidden md:table-cell">Status</th>
                        <th class="px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody class="bg-[#fcfafa] divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 text-center">1</td>

                        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-800">
                            <div class="flex items-center">
                                <img class="w-8 h-8 md:w-10 md:h-10 rounded-full mr-3" src="{{ asset('dashboard_assets/images/img/photo.png') }}" alt="Student image">
                                <span class="font-medium">Jese Leos</span>
                            </div>
                        </td>

                        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 hidden sm:table-cell text-center">john@example.com</td>

                        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 hidden md:table-cell text-center">+123456789</td>

                        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 hidden md:table-cell text-center">
                            <div class="flex items-center justify-center">
                                <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div>
                                <span>Active</span>
                            </div>
                        </td>

                        <td class="px-2 md:px-6 py-4 text-center">
                            <div class="flex justify-center">
                                <button class="text-gray-400 hover:text-gray-600 transition-colors toggle-action-card">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Action Card -->
            <div id="action-card" class="fixed hidden w-48 bg-white rounded-lg shadow-xl border border-gray-200 z-50 overflow-hidden">
                <a href="#" class="block w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 border-b border-gray-100 transition-colors">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit User
                    </div>
                </a>

                <button class="deleteBtn block w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </div>
                </button>
            </div>

            <!-- Pagination -->
            <div class="flex flex-col sm:flex-row justify-between text-black font-medium items-center gap-4">
                <div>
                    <p class="text-xs md:text-sm">Showing <span>1</span> to 5 of 5 entries</p>
                </div>
                <div class="flex gap-2">
                    <button class="bg-[#EDEDED] text-black px-4 md:px-10 py-2 md:py-3 text-xs md:text-sm rounded-full font-medium hover:bg-gray-200 transition-colors">
                        Prev
                    </button>

                    <span class="border px-3 md:px-6 py-2 md:py-3 rounded-full text-xs md:text-sm bg-white text-black">5</span>

                    <button class="bg-[#E68815] text-white px-4 md:px-10 py-2 md:py-3 text-xs md:text-sm rounded-full font-medium hover:bg-amber-600 transition-colors">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .modal-content {
            transform: scale(0.95) translateY(-20px);
            opacity: 0;
            transition: all 0.3s ease-in-out;
        }
        .modal-content.show {
            transform: scale(1) translateY(0);
            opacity: 1;
        }
    </style>
@endpush
