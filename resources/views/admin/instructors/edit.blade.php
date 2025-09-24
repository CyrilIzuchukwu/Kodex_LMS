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
                    <a href="{{ route('admin.instructors.index') }}" class="hover:text-[#E68815] transition-colors duration-200 flex items-center">
                        Instructor
                    </a>
                </li>

                <li>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </li>

                <li>
                    <span class="text-[#E68815] font-semibold">Edit Profile</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="container mx-auto mt-4 mb-5 px-4 sm:px-6 lg:px-3" id="main-content">
        <!-- Cover -->
        <div class="bg-white rounded-[20px] md:rounded-[30px] shadow-sm overflow-hidden mb-6 px-4 sm:px-6 md:px-8 py-4 sm:py-6 md:py-8 relative">
            <div class="relative bg-gradient-to-r from-[#E68815] to-[#F5CE9F] h-24 sm:h-32 rounded-t-[20px] -mx-4 -mt-4 sm:-mx-6 sm:-mt-6 md:-mx-8 md:-mt-8"></div>
            <div class="text-center -mt-12 sm:-mt-16">
                <div class="relative inline-block">
                    <img id="profile-image-preview" src="{{ $instructor->profile && $instructor->profile?->profile_photo_path ? $instructor->profile?->profile_photo_path : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($instructor->name, 0, 1) }}" alt="instructor Avatar" class="w-20 h-20 sm:w-24 sm:h-24 rounded-full border-4 border-white object-cover">
                    <div class="absolute bottom-0 right-0">
                        @if ($instructor->profile && $instructor->profile?->profile_photo_path)
                            <form id="remove-profile-picture-form" action="{{ route('admin.instructors.picture.remove', $instructor->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="button" id="delete-profile-picture" class="bg-red-500 text-white rounded-full p-1 sm:p-2 hover:bg-red-600 transition">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </form>
                        @else
                            <form id="update-profile-picture-form" action="{{ route('admin.instructors.picture.update', $instructor->id) }}" method="POST" enctype="multipart/form-data" class="inline">
                                @csrf
                                <button type="button" class="bg-[#E68815] text-white rounded-full p-1 sm:p-2 hover:bg-[#d1761a] transition" onclick="document.getElementById('profile-image-input').click()">
                                    <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                        <i class="uil uil-picture text-xl"></i>
                                    </div>
                                </button>
                                <input type="file" name="profile_image" id="profile-image-input" accept="image/png, image/jpeg" class="hidden" onchange="previewImage(event)">
                            </form>
                        @endif
                    </div>
                </div>
                <h4 class="text-lg sm:text-xl font-medium text-[#1B1B1B] mt-3 sm:mt-4">{{ $instructor->name }}</h4>
                <p class="text-xs sm:text-sm text-[#6B7280]">{{ $instructor->email }}</p>
                <div class="flex justify-center gap-3 sm:gap-4 mt-3">
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

        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
            <div class="col-span-1 md:col-span-4 lg:col-span-4">
                <div class="sticky top-20">
                    <div class="bg-white rounded-[20px] md:rounded-[30px] px-4 sm:px-6 md:px-8 py-4 sm:py-6 md:py-8 shadow-sm overflow-hidden">
                        <ul class="space-y-4">
                            <li>
                                <a class="flex items-center space-x-3 p-2 rounded-lg {{ request()->query('tab', 'personal') == 'personal' ? 'bg-[#F5CE9F] text-[#1B1B1B]' : 'text-[#1B1B1B] hover:bg-[#F5CE9F]' }} transition" href="{{ route('admin.instructors.edit', ['instructor' => $instructor->id, 'tab' => 'personal']) }}">
                                    <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                        <i class="uil uil-user text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-base sm:text-[18px] leading-[100%] tracking-[-0.02em]">Personal Profile</p>
                                        <p class="text-xs sm:text-sm text-[#6B7280]">Manage personal & contact details.</p>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a class="flex items-center space-x-3 p-2 rounded-lg {{ request()->query('tab', 'personal') == 'security' ? 'bg-[#F5CE9F] text-[#1B1B1B]' : 'text-[#1B1B1B] hover:bg-[#F5CE9F]' }} transition" href="{{ route('admin.instructors.edit', ['instructor' => $instructor->id, 'tab' => 'security']) }}">
                                    <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                        <i class="uil uil-lock text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-base sm:text-[18px] leading-[100%] tracking-[-0.02em]">Security Details</p>
                                        <p class="text-xs sm:text-sm text-[#6B7280]">Update password & security settings.</p>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a class="flex items-center space-x-3 p-2 rounded-lg {{ request()->query('tab') == 'social' ? 'bg-[#F5CE9F] text-[#1B1B1B]' : 'text-[#1B1B1B] hover:bg-[#F5CE9F]' }} transition" href="{{ route('admin.instructors.edit', ['instructor' => $instructor->id, 'tab' => 'social']) }}">
                                    <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                        <i class="uil uil-google text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-base sm:text-[18px] leading-[100%] tracking-[-0.02em]">Connected Accounts</p>
                                        <p class="text-xs sm:text-sm text-[#6B7280]">Manage social login connections.</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-span-1 md:col-span-8 lg:col-span-8">
                <div class="bg-white rounded-[20px] md:rounded-[30px] px-4 sm:px-6 md:px-8 py-4 sm:py-6 md:py-8 shadow-sm overflow-hidden">
                    @if (request()->query('tab', 'personal') == 'personal')
                        <form id="profile-form" method="POST" action="{{ route('admin.instructors.profile.update', $instructor->id) }}" enctype="multipart/form-data" class="flex flex-col h-full">
                            @csrf
                            @method('PATCH')

                            <div class="flex items-center space-x-3 mb-8 sm:mb-12">
                                <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                    <i class="uil uil-user text-xl"></i>
                                </div>
                                <h2 class="font-medium text-base sm:text-[18px] leading-[100%] tracking-[-0.02em] text-[#1B1B1B]">Personal Details</h2>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="mb-5">
                                    <label for="name" class="block text-xs sm:text-sm font-medium text-[#6B7280] mb-1">Fullname *</label>
                                    <input id="name" type="text" class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" name="name" value="{{ old('name', $instructor->name) }}" placeholder="Enter your full name" autocomplete="family-name">
                                    @error('name')
                                    <span class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label for="email" class="block text-xs sm:text-sm font-medium text-[#6B7280] mb-1">Email Address</label>
                                    <input id="email" type="email" class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-[#E1E1E1] rounded-lg text-[#1B1B1B] bg-gray-100 cursor-not-allowed" value="{{ $instructor->email }}" readonly placeholder="Enter your email address" autocomplete="email">
                                </div>

                                <div class="mb-5">
                                    <label for="phone_number" class="block text-xs sm:text-sm font-medium text-[#6B7280] mb-1">Phone Number</label>
                                    <input id="phone_number" type="tel" class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" name="phone_number" value="{{ old('phone_number', $instructor->profile?->phone_number) }}" placeholder="Enter your phone number" autocomplete="tel">
                                    @error('phone_number')
                                    <span class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label for="address" class="block text-xs sm:text-sm font-medium text-[#6B7280] mb-1">Address</label>
                                    <input id="address" type="text" class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" name="address" value="{{ old('address', $instructor->profile?->address) }}" placeholder="Enter your address" autocomplete="street-address">
                                    @error('address')
                                    <span class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-5 col-span-1 sm:col-span-2">
                                    <label for="course" class="block text-xs sm:text-sm font-medium text-[#6B7280] mb-1">Assigned Course</label>
                                    <select name="course" id="course" class="w-full px-4 py-3 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 appearance-none cursor-pointer placeholder:text-gray-500 invalid:text-gray-500">
                                        <option value="" disabled selected>Select a course</option>
                                        @foreach($instructorAssignedCourses as $course)
                                            <option value="{{ $course->id }}"{{ old('course', $instructor->profile?->course_id) == $course->id ? 'selected' : '' }}>
                                                {{ $course->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('course')
                                    <span class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-5 col-span-1 sm:col-span-2">
                                    <label for="biography" class="block text-xs sm:text-sm font-medium text-[#6B7280] mb-1">Biography</label>
                                    <textarea id="biography" rows="4" class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" name="biography" placeholder="Write a brief biography" autocomplete="biography">{{ old('biography', $instructor->profile?->biography) }}</textarea>
                                    @error('biography')
                                    <span class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <button id="submit-profile-btn" type="submit" class="mt-6 sm:mt-auto w-full bg-[#EB8C22] text-white font-medium py-2 sm:py-3 rounded-full hover:bg-[#d1761a] transition">Save Changes</button>
                        </form>
                    @elseif (request()->query('tab', 'personal') == 'security')
                        <form id="security-form" method="POST" action="{{ route('admin.instructors.reset.password', $instructor->id) }}" class="flex flex-col h-full">
                            @csrf

                            <div class="flex items-center space-x-3 mb-8 sm:mb-12">
                                <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                    <i class="uil uil-lock text-xl"></i>
                                </div>
                                <h2 class="font-medium text-base sm:text-[18px] leading-[100%] tracking-[-0.02em] text-[#1B1B1B]">Security Details</h2>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="mb-5">
                                    <label for="password" class="block text-xs sm:text-sm font-medium text-[#6B7280] mb-1">New Password *</label>
                                    <input id="password" type="password" class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" name="password" placeholder="Enter new password" autocomplete="new-password">
                                    <p class="text-xs text-[#EB8C22] mt-2">At least 8 characters with numbers and symbols</p>
                                    @error('password')
                                    <span class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label for="password_confirmation" class="block text-xs sm:text-sm font-medium text-[#6B7280] mb-1">Confirm Password *</label>
                                    <input id="password_confirmation" type="password" class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" name="password_confirmation" placeholder="Confirm new password" autocomplete="new-password">
                                    @error('password_confirmation')
                                    <span class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <button id="submit-security-btn" type="submit" class="mt-6 sm:mt-auto w-full bg-[#EB8C22] text-white font-medium py-2 sm:py-3 rounded-full hover:bg-[#d1761a] transition">Save Changes</button>
                        </form>
                    @elseif (request()->query('tab') == 'social')
                        <div class="flex flex-col h-full">
                            <div class="flex items-center space-x-3 mb-8 sm:mb-12">
                                <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                    <i class="uil uil-google text-xl"></i>
                                </div>
                                <h2 class="font-medium text-base sm:text-[18px] leading-[100%] tracking-[-0.02em] text-[#1B1B1B]">Connected Accounts</h2>
                            </div>

                            <div class="space-y-4">
                                <!-- Google -->
                                @if ($instructor->hasSocialAccount('google'))
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-3 sm:p-4 border border-[#E1E1E1] rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                                <svg class="w-5 h-5 sm:w-6 sm:h-6" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"></path>
                                                    <path d="M12 23c2.97 0 5.46-1.02 7.28-2.76l-3.57-2.77c-1.02.68-2.31 1.08-3.71 1.08-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C4.01 20.56 7.47 23 12 23z"></path>
                                                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.84h.81z"></path>
                                                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.47 1 4.01 3.44 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm sm:text-base text-[#1B1B1B] mb-2 sm:mb-0">Google: Connected</span>
                                        </div>
                                        <form action="{{ route('social.disconnect', ['provider' => 'google', 'instructor' => $instructor->id]) }}" method="POST" class="w-full sm:w-auto">
                                            @csrf
                                            <button type="submit" class="w-full sm:w-auto bg-red-500 text-white font-medium py-2 px-4 rounded-full hover:bg-red-600 transition">Disconnect</button>
                                        </form>
                                    </div>

                                    <div class="p-3 sm:p-4 border border-[#E1E1E1] rounded-lg opacity-50">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gray-300 flex items-center justify-center text-white">
                                                <svg class="w-5 h-5 sm:w-6 sm:h-6" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm sm:text-base text-[#1B1B1B]">Facebook: Not Connected</span>
                                        </div>
                                    </div>

                                    <div class="p-3 sm:p-4 border border-[#E1E1E1] rounded-lg opacity-50">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gray-300 flex items-center justify-center text-white">
                                                <svg class="w-5 h-5 sm:w-6 sm:h-6" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm sm:text-base text-[#1B1B1B]">Twitter: Not Connected</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="p-3 sm:p-4 border border-[#E1E1E1] rounded-lg opacity-50">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gray-300 flex items-center justify-center text-white">
                                                <svg class="w-5 h-5 sm:w-6 sm:h-6" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"></path>
                                                    <path d="M12 23c2.97 0 5.46-1.02 7.28-2.76l-3.57-2.77c-1.02.68-2.31 1.08-3.71 1.08-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C4.01 20.56 7.47 23 12 23z"></path>
                                                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.84h.81z"></path>
                                                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.47 1 4.01 3.44 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm sm:text-base text-[#1B1B1B]">Google: Not Connected</span>
                                        </div>
                                    </div>

                                    <div class="p-3 sm:p-4 border border-[#E1E1E1] rounded-lg opacity-50">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gray-300 flex items-center justify-center text-white">
                                                <svg class="w-5 h-5 sm:w-6 sm:h-6" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm sm:text-base text-[#1B1B1B]">Facebook: Not Connected</span>
                                        </div>
                                    </div>

                                    <div class="p-3 sm:p-4 border border-[#E1E1E1] rounded-lg opacity-50">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gray-300 flex items-center justify-center text-white">
                                                <svg class="w-5 h-5 sm:w-6 sm:h-6" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm sm:text-base text-[#1B1B1B]">Twitter: Not Connected</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteBtn = document.getElementById('delete-profile-picture');
            const deleteForm = document.getElementById('remove-profile-picture-form');
            const profileForm = document.getElementById('profile-form');
            const securityForm = document.getElementById('security-form');
            const profileBtn = document.getElementById('submit-profile-btn');
            const securityBtn = document.getElementById('submit-security-btn');
            const profileImagePreview = document.getElementById('profile-image-preview');
            const updateProfilePictureForm = document.getElementById('update-profile-picture-form');

            const iziToastSettings = {
                position: 'topRight',
                transitionIn: 'flipInX',
                transitionOut: 'flipOutX',
            };

            const showError = (message) => {
                iziToast.error({ ...iziToastSettings, message });
            };

            const showSuccess = (message) => {
                iziToast.success({ ...iziToastSettings, message });
            };

            // Image preview function
            window.previewImage = function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profileImagePreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);

                    // Submit image via AJAX
                    const formData = new FormData(updateProfilePictureForm);
                    const submitButton = updateProfilePictureForm.querySelector('button');

                    submitButton.disabled = true;
                    submitButton.innerHTML = `
                        <span class="flex items-center justify-center gap-2 z-10 relative">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                        </span>
                    `;

                    fetch(updateProfilePictureForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    })
                        .then(response => {
                            // Check if the response is OK (status 200-299)
                            if (!response.ok) {
                                return response.json().then(errorData => {
                                    throw new Error(errorData.message || `HTTP error! Status: ${response.status}`);
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            submitButton.disabled = false;
                            submitButton.innerHTML = `
                                <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                    <i class="uil uil-picture text-xl"></i>
                                </div>
                            `;

                            if (data.success) {
                                showSuccess(data.message || 'Profile picture updated successfully!');
                                setTimeout(() => location.reload(), 3000);
                            } else {
                                showError(data.message || 'Failed to update profile picture.');
                            }
                        })
                        .catch(error => {
                            submitButton.disabled = false;
                            submitButton.innerHTML = `
                                <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                    <i class="uil uil-picture text-xl"></i>
                                </div>
                            `;
                            showError(error.message || 'An error occurred while uploading the image.');
                        });
                }
            };

            function handleDeleteClick(e) {
                e.preventDefault();
                iziToast.question({
                    timeout: false,
                    close: false,
                    displayMode: 'once',
                    id: 'profile-delete-confirmation',
                    title: 'Are you sure?',
                    message: 'Do you want to remove your profile picture?',
                    position: 'topRight',
                    transitionIn: "flipInX",
                    transitionOut: "flipOutX",
                    buttons: [
                        ['<button><b>Yes, Delete</b></button>', function (instance, toast) {
                            deleteForm.submit();
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }, true],
                        ['<button>No</button>', function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }]
                    ]
                });
            }

            if (deleteBtn && deleteForm) {
                deleteBtn.addEventListener('click', handleDeleteClick);
            }

            if (profileBtn && profileForm) {
                profileBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const button = this;
                    button.innerHTML = `
                        <span class="flex items-center justify-center gap-2 z-10 relative">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            <span>Processing...</span>
                        </span>
                    `;
                    button.disabled = true;

                    if (!profileForm.checkValidity()) {
                        profileForm.reportValidity();
                        button.innerHTML = `Save Changes`;
                        button.disabled = false;
                        return;
                    }

                    setTimeout(() => profileForm.submit(), 500);
                });
            }

            if (securityBtn && securityForm) {
                securityBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const button = this;
                    button.innerHTML = `
                        <span class="flex items-center justify-center gap-2 z-10 relative">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            <span>Processing...</span>
                        </span>
                    `;
                    button.disabled = true;

                    if (!securityForm.checkValidity()) {
                        securityForm.reportValidity();
                        button.innerHTML = `Save Changes`;
                        button.disabled = false;
                        return;
                    }

                    setTimeout(() => securityForm.submit(), 500);
                });
            }

            const phoneNumberInput = document.getElementById('phone_number');
            if (phoneNumberInput && typeof Cleave !== 'undefined') {
                new Cleave('#phone_number', {
                    numericOnly: true,
                    blocks: [0, 3, 0, 3, 4],
                    delimiters: ['(', ')', ' ', '-', ' '],
                    maxLength: 14
                });
            }
        });
    </script>
@endpush
