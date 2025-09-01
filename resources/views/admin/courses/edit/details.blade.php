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
                    <span class="text-[#E68815] font-semibold">Course Details</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="max-w-7xl mx-auto ">
        <div class="flex justify-center space-x-2 md:space-x-4 mb-6 md:mb-10 mt-10 md:mt-20">
            <!-- Steps -->
            <div class="flex items-center justify-center space-x-0">
                <!-- Step 1 (Active) -->
                <div class="relative flex items-center">
                    <div class="w-8 h-8 md:w-12 md:h-12 flex items-center relative justify-center rounded-full bg-[#E68815] text-white font-bold shadow-[inset_0_4px_6px_rgba(0,0,0,0.3)]">
                        1
                        <!-- Step Label -->
                        <div class="hidden md:block px-4 py-2 bg-[#EDEDED] rounded-[10px] shadow-sm border border-[#929292] absolute -top-10 md:-top-14 left-1/2 -translate-x-1/2 whitespace-nowrap">
                            <span class="text-[#444444] text-xs md:text-sm font-medium">
                                Course Details
                            </span>
                        </div>
                    </div>
                    <!-- Line to Next -->
                    <div class="w-12 md:w-28 h-[6px] md:h-[8px] line-gradient"></div>
                </div>

                <!-- Step 2 -->
                <div class="relative flex items-center">
                    <div class="w-8 h-8 md:w-12 md:h-12 flex items-center justify-center rounded-full bg-white border text-gray-600 font-bold round-gradient">
                        2
                    </div>
                    <!-- Line to Next -->
                    <div class="w-12 md:w-28 h-[6px] md:h-[8px] line-gradient"></div>
                </div>

                <!-- Step 3 -->
                <div class="relative flex items-center">
                    <div class="w-8 h-8 md:w-12 md:h-12 flex items-center justify-center rounded-full bg-white border round-gradient text-gray-600 font-bold">
                        3
                    </div>
                    <!-- Line to Next -->
                    <div class="w-12 md:w-28 h-[6px] md:h-[8px] line-gradient"></div>
                </div>

                <!-- Step 4 -->
                <div class="relative flex items-center">
                    <div class="w-8 h-8 md:w-12 md:h-12 flex items-center justify-center rounded-full bg-white border round-gradient text-gray-600 font-bold">
                        4
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[20px] shadow-md mx-auto">
            <!-- Header -->
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-[#E68815] text-white mr-2">
                    <img src="{{ asset('dashboard_assets/images/img/detail.png') }}" alt="detail">
                </div>
                <h2 class="text-[16px] font-medium text-[#1B1B1B]">Edit Course Details</h2>
            </div>

            <!-- Form -->
            <form id="course-edit-form" action="{{ route('admin.courses.edit.update.details', $course->id) }}" method="POST" class="space-y-4 sm:space-y-6">
                @csrf
                @method('PUT')

                <!-- Course Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-900 mb-1">Course Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $sessionDetails['title'] ?? $course->title) }}" placeholder="Enter course title" class="w-full border border-gray-300 rounded-md px-3 sm:px-4 py-2 text-gray-900 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition" aria-describedby="title-error">
                    @error('title')
                    <p class="mt-1 text-sm text-red-600" id="title-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Course Subtitle -->
                <div>
                    <label for="subtitle" class="block text-sm font-medium text-gray-900 mb-1">Course Subtitle *</label>
                    <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $sessionDetails['subtitle'] ?? $course->subtitle) }}" placeholder="Enter course subtitle" class="w-full border border-gray-300 rounded-md px-3 sm:px-4 py-2 text-gray-900 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition" aria-describedby="subtitle-error">
                    @error('subtitle')
                    <p class="mt-1 text-sm text-red-600" id="subtitle-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Course Description -->
                <div>
                    <label for="editor" class="block text-sm font-medium text-gray-900 mb-1">Course Description *</label>
                    <div class="border border-gray-300 rounded-lg bg-white">
                        <div id="editor" class="min-h-[120px] sm:min-h-[150px]"></div>
                        <input type="hidden" name="summary" id="details" value="{{ old('summary', $sessionDetails['summary'] ?? $course->summary) }}">
                    </div>
                    @error('summary')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price & Category -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Course Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-900 mb-1">Course Price *</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $sessionDetails['price'] ?? $course->price) }}" placeholder="Enter price (e.g., 99.99)" step="0.01" min="0" class="w-full border border-gray-300 rounded-md px-3 sm:px-4 py-2 text-gray-900 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition" aria-describedby="price-error">
                        @error('price')
                        <p class="mt-1 text-sm text-red-600" id="price-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-900 mb-1">Category *</label>
                        <select name="category_id" id="category_id" class="w-full px-4 py-3 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 appearance-none cursor-pointer placeholder:text-gray-500 invalid:text-gray-500" aria-describedby="category-error">
                            <option value="" disabled {{ old('category_id', $sessionDetails['category_id'] ?? $course->category_id) ? '' : 'selected' }}>Select category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $sessionDetails['category_id'] ?? $course->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="mt-1 text-sm text-red-600" id="category-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="save-course-btn" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 sm:py-3 rounded-full transition focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                    Save and Continue
                </button>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .line-gradient {
            box-shadow: 0 4px 4px 0 #00000040 inset;
        }

        .round-gradient {
            box-shadow: 0 2px 4px 0 #00000040;
        }

        /* Override Quill editor text color */
        .ql-editor {
            color: #1B1B1B !important; /* Dark text color */
        }

        /* Ensure placeholder text is visible */
        .ql-editor.ql-blank::before {
            color: #6B7280 !important; /* Gray color for placeholder */
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.getElementById('save-course-btn').addEventListener('click', function (e) {
            e.preventDefault();
            const form = document.getElementById('course-edit-form');
            const button = this;

            // Show preloader
            button.innerHTML = `
                <span class="flex items-center justify-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span>Processing...</span>
                </span>
            `;
            button.disabled = true;

            // Check form validity
            if (!form.checkValidity()) {
                form.reportValidity();
                button.innerHTML = `Save and Continue`;
                button.disabled = false;
                return;
            }

            // Delay for animation effect
            setTimeout(() => form.submit(), 500);
        });
    </script>
@endpush
