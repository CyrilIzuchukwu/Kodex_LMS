@extends('layouts.admin')
@section('content')
    <div class="mb-6">
        <nav class="bg-white rounded-[20px] md:rounded-[30px] shadow-sm px-4 md:px-6 py-3 flex items-center justify-start w-full">
            <ol class="flex items-center space-x-2 md:space-x-3 text-sm md:text-base font-medium text-[#141B34]">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-[#E68815] transition-colors duration-200 flex items-center">
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
                    <span class="text-[#E68815] font-semibold">Login History</span>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Table Container -->
    <div class="w-auto bg-white rounded-[20px] md:rounded-[30px] px-2 md:px-3 py-3 shadow-sm overflow-hidden">
        <div class="overflow-x-auto bg-white mb-10 md:mb-20 rounded-[20px] md:rounded-[30px]">
            <table class="min-w-full divide-y divide-gray-200 border-collapse">
                <thead class="bg-[#EDEDED]">
                    <tr>
                        <th class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center">#</th>
                        <th class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-left">User</th>
                        <th class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center hidden sm:table-cell">IP Address</th>
                        <th class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center hidden md:table-cell">User Agent</th>
                        <th class="px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center">Login Time</th>
                    </tr>
                </thead>
                <tbody class="bg-[#fcfafa] divide-y divide-gray-200">
                    @include('admin.reports.login-history-items', ['loginHistories' => $loginHistories])
                </tbody>
            </table>
        </div>

        {{ $loginHistories->links('vendor.pagination.tailwind') }}
    </div>
@endsection
