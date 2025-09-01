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
                    <span class="text-[#E68815] font-semibold">{{ $category->name }}</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="w-auto bg-white rounded-[24px] px-4 md:px-6 py-6 shadow-sm overflow-hidden mt-4">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8 w-full">
            <!-- Search Bar -->
            <div class="relative w-full md:max-w-xs">
                <form action="" id="searchForm" onsubmit="return false;">
                        <span class="absolute left-4 top-[14px] text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                            </svg>
                        </span>
                    <input type="search" id="searchInput" placeholder="Search" value="{{ $searchQuery ?? '' }}" class="w-full pl-10 pr-4 py-3 border-none rounded-full bg-gray-100 focus:outline-none focus:ring-1 focus:border-none focus:ring-[#cc770f] text-sm text-gray-700 placeholder-gray-500" />
                </form>
            </div>

            <!-- Add Course Button -->
            <a href="{{ route('admin.courses.add.details') }}" class="w-full md:w-auto flex items-center justify-center space-x-1 bg-[#E68815] hover:bg-[#cc770f] text-white text-sm font-medium px-5 py-3 rounded-full shadow">
                <i class="uil uil-plus text-sm font-medium"></i>
                <span>Add Course</span>
            </a>
        </div>

        <div class="w-auto overflow-hidden">
            <div class="overflow-x-auto bg-white mb-4 md:mb-4 rounded-[20px] md:rounded-[30px]" id="content-container">
                <!-- Table Structure -->
                <table class="min-w-full divide-y divide-gray-200 border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-5 py-3 text-xs font-medium text-gray-500 text-center sm:px-6 sm:text-sm">
                                #
                            </th>

                            <th class="px-5 py-3 text-xs font-medium text-gray-500 text-center sm:px-6 sm:text-sm">
                                Course Title
                            </th>

                            <th class="px-5 py-3 text-xs font-medium text-gray-500 text-center sm:table-cell sm:px-6 sm:text-sm">
                                Instructor
                            </th>

                            <th class="px-5 py-3 text-xs font-medium text-gray-500 text-center sm:table-cell sm:px-6 sm:text-sm">
                                Students
                            </th>

                            <th class="px-5 py-3 text-xs font-medium text-gray-500 text-center sm:px-6 sm:text-sm">
                                Category
                            </th>

                            <th class="px-5 py-3 text-xs font-medium text-gray-500 text-center sm:table-cell sm:px-6 sm:text-sm">
                                Modules
                            </th>

                            <th class="px-5 py-3 text-xs font-medium text-gray-500 text-center md:table-cell sm:px-6 sm:text-sm">
                                Price
                            </th>

                            <th class="px-5 py-3 text-xs font-medium text-gray-500 text-center sm:px-6 sm:text-sm">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="course-table-body">
                        @include('admin.courses.course-item', ['courses' => $courses])
                    </tbody>
                </table>
            </div>

            <div id="pagination">
                {{ $courses->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
@endsection
