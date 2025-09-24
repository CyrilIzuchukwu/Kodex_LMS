@extends('layouts.instructor')
@section('content')
    @php
        $name = explode(' ', auth()->user()->name, 2);
        $user_name = $name[0];
    @endphp

    <div class="px-1 md:px-6 lg:px-8 py-4 md:py-6 mb-5">
        <!-- Welcome Section -->
        <div class="mb-6 md:mb-8 animate-fade-in">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 font-Inter tracking-tight">
                Hi, <span class="inline-flex items-center">{{ ucfirst($user_name) }}.</span>
            </h1>
            <p class="text-gray-600 text-base md:text-lg font-medium font-Inter mt-1">
                Manage your course quiz, track progress, and engage with students.
            </p>

            <!-- Quick Actions -->
            <div class="flex flex-col sm:flex-row flex-wrap gap-2 md:gap-3 mt-4 md:mt-6">
                @if($instructor->profile && $instructor->profile->course_id)
                    <a href="{{ route('instructor.courses.manage', $instructor->profile?->course_id) }}" class="bg-[#E68815] text-white px-4 md:px-6 py-2 md:py-3 rounded-xl font-medium font-Inter flex items-center justify-center space-x-2 text-sm md:text-base hover:bg-[#d97706] transition-colors">
                        <i class="uil uil-book-open text-lg md:text-xl"></i>
                        <span>Manage Courses</span>
                    </a>

                    <a href="{{ route('instructor.questions.index', $instructor->profile?->course_id) }}" class="bg-white text-gray-700 px-4 md:px-6 py-2 md:py-3 rounded-xl font-medium font-Inter border border-gray-200 flex items-center justify-center space-x-2 text-sm md:text-base hover:bg-gray-100 transition-colors">
                        <i class="uil uil-question-circle text-lg md:text-xl"></i>
                        <span>Questions & Answers</span>
                    </a>
                @endif

                <a href="{{ route('instructor.notifications.index') }}" class="bg-white text-gray-700 px-4 md:px-6 py-2 md:py-3 rounded-xl font-medium font-Inter border border-gray-200 flex items-center justify-center space-x-2 text-sm md:text-base hover:bg-gray-100 transition-colors">
                    <i class="uil uil-bell text-lg md:text-xl"></i>
                    <span>Notifications</span>
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
            <!-- Card 1: Assigned Courses -->
            <div class="card-hover bg-white backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 shadow-lg border border-white animate-slide-up">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-[#f5ce9f] rounded-xl flex items-center justify-center">
                            <i class="uil uil-book-alt text-white text-lg md:text-xl"></i>
                        </div>

                        <div>
                            <p class="text-gray-600 text-xs md:text-sm font-medium">Active Courses</p>
                            <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $active_courses }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Students -->
            <div class="card-hover bg-white backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 shadow-lg border border-white animate-slide-up" style="animation-delay: 0.1s">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-[#f5ce9f] rounded-xl flex items-center justify-center">
                            <i class="uil uil-users-alt text-white text-lg md:text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-600 text-xs md:text-sm font-medium">Total Students</p>
                            <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $total_students }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Completion Rate -->
            <div class="card-hover bg-white backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 shadow-lg border border-white animate-slide-up sm:col-span-2 lg:col-span-1" style="animation-delay: 0.2s">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-[#f5ce9f] rounded-xl flex items-center justify-center">
                            <i class="uil uil-check-circle text-white text-lg md:text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-600 text-xs md:text-sm font-medium">Completion Rate</p>
                            <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $completion_rate }}%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Table -->
        <div class="bg-white backdrop-blur-sm rounded-xl md:rounded-2xl shadow-lg border border-white overflow-hidden animate-fade-in">
            <div class="p-4 md:p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg md:text-xl font-semibold text-gray-900">Student Management</h3>
                        <p class="text-gray-600 text-sm md:text-base">Track and manage your student progress</p>
                    </div>
                </div>
            </div>

            <!-- Mobile Card View (visible on small screens) -->
            <div class="block md:hidden">
                @forelse($students as $student)
                    <div class="border-b border-gray-100 p-4 hover:bg-gray-50 transition-colors">
                        <!-- Student Info -->
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                                <img class="w-12 h-12 rounded-full object-cover" src="{{ $student->user->profile && $student->user->profile?->profile_photo_path ? $student->user->profile?->profile_photo_path : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($student->user->name, 0, 1) }}" alt="{{ $student->user->name }}">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 truncate">{{ $student->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $student->user->email }}</p>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $student->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($student->status) }}
                            </span>
                        </div>

                        <!-- Course Info -->
                        <div class="mb-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $student->course?->title ?? 'N/A' }}
                            </span>
                        </div>

                        <!-- Progress -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Progress</span>
                                <span class="text-sm font-medium text-gray-700">{{ round($student->progress) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-brand h-2 rounded-full" style="width: {{ round($student->progress) }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500">{{ $student->lessons_completed }}/{{ $student->modules_count }} lessons completed</p>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="uil uil-users-alt text-2xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-600">No students found.</p>
                        <p class="text-sm text-gray-500 mt-1">Students will appear here once they enroll in your courses.</p>
                    </div>
                @endforelse
            </div>

            <!-- Desktop Table View (hidden on small screens) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Student</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Contact</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Course</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 hidden lg:table-cell">Progress</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($students as $student)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                                            <img class="w-10 h-10 rounded-full object-cover" src="{{ $student->user->profile && $student->user->profile?->profile_photo_path ? $student->user->profile?->profile_photo_path : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($student->user->name, 0, 1) }}" alt="{{ $student->user->name }}">
                                        </div>

                                        <div>
                                            <p class="font-medium text-gray-900">{{ $student->user->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $student->lessons_completed }}/{{ $student->modules_count }} lessons</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-sm text-gray-900">{{ $student->user->email }}</p>
                                        <p class="text-sm text-gray-500">{{ $student->user->profile?->phone_number ?? '(123) 456 7890' }}</p>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        {{ $student->course?->title ?? 'N/A' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 hidden lg:table-cell">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-1 bg-gray-200 rounded-full h-2">
                                            <div class="bg-brand h-2 rounded-full" style="width: {{ round($student->progress) }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">{{ round($student->progress) }}%</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $student->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($student->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                        <i class="uil uil-users-alt text-2xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-600">No students found.</p>
                                    <p class="text-sm text-gray-500 mt-1">Students will appear here once they enroll in your courses.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($students->count() > 0)
                <div class="px-4 md:px-6 py-4 border-t border-gray-100">
                    <!-- Pagination -->
                    {{ $students->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @media (min-width: 768px) {
            .card-hover:hover {
                transform: translateY(-8px);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            }
        }
        .progress-ring {
            transition: stroke-dashoffset 0.35s;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        /* Mobile-specific styles */
        @media (max-width: 640px) {
            .animate-slide-up {
                animation-delay: 0s !important;
            }
        }

        /* Ensure images are properly sized */
        img {
            object-fit: cover;
        }
    </style>
@endpush
