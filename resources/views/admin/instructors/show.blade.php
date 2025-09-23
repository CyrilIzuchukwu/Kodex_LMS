@extends('layouts.admin')
@section('content')
    <div class="mb-6 px-4 sm:px-6">
        <nav class="bg-white rounded-2xl shadow-sm px-4 sm:px-6 py-3 flex items-center justify-start w-full">
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
                    <a href="{{ route('admin.instructors.index') }}" class="hover:text-[#E68815] transition-colors duration-200 flex items-center">
                        Instructors
                    </a>
                </li>
                <li>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </li>
                <li>
                    <span class="text-[#E68815] font-semibold">{{ $instructor->name }}</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-1500px">
        <!-- Profile Information Section -->
        <div class="pt-4 mb-8">
            <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 items-center">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full border-4 border-white shadow-lg avatar bg-gray-800 flex items-center justify-center text-white font-bold text-xl sm:text-2xl" style="background-image: url({{ $instructor->profile && $instructor->profile?->profile_photo_path ? $instructor->profile?->profile_photo_path : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($instructor->name, 0, 1) }});"></div>
                </div>
                <!-- Instructor Info -->
                <div class="flex-grow text-center sm:text-left">
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">{{ $instructor->name }}</h3>
                    <p class="text-gray-600 mb-3 text-sm sm:text-base">{{ $instructor->email }}</p>
                    <div class="flex flex-wrap justify-center sm:justify-start gap-3 sm:gap-4">
                        @if ($instructor->hasSocialAccount('google'))
                            <div class="inline-flex items-center h-10 px-3 py-1.5 text-xs font-medium text-white bg-green-600 rounded-full hover:bg-green-700 transition-colors duration-150 space-x-2">
                                <div class="w-6 h-6 rounded-full bg-white flex items-center justify-center">
                                    <i class="uil uil-google text-base text-green-600"></i>
                                </div>
                                <span>Google Connected</span>
                            </div>
                        @else
                            <div class="inline-flex items-center h-10 px-3 py-1.5 text-xs font-medium text-gray-700 bg-gray-200 rounded-full hover:bg-gray-300 transition-colors duration-150 space-x-2">
                                <div class="w-6 h-6 rounded-full bg-white flex items-center justify-center">
                                    <i class="uil uil-google text-base text-gray-500"></i>
                                </div>
                                <span>Not Connected</span>
                            </div>
                        @endif
                        <span class="inline-flex items-center h-10 px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium {{ $instructor->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            <i class="uil uil-circle mr-1 text-xs"></i>
                            {{ ucfirst($instructor->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-8">
            <div></div>
            <div class="flex flex-wrap justify-center gap-2 sm:gap-3">
                <a href="{{ route('admin.instructors.index') }}" class="inline-flex items-center px-3 sm:px-4 py-2 border border-gray-300 rounded-2xl text-xs sm:text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    <i class="uil uil-arrow-left mr-1 sm:mr-2"></i>Go Back
                </a>
                <a href="{{ route('admin.instructors.edit', $instructor->id) }}" class="inline-flex items-center px-3 sm:px-4 py-2 bg-[#EB8C22] text-white rounded-2xl text-xs sm:text-sm font-medium hover:bg-[#D47A1E] transition-colors">
                    <i class="uil uil-pen mr-1 sm:mr-2"></i>Edit Profile
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left Sidebar -->
            <div class="lg:col-span-3">
                <!-- Instructor Information -->
                <div class="bg-white border border-gray-200 rounded-2xl mb-6">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <h5 class="font-semibold text-gray-900 text-sm sm:text-base">Instructor Information</h5>
                    </div>
                    <div class="p-4">
                        <div class="space-y-3 sm:space-y-4">
                            <div class="flex justify-between text-xs sm:text-sm">
                                <span class="font-medium text-gray-700">Full Name:</span>
                                <span class="text-gray-600">{{ $instructor->name }}</span>
                            </div>

                            <div class="flex justify-between text-xs sm:text-sm">
                                <span class="font-medium text-gray-700">Mobile:</span>
                                <span class="text-gray-600">{{ $instructor->profile?->phone_number ?? 'N/A' }}</span>
                            </div>

                            <div class="flex justify-between text-xs sm:text-sm">
                                <span class="font-medium text-gray-700">E-mail:</span>
                                <span class="text-gray-600">{{ $instructor->email }}</span>
                            </div>

                            <div class="flex justify-between text-xs sm:text-sm">
                                <span class="font-medium text-gray-700">Assigned Course:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs sm:text-sm font-medium bg-gray-200 text-gray-800">
                                    <a href="{{ route('admin.categories.show', $instructor->profile?->course?->category->slug ?? '#') }}">
                                        @truncate($instructor->profile?->course?->title ?? 'Not Assigned', 15)
                                    </a>
                                </span>
                            </div>

                            <div class="flex justify-between text-xs sm:text-sm">
                                <span class="font-medium text-gray-700">Registered:</span>
                                <span class="text-gray-600">{{ getTime($instructor->created_at) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white border border-gray-200 rounded-2xl mb-6">
                    <div class="p-4 border-b border-gray-200">
                        <h5 class="font-semibold text-gray-900 text-sm sm:text-base">Actions</h5>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-1 gap-2">
                            <button class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors" onclick="openModal('manageCoursesModal')">
                                <i class="uil uil-book-open mr-2"></i>Manage Courses
                            </button>

                            <button class="w-full inline-flex items-center justify-center px-3 sm:px-4 py-2 bg-blue-600 text-white rounded-lg text-xs sm:text-sm font-medium hover:bg-blue-700 transition-colors" onclick="openModal('notificationModal')">
                                <i class="uil uil-bell mr-1 sm:mr-2"></i>Send Notification
                            </button>

                            <button class="w-full inline-flex items-center justify-center px-3 sm:px-4 py-2 bg-blue-600 text-white rounded-lg text-xs sm:text-sm font-medium hover:bg-blue-700 transition-colors" onclick="openModal('passwordModal')">
                                <i class="uil uil-lock-open-alt mr-1 sm:mr-2"></i>Reset Password
                            </button>

                            <button class="w-full inline-flex items-center justify-center px-3 sm:px-4 py-2 bg-blue-600 text-white rounded-lg text-xs sm:text-sm font-medium hover:bg-blue-700 transition-colors" onclick="openModal('loginAsUserModal')">
                                <i class="uil uil-sign-in-alt mr-1 sm:mr-2"></i>Login As Instructor
                            </button>

                            @if($instructor->status == 'active')
                                <button class="w-full inline-flex items-center justify-center px-3 sm:px-4 py-2 bg-blue-600 text-white rounded-lg text-xs sm:text-sm font-medium hover:bg-blue-700 transition-colors" onclick="openModal('suspendModal')">
                                    <i class="uil uil-ban mr-1 sm:mr-2"></i>Suspend Account
                                </button>
                            @else
                                <button class="w-full inline-flex items-center justify-center px-3 sm:px-4 py-2 bg-blue-600 text-white rounded-lg text-xs sm:text-sm font-medium hover:bg-blue-700 transition-colors" onclick="openModal('unsuspendModal')">
                                    <i class="uil uil-ban mr-1 sm:mr-2"></i>Unsuspend Account
                                </button>
                            @endif

                            <button class="w-full inline-flex items-center justify-center px-3 sm:px-4 py-2 bg-red-600 text-white rounded-lg text-xs sm:text-sm font-medium hover:bg-red-700 transition-colors" onclick="openModal('deleteModal')">
                                <i class="uil uil-trash-alt mr-1 sm:mr-2"></i>Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Content -->
            <div class="lg:col-span-9">
                <!-- Learning Summary -->
                <div class="bg-white border border-gray-200 rounded-2xl mb-6">
                    <div class="grid grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-gray-200">
                        <div class="p-4 sm:p-6 flex flex-col h-full">
                            <div class="flex justify-between items-center mb-4">
                                <h5 class="text-xs font-medium text-gray-500 uppercase tracking-wide">Courses Assigned</h5>
                                <i class="uil uil-arrow-circle-up text-[#EB8C22] text-lg sm:text-xl"></i>
                            </div>
                            <div class="flex items-center mt-auto">
                                <i class="uil uil-book-open text-3xl sm:text-4xl text-gray-400 mr-3 sm:mr-4"></i>
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-900">1</h3>
                            </div>
                        </div>

                        <div class="p-4 sm:p-6 flex flex-col h-full">
                            <div class="flex justify-between items-center mb-4">
                                <h5 class="text-xs font-medium text-gray-500 uppercase tracking-wide">Students Enrolled</h5>
                            </div>
                            <div class="flex items-center mt-auto">
                                <i class="uil uil-user-circle text-3xl sm:text-4xl text-gray-400 mr-3 sm:mr-4"></i>
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $enrolled_students }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="bg-white border border-gray-200 rounded-2xl">
                    <div class="p-4 sm:p-6">
                        <h5 class="text-base sm:text-lg font-semibold text-gray-900 mb-4">Student List</h5>
                        <div class="bg-white border border-gray-200 rounded-2xl mb-6">
                            <div class="p-4 border-b border-gray-200">
                                <h5 class="font-semibold text-gray-900 text-sm sm:text-base">Enrolled Students</h5>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full min-w-[640px]">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                                            <th class="px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                            <th class="px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completed</th>
                                            <th class="px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrolled Date</th>
                                            <th class="px-4 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($students as $student)
                                            <tr>
                                                <td class="px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-600">{{ $student->user->name }}</td>
                                                <td class="px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-600">{{ $student->course?->title ?? 'N/A' }}</td>
                                                <td class="px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-600">
                                                    {{ $student->lessons_completed }}/{{ $student->modules_count }} lessons
                                                </td>
                                                <td class="px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-600">{{ $student->created_at ? getTime($student->created_at) : 'N/A' }}</td>
                                                <td class="px-4 py-3 sm:py-4 whitespace-nowrap">
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $student->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                        {{ ucfirst($student->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-4 py-3 sm:py-4 text-center text-sm text-gray-600">No students found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{ $students->links('vendor.pagination.tailwind') }}
                    </div>
                </div>

                <!-- Manage Course Modal -->
                <div id="manageCoursesModal" class="fixed hidden inset-0 bg-black bg-opacity-75 backdrop-blur-sm justify-center items-center z-[9999] overflow-y-auto pt-8 pb-8 px-4 md:px-0 opacity-0 transition-all duration-300 ease-in-out" role="dialog" aria-modal="true">
                    <div class="bg-[#F9FAFC] modal-content rounded-[20px] relative shadow-lg max-w-[100%] w-[600px] p-6 md:p-10 z-[10000] self-start mt-8 mb-8 transform scale-95 transition-transform duration-300 ease-in-out">
                        <div class="absolute -top-4 -right-4">
                            <button onclick="closeModal('manageCoursesModal')" class="w-[50px] h-[50px] flex items-center justify-center rounded-full bg-white shadow-md text-black text-2xl leading-none hover:bg-gray-100 focus:outline-none" style="box-shadow: 0 2px 4px 0 #00000040;">
                                &times;
                            </button>
                        </div>
                        <form id="manage-courses-form" action="{{ route('admin.instructors.assign.course', $instructor->id) }}" method="POST">
                            @csrf

                            <div class="mb-6">
                                <div class="flex items-center space-x-2 mb-8">
                                    <div class="w-10 h-10 rounded-full bg-[#E68815] flex items-center justify-center">
                                        <i class="uil uil-calendar text-white"></i>
                                    </div>
                                    <h3 class="text-base font-medium text-[#1B1B1B]">Manage Courses</h3>
                                </div>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label for="course" class="block text-sm font-medium text-[#1B1B1B] mb-2">Select Courses to Assign *</label>
                                        <select name="course" id="course" class="w-full px-4 py-3 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 appearance-none cursor-pointer placeholder:text-gray-500 invalid:text-gray-500">
                                            <option value="" disabled selected>Select a course</option>
                                            @foreach($instructorAssignedCourses as $course)
                                                <option value="{{ $course->id }}" {{ old('course', $instructor->profile?->course_id) == $course->id ? 'selected' : '' }}>
                                                    {{ $course->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-red-500 text-xs mt-1 hidden error-message">Please select at least one course</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row justify-end gap-4 mt-8 w-full">
                                <button type="button" onclick="closeModal('manageCoursesModal')" class="bg-[#EDEDED] w-full md:w-[200px] text-gray-800 text-sm font-medium px-6 py-3 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                    Cancel
                                </button>
                                <button type="submit" class="bg-[#E68815] w-full md:w-auto text-white text-sm px-6 py-3 rounded-full hover:bg-[#cc6f0f] focus:outline-none focus:ring-2 focus:ring-[#E68815] flex items-center justify-center">
                                    <span class="submit-text">Save Changes</span>
                                    <span class="preloader flex items-center justify-center gap-2 hidden">
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                        </svg>
                                        Processing...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Notification Modal -->
                <div id="notificationModal" class="fixed hidden inset-0 bg-black bg-opacity-75 backdrop-blur-sm justify-center items-center z-[9999] overflow-y-auto pt-8 pb-8 px-4 md:px-0 opacity-0 transition-all duration-300 ease-in-out" role="dialog" aria-modal="true">
                    <div class="bg-[#F9FAFC] modal-content rounded-[20px] relative shadow-lg max-w-[100%] w-[600px] p-6 md:p-10 z-[10000] self-start mt-8 mb-8 transform scale-95 transition-transform duration-300 ease-in-out">
                        <div class="absolute -top-4 -right-4">
                            <button onclick="closeModal('notificationModal')" class="w-[50px] h-[50px] flex items-center justify-center rounded-full bg-white shadow-md text-black text-2xl leading-none hover:bg-gray-100 focus:outline-none" style="box-shadow: 0 2px 4px 0 #00000040;">
                                &times;
                            </button>
                        </div>
                        <form id="notification-form" action="{{ route('admin.instructors.send.notification', $instructor->id) }}" method="POST">
                            @csrf
                            <div class="mb-6">
                                <div class="flex items-center space-x-2 mb-8">
                                    <div class="w-10 h-10 rounded-full bg-[#E68815] flex items-center justify-center">
                                        <i class="uil uil-bell text-white"></i>
                                    </div>
                                    <h3 class="text-base font-medium text-[#1B1B1B]">Send Notification</h3>
                                </div>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label for="notification-title" class="block text-sm font-medium text-[#1B1B1B] mb-2">Notification Title *</label>
                                        <input id="notification-title" name="subject" type="text" class="w-full border h-12 border-gray-300 rounded-lg p-2 pl-3 focus:border-[#E68815] text-black text-sm focus:ring-1 focus:ring-[#E68815]" placeholder="Enter notification title">
                                        <span class="text-red-500 text-xs mt-1 hidden error-message">This field is required</span>
                                    </div>
                                    <div>
                                        <label for="notification-message" class="block text-sm font-medium text-[#1B1B1B] mb-2">Notification Message *</label>
                                        <textarea id="notification-message" name="message" class="w-full border h-24 border-gray-300 rounded-lg p-2 pl-3 focus:border-[#E68815] text-black text-sm focus:ring-1 focus:ring-[#E68815]" placeholder="Enter notification message"></textarea>
                                        <span class="text-red-500 text-xs mt-1 hidden error-message">This field is required</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row justify-end gap-4 mt-8 w-full">
                                <button type="button" onclick="closeModal('notificationModal')" class="bg-[#EDEDED] w-full md:w-[200px] text-gray-800 text-sm font-medium px-6 py-3 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                    Cancel
                                </button>
                                <button type="submit" class="bg-[#E68815] w-full md:w-auto text-white text-sm px-6 py-3 rounded-full hover:bg-[#cc6f0f] focus:outline-none focus:ring-2 focus:ring-[#E68815] flex items-center justify-center">
                                    <span class="submit-text">Send Notification</span>
                                    <span class="preloader flex items-center justify-center gap-2 hidden">
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                        </svg>
                                        Processing...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Password Modal -->
                <div id="passwordModal" class="fixed hidden inset-0 bg-black bg-opacity-75 backdrop-blur-sm justify-center items-center z-[9999] overflow-y-auto pt-8 pb-8 px-4 md:px-0 opacity-0 transition-all duration-300 ease-in-out" role="dialog" aria-modal="true">
                    <div class="bg-[#F9FAFC] modal-content rounded-[20px] relative shadow-lg max-w-[100%] w-[600px] p-6 md:p-10 z-[10000] self-start mt-8 mb-8 transform scale-95 transition-transform duration-300 ease-in-out">
                        <div class="absolute -top-4 -right-4">
                            <button onclick="closeModal('passwordModal')" class="w-[50px] h-[50px] flex items-center justify-center rounded-full bg-white shadow-md text-black text-2xl leading-none hover:bg-gray-100 focus:outline-none" style="box-shadow: 0 2px 4px 0 #00000040;">
                                &times;
                            </button>
                        </div>
                        <form id="password-form" action="{{ route('admin.instructors.reset.password', $instructor->id) }}" method="POST">
                            @csrf
                            <div class="mb-6">
                                <div class="flex items-center space-x-2 mb-8">
                                    <div class="w-10 h-10 rounded-full bg-[#E68815] flex items-center justify-center">
                                        <i class="uil uil-lock-open-alt text-white"></i>
                                    </div>
                                    <h3 class="text-base font-medium text-[#1B1B1B]">Reset Password</h3>
                                </div>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-[#1B1B1B] mb-2">New Password *</label>
                                        <input id="password" name="password" type="password" class="w-full border h-12 border-gray-300 rounded-lg p-2 pl-3 focus:border-[#E68815] text-black text-sm focus:ring-1 focus:ring-[#E68815]" placeholder="Enter new password">
                                        <p class="text-xs text-[#EB8C22] mt-2">At least 8 characters with numbers and symbols</p>
                                        <span class="text-red-500 text-xs mt-1 hidden error-message">This field is required</span>
                                    </div>
                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-[#1B1B1B] mb-2">Confirm Password *</label>
                                        <input id="password_confirmation" name="password_confirmation" type="password" class="w-full border h-12 border-gray-300 rounded-lg p-2 pl-3 focus:border-[#E68815] text-black text-sm focus:ring-1 focus:ring-[#E68815]" placeholder="Confirm new password">
                                        <span class="text-red-500 text-xs mt-1 hidden error-message">This field is required</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row justify-end gap-4 mt-8 w-full">
                                <button type="button" onclick="closeModal('passwordModal')" class="bg-[#EDEDED] w-full md:w-[200px] text-gray-800 text-sm font-medium px-6 py-3 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                    Cancel
                                </button>
                                <button type="submit" class="bg-[#E68815] w-full md:w-auto text-white text-sm px-6 py-3 rounded-full hover:bg-[#cc6f0f] focus:outline-none focus:ring-2 focus:ring-[#E68815] flex items-center justify-center">
                                    <span class="submit-text">Reset Password</span>
                                    <span class="preloader flex items-center justify-center gap-2 hidden">
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                        </svg>
                                        Processing...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Suspend Modal -->
                <div id="suspendModal" class="fixed hidden inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-[9999] p-4 opacity-0 transition-all duration-300 ease-in-out">
                    <div class="modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-full max-w-sm md:max-w-md h-auto p-4 md:p-6 flex flex-col items-center justify-center z-[10000] transform scale-95 transition-transform duration-300 ease-in-out">
                        <img src="{{ asset('dashboard_assets/images/img/logout-modal-icon.png') }}" alt="suspend" class="w-12 h-12 md:w-16 md:h-16 mb-4">
                        <h2 class="text-base md:text-lg font-semibold text-gray-800 mb-4 text-center">Suspend Account?</h2>
                        <p class="text-gray-600 mb-6 text-center text-xs md:text-sm">
                            Are you sure you want to suspend this instructor account? This action can be undone.
                        </p>
                        <form id="suspend-form" action="{{ route('admin.instructors.suspend', $instructor->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="flex justify-center gap-3 w-full">
                                <button type="button" onclick="closeModal('suspendModal')" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#EDEDED] text-gray-700 hover:bg-gray-300 transition-colors text-xs md:text-sm">
                                    Cancel
                                </button>
                                <button type="submit" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#E30800] text-white hover:bg-red-600 transition-colors text-xs md:text-sm flex items-center justify-center">
                                    <span class="submit-text">Suspend</span>
                                    <span class="preloader flex items-center justify-center gap-2 hidden">
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                        </svg>
                                        Processing...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Unsuspend Modal -->
                <div id="unsuspendModal" class="fixed hidden inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-[9999] p-4 opacity-0 transition-all duration-300 ease-in-out">
                    <div class="modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-full max-w-sm md:max-w-md h-auto p-4 md:p-6 flex flex-col items-center justify-center z-[10000] transform scale-95 transition-transform duration-300 ease-in-out">
                        <img src="{{ asset('dashboard_assets/images/img/logout-modal-icon.png') }}" alt="unsuspend" class="w-12 h-12 md:w-16 md:h-16 mb-4">
                        <h2 class="text-base md:text-lg font-semibold text-gray-800 mb-4 text-center">Unsuspend Account?</h2>
                        <p class="text-gray-600 mb-6 text-center text-xs md:text-sm">
                            Are you sure you want to unsuspend this instructor account?
                        </p>
                        <form id="unsuspend-form" action="{{ route('admin.instructors.unsuspend', $instructor->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="flex justify-center gap-3 w-full">
                                <button type="button" onclick="closeModal('unsuspendModal')" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#EDEDED] text-gray-700 hover:bg-gray-300 transition-colors text-xs md:text-sm">
                                    Cancel
                                </button>
                                <button type="submit" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#E30800] text-white hover:bg-red-600 transition-colors text-xs md:text-sm flex items-center justify-center">
                                    <span class="submit-text">Unsuspend</span>
                                    <span class="preloader flex items-center justify-center gap-2 hidden">
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                        </svg>
                                        Processing...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div id="deleteModal" class="fixed hidden inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-[9999] p-4 opacity-0 transition-all duration-300 ease-in-out">
                    <div class="modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-full max-w-sm md:max-w-md h-auto p-4 md:p-6 flex flex-col items-center justify-center z-[10000] transform scale-95 transition-transform duration-300 ease-in-out">
                        <img src="{{ asset('dashboard_assets/images/img/gradient.png') }}" alt="delete" class="w-12 h-12 md:w-16 md:h-16 mb-4">
                        <h2 class="text-base md:text-lg font-semibold text-gray-800 mb-4 text-center">Delete Account?</h2>
                        <p class="text-gray-600 mb-6 text-center text-xs md:text-sm">
                            Are you sure you want to delete this instructor account? This action cannot be undone.
                        </p>
                        <form id="delete-form" action="{{ route('admin.instructors.destroy', $instructor->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="flex justify-center gap-3 w-full">
                                <button type="button" onclick="closeModal('deleteModal')" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#EDEDED] text-gray-700 hover:bg-gray-300 transition-colors text-xs md:text-sm">
                                    Cancel
                                </button>
                                <button type="submit" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#E30800] text-white hover:bg-red-600 transition-colors text-xs md:text-sm flex items-center justify-center">
                                    <span class="submit-text">Delete</span>
                                    <span class="preloader flex items-center justify-center gap-2 hidden">
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                        </svg>
                                        Processing...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Login As User Modal -->
                <div id="loginAsUserModal" class="fixed hidden inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-[9999] p-4 opacity-0 transition-all duration-300 ease-in-out">
                    <div class="modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-full max-w-sm md:max-w-md h-auto p-4 md:p-6 flex flex-col items-center justify-center z-[10000] transform scale-95 transition-transform duration-300 ease-in-out">
                        <img src="{{ asset('dashboard_assets/images/img/logout-modal-icon.png') }}" alt="login" class="w-12 h-12 md:w-16 md:h-16 mb-4">
                        <h2 class="text-base md:text-lg font-semibold text-gray-800 mb-4 text-center">Login as Instructor?</h2>
                        <p class="text-gray-600 mb-6 text-center text-xs md:text-sm">
                            Are you sure you want to login as this instructor? This will open their dashboard in a new tab.
                        </p>
                        <form id="login-form" action="{{ route('admin.instructors.login', $instructor->id) }}" method="POST">
                            @csrf
                            <div class="flex justify-center gap-3 w-full">
                                <button type="button" onclick="closeModal('loginAsUserModal')" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#EDEDED] text-gray-700 hover:bg-gray-300 transition-colors text-xs md:text-sm">
                                    Cancel
                                </button>
                                <button type="submit" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#E68815] text-white hover:bg-[#cc6f0f] transition-colors text-xs md:text-sm flex items-center justify-center">
                                    <span class="submit-text">Login</span>
                                    <span class="preloader flex items-center justify-center gap-2 hidden">
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                        </svg>
                                        Processing...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Modal functionality
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modal.classList.remove('opacity-0');
            modal.querySelector('.modal-content').classList.remove('scale-95');
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('opacity-0');
            modal.querySelector('.modal-content').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        // Form handling
        const formFieldMap = {
            'notification-form': [
                { id: 'notification-title', validate: value => value.trim() !== '', error: 'This field is required' },
                { id: 'notification-message', validate: value => value.trim() !== '', error: 'This field is required' }
            ],
            'password-form': [
                { id: 'password', validate: value => value.trim() !== '' && value.length >= 8, error: 'Password must be at least 8 characters' },
                { id: 'password_confirmation', validate: (value, form) => value === form.querySelector('#password').value, error: 'Passwords do not match' }
            ],
            'suspend-form': [],
            'unsuspend-form': [],
            'delete-form': [],
            'login-form': [],
            'manage-courses-form': [
                { id: 'course', validate: value => value.trim() !== '', error: 'Please select at least one course' }
            ]
        };

        // Get CSRF token from meta tag (ensure you have <meta name="csrf-token" content="{{ csrf_token() }}"> in your layout)
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        Object.entries(formFieldMap).forEach(([formId, fields]) => {
            const form = document.getElementById(formId);
            if (!form) return;

            const submitBtn = form.querySelector('[type="submit"]');
            const submitText = submitBtn.querySelector('.submit-text');
            const preloader = submitBtn.querySelector('.preloader');

            // Clear validation on input
            fields.forEach(field => {
                const input = document.getElementById(field.id);
                if (input) {
                    input.addEventListener('input', () => {
                        input.classList.remove('is-invalid', 'is-valid');
                        const errorElement = input.nextElementSibling;
                        if (errorElement && errorElement.classList.contains('error-message')) {
                            errorElement.classList.add('hidden');
                        }
                    });
                }
            });

            form.addEventListener('submit', async e => {
                e.preventDefault();

                // Show spinner
                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                preloader.classList.remove('hidden');

                // Validate fields
                let isValid = true;
                fields.forEach(field => {
                    const input = document.getElementById(field.id);
                    if (!input) return;
                    const errorElement = input.nextElementSibling;
                    const value = input.value.trim();

                    if (!field.validate(value, form)) {
                        input.classList.add('is-invalid');
                        input.classList.remove('is-valid');
                        if (errorElement && errorElement.classList.contains('error-message')) {
                            errorElement.textContent = field.error;
                            errorElement.classList.remove('hidden');
                        }
                        isValid = false;
                    } else {
                        input.classList.add('is-valid');
                        input.classList.remove('is-invalid');
                        if (errorElement && errorElement.classList.contains('error-message')) {
                            errorElement.classList.add('hidden');
                        }
                    }
                });

                if (!isValid) {
                    submitBtn.disabled = false;
                    submitText.classList.remove('hidden');
                    preloader.classList.add('hidden');
                    return;
                }

                try {
                    const formData = new FormData(form);
                    // Add _method for PATCH/DELETE requests if present
                    const methodInput = form.querySelector('input[name="_method"]');
                    const method = methodInput ? methodInput.value.toUpperCase() : form.method.toUpperCase();

                    const response = await fetch(form.action, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json', // Ensure server returns JSON
                        },
                        body: method === 'GET' ? undefined : formData,
                    });

                    // Handle non-JSON responses (e.g., redirects)
                    const contentType = response.headers.get('content-type');
                    let data;

                    if (contentType && contentType.includes('application/json')) {
                        data = await response.json();
                    } else {
                        // Handle redirect or non-JSON response
                        data = { success: response.ok, redirect: response.redirected ? response.url : null };
                    }

                    submitBtn.disabled = false;
                    submitText.classList.remove('hidden');
                    preloader.classList.add('hidden');

                    if (response.ok && data.success) {
                        if (data.redirect) {
                            // Handle redirect (e.g., for login-as-user or other actions)
                            window.open(data.redirect, '_blank');
                        } else {
                            showSuccess(data.message || 'Action completed successfully!');
                            setTimeout(() => {
                                closeModal(formId.replace('-form', 'Modal'));
                                if (formId !== 'login-form') {
                                    location.reload();
                                }
                            }, 1500);
                        }
                    } else {
                        showError(data.message || 'An error occurred. Please try again.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    submitBtn.disabled = false;
                    submitText.classList.remove('hidden');
                    preloader.classList.add('hidden');
                    showError('An error occurred. Please try again.');
                }
            });
        });

        const showError = (message) => {
            iziToast.error({ ...iziToastSettings, message });
        };

        const showSuccess = (message) => {
            iziToast.success({ ...iziToastSettings, message });
        };
    </script>
@endpush

@push('styles')
    <style>
        .avatar {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .tab-content > .tab-pane {
            display: none;
        }
        .tab-content > .tab-pane.active {
            display: block;
        }
        .is-invalid {
            border-color: #e3342f !important;
        }
        .is-valid {
            border-color: #38c172 !important;
        }
        @media (max-width: 640px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            table {
                font-size: 0.75rem;
            }
            th, td {
                padding: 0.5rem;
            }
        }
    </style>
@endpush
