@extends('layouts.admin')
@section('content')
    <div class="mb-6 px-4 md:px-6">
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
                    <span class="text-[#E68815] font-semibold">Announcements</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="container mx-auto mt-4 mb-5" id="main-content">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
            <!-- Sidebar -->
            <div class="col-span-1 md:col-span-4 lg:col-span-4">
                <div class="sticky top-20">
                    <div class="w-auto bg-white rounded-[20px] md:rounded-[30px] px-6 md:px-8 py-6 md:py-8 shadow-sm overflow-hidden">
                        <ul class="space-y-4">
                            <!-- Create Announcement -->
                            <li>
                                <a class="flex items-center space-x-3 p-2 rounded-lg text-[#1B1B1B] hover:bg-[#F5CE9F] transition"
                                   href="{{ route('admin.announcements.create') }}">
                                    <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                        <i class="uil uil-voicemail text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-[18px] leading-[100%]">Create Announcement</p>
                                        <p class="text-sm text-[#6B7280]">Draft and send new announcements.</p>
                                    </div>
                                </a>
                            </li>

                            <!-- Announcements -->
                            <li>
                                <a class="flex items-center space-x-3 p-2 rounded-lg bg-[#F5CE9F] text-[#1B1B1B] hover:bg-[#EFCF9F] transition"
                                   href="{{ route('admin.announcements.index') }}">
                                    <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                        <i class="uil uil-megaphone text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-[18px] leading-[100%]">Announcements</p>
                                        <p class="text-sm text-[#6B7280]">Manage platform-wide announcements.</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-span-1 md:col-span-8 lg:col-span-8">
                <div class="w-auto bg-white rounded-[20px] md:rounded-[30px] px-6 md:px-8 py-6 md:py-8 shadow-sm overflow-hidden">
                    <!-- Header -->
                    <div class="flex items-center space-x-3 mb-12">
                        <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                            <i class="uil uil-megaphone text-xl"></i>
                        </div>
                        <h2 class="font-medium text-[18px] leading-[100%] text-[#1B1B1B]">Announcements</h2>
                    </div>

                    <!-- Announcements Table -->
                    <div class="overflow-x-auto mb-5">
                        <table class="w-full text-sm text-left text-[#1B1B1B]">
                            <thead class="text-xs text-[#6B7280] uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Title</th>
                                    <th scope="col" class="px-6 py-3">Target</th>
                                    <th scope="col" class="px-6 py-3">Published</th>
                                    <th scope="col" class="px-6 py-3">Attachment</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($announcements as $announcement)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-[#1B1B1B]">
                                        {{ $announcement->title }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                                            @if($announcement->target === 'all')
                                                bg-green-100 text-green-800
                                            @elseif($announcement->target === 'students')
                                                bg-blue-100 text-blue-800
                                            @elseif($announcement->target === 'instructors')
                                                bg-yellow-100 text-yellow-800
                                            @else
                                                bg-purple-100 text-purple-800
                                            @endif">
                                            {{ ucfirst($announcement->target) }}
                                            @if($announcement->target === 'specific_courses' && $announcement->courses->isNotEmpty())
                                                <br>
                                                <span class="text-xs text-gray-600">
                                                    ({{ $announcement->courses->pluck('title')->implode(', ') }})
                                                </span>
                                            @endif
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $announcement->created_at->format('M d, Y H:i') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($announcement->attachment_url)
                                            <a href="{{ $announcement->attachment_url }}" class="text-[#E68815] hover:text-[#d1761a]" target="_blank">Download</a>
                                        @else
                                            <span class="text-gray-500">None</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="hover:bg-gray-100">
                                    <td colspan="5" class="px-6 py-4 text-sm text-gray-500 text-center">
                                        No Announcements Made
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $announcements->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
@endsection
