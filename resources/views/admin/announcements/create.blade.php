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
                    <span class="text-[#E68815] font-semibold">Create Announcements</span>
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
                                <a class="flex items-center space-x-3 p-2 rounded-lg bg-[#F5CE9F] text-[#1B1B1B] hover:bg-[#EFCF9F] transition"
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
                                <a class="flex items-center space-x-3 p-2 rounded-lg text-[#1B1B1B] hover:bg-[#F5CE9F] transition"
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
                    <form id="announcement-form" method="POST" action="{{ route('admin.announcements.store') }}" class="flex flex-col h-full" enctype="multipart/form-data">
                        @csrf

                        <!-- Header -->
                        <div class="flex items-center space-x-3 mb-12">
                            <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                <i class="uil uil-megaphone text-xl"></i>
                            </div>
                            <h2 class="font-medium text-[18px] leading-[100%] text-[#1B1B1B]">Create Announcement</h2>
                        </div>

                        <!-- Title -->
                        <div class="mb-5">
                            <label for="title" class="block text-sm font-medium text-[#6B7280] mb-1">Announcement Title</label>
                            <input id="title" type="text" name="title" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] text-gray-900" value="{{ old('title') }}" placeholder="Enter announcement title">
                            @error('title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mb-5">
                            <label for="content" class="block text-sm font-medium text-[#6B7280] mb-1">Announcement Content</label>
                            <div class="border border-gray-300 rounded-lg bg-white">
                                <div id="editor" class="min-h-[120px] sm:min-h-[150px]"></div>
                                <input type="hidden" name="content" id="details" value="{{ old('content') }}">
                            </div>
                            @error('content')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Target Audience -->
                        <div class="mb-5">
                            <label for="target" class="block text-sm font-medium text-[#6B7280] mb-1">Target Audience</label>
                            <select id="target" name="target" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] text-gray-900">
                                <option value="all" {{ old('target') == 'all' ? 'selected' : '' }}>All Users</option>
                                <option value="students" {{ old('target') == 'students' ? 'selected' : '' }}>Students Only</option>
                                <option value="instructors" {{ old('target') == 'instructors' ? 'selected' : '' }}>Instructors Only</option>
                                <option value="specific_courses" {{ old('target') == 'specific_courses' ? 'selected' : '' }}>Specific Courses</option>
                            </select>
                            @error('target')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Courses Selection -->
                        <div id="courses-fields" class="mb-5 hidden">
                            <label class="block text-sm font-medium text-[#6B7280] mb-1" for="courses">Select Courses</label>
                            <select id="courses" name="courses[]" multiple class="w-full select2-courses">
                                @foreach($courses ?? [] as $course)
                                    <option value="{{ $course->id }}" {{ in_array($course->id, old('courses', [])) ? 'selected' : '' }}>{{ $course->title }}</option>
                                @endforeach
                            </select>
                            @error('courses')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Attachment -->
                        <div class="mb-5">
                            <label for="attachment" class="block text-sm font-medium text-[#6B7280] mb-1">Attachment (Optional)</label>
                            <div class="image-dropzone dropzone flex flex-col items-center justify-center p-3 w-full h-36 border-2 border-dashed border-gray-400 rounded-xl cursor-pointer bg-white hover:border-[#E68815] transition">
                                <input type="file" name="attachment" accept="image/png,image/jpeg,application/pdf" class="file-input hidden" id="attachment" />
                                <div>
                                    <i class="uil uil-file-upload text-[#141B34] text-xl"></i>
                                </div>
                                <p class="text-sm text-gray-600">
                                    Drag & Drop file or
                                    <span class="browseBtn text-[#E68815] font-medium cursor-pointer">Browse</span>
                                </p>
                                <p class="text-xs text-gray-400 mt-1">JPG, PNG, or PDF format (max 1920 × 1080 for images, 5MB)</p>
                            </div>
                            @error('attachment')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                            <div id="imagePreviewContainer" class="preview-container mt-3 hidden"></div>
                        </div>

                        <!-- Publish -->
                        <button id="submit-btn" type="submit" class="w-full bg-[#EB8C22] text-white font-medium py-3 rounded-full hover:bg-[#d1761a] transition">
                            Publish Announcement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Override Quill editor text color */
        .ql-editor {
            color: #1B1B1B !important; /* Dark text color */
        }

        /* Ensure placeholder text is visible */
        .ql-editor.ql-blank::before {
            color: #6B7280 !important; /* Gray color for placeholder */
        }

        .select2-container--default .select2-selection--multiple {
            padding-bottom: 14px !important;
            padding-top: 7px !important;
            border-radius: 8px !important;
        }

        .select2-dropdown {
            background-color: #999 !important;
        }

        /* Tailwind-styled Select2 */
        .select2-container--default .select2-selection--multiple {
            @apply w-full px-4 py-3 border border-[#E1E1E1] rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-1 focus:ring-[#EB8C22];
        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            @apply flex flex-wrap gap-1 p-1;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            @apply bg-[#F5CE9F] text-[#1B1B1B] border border-[#E1E1E1] rounded-md px-2 py-1 text-sm flex items-center;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            @apply text-[#E68815] hover:text-red-500 mr-1 cursor-pointer;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__clear {
            @apply text-[#E68815] hover:text-red-500 cursor-pointer mr-2;
        }

        .select2-container--default .select2-search--inline .select2-search__field {
            @apply text-gray-900 placeholder-[#1B1B1B];
        }

        .select2-container--default .select2-selection--multiple .select2-selection__placeholder {
            @apply text-[#1B1B1B];
        }

        .select2-dropdown {
            @apply border border-[#E1E1E1] rounded-lg bg-white shadow-sm;
        }

        .select2-container--default .select2-results__option {
            @apply px-4 py-2 text-gray-900 hover:bg-[#F5CE9F] hover:text-[#1B1B1B];
        }

        .select2-container--default .select2-results__option--highlighted {
            @apply bg-[#E68815] text-white;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Initialize Select2 for courses
        $(document).ready(function() {
            $('.select2-courses').select2({
                placeholder: 'Select courses',
                allowClear: true,
                width: '100%',
                closeOnSelect: false,
                templateResult: function(data) {
                    if (!data.element) {
                        return data.text;
                    }
                    return $('<span>' + data.text + '</span>');
                },
                templateSelection: function(data) {
                    return data.text || data.id;
                }
            });
        });

        // Toggle courses fields
        const targetSelect = document.getElementById('target');
        const coursesFields = document.getElementById('courses-fields');

        function toggleFields() {
            if (targetSelect.value === 'specific_courses') {
                coursesFields.classList.remove('hidden');
            } else {
                coursesFields.classList.add('hidden');
            }
        }

        targetSelect.addEventListener('change', toggleFields);
        toggleFields();

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('announcement-form');
            const submitBtn = document.getElementById('submit-btn');
            const dropzone = document.querySelector('.image-dropzone');
            const fileInput = document.querySelector('.file-input');
            const browseBtn = dropzone.querySelector('.browseBtn');
            const previewContainer = document.getElementById('imagePreviewContainer');

            // Format file size to a readable format
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Truncate filename if too long
            function truncateFilename(name, maxLength = 35) {
                if (name.length <= maxLength) return name;
                const extensionIndex = name.lastIndexOf('.');
                if (extensionIndex === -1) {
                    return name.substring(0, maxLength - 3) + '...';
                }
                const extension = name.substring(extensionIndex);
                const nameWithoutExt = name.substring(0, extensionIndex);
                if (nameWithoutExt.length <= maxLength - extension.length) {
                    return name;
                }
                return nameWithoutExt.substring(0, maxLength - extension.length - 3) + '...' + extension;
            }

            // Create a preview element for new uploads
            function createPreviewElement(file, previewUrl) {
                const fileSize = formatFileSize(file.size);
                const truncatedName = truncateFilename(file.name);
                const isImage = file.type.match('image/jpeg') || file.type.match('image/png');

                return `
                    <div class="file-preview flex items-center justify-between p-4 bg-white rounded-xl border border-gray-300 shadow-sm">
                        <div class="w-full">
                            <div class="flex justify-between items-center w-full space-x-1 mb-2">
                                <div class="flex items-center space-x-1 overflow-hidden">
                                    ${isImage ? `<img src="${previewUrl}" alt="Attachment preview" class="w-8 h-8 object-cover rounded" />` : `<i class="uil uil-file-alt text-2xl text-gray-500"></i>`}
                                    <p class="text-sm font-[400] text-[#1B1B1B] truncate" title="${file.name}">${truncatedName}</p>
                                </div>
                                <button type="button" class="remove-btn text-gray-500 hover:text-red-500 flex-shrink-0">
                                    <i class="uil uil-times text-lg"></i>
                                </button>
                            </div>
                            <div>
                                <p class="text-xs block text-gray-500">${fileSize}</p>
                                <div class="flex items-center space-x-2">
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="progress-bar bg-green-600 h-2 w-0 transition-all duration-100"></div>
                                    </div>
                                    <div>
                                        <span class="progress-text text-sm text-gray-700 font-medium">0%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            // Simulate upload progress
            function simulateUpload(previewElement) {
                const progressBar = previewElement.querySelector('.progress-bar');
                const progressText = previewElement.querySelector('.progress-text');

                let progress = 0;
                const interval = setInterval(() => {
                    progress += 10;
                    if (progress <= 100) {
                        progressBar.style.width = progress + '%';
                        progressText.textContent = progress + '%';
                        if (progress === 100) {
                            clearInterval(interval);
                        }
                    }
                }, 100);
            }

            // Handle file selection
            function handleFileSelection(file) {
                if (!file) return;

                // Validate file type
                if (!file.type.match('image/jpeg') && !file.type.match('image/png') && !file.type.match('application/pdf')) {
                    iziToast.error({ message: 'Please select a valid JPEG, PNG, or PDF file' });
                    fileInput.value = '';
                    return;
                }

                // Validate file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    iziToast.error({ message: 'File size exceeds the maximum limit of 5MB' });
                    fileInput.value = '';
                    return;
                }

                // Validate image dimensions if it's an image (max 1920x1080)
                if (file.type.match('image/jpeg') || file.type.match('image/png')) {
                    const img = new Image();
                    img.onload = function() {
                        if (img.width > 1920 || img.height > 1080) {
                            iziToast.error({ message: 'Image dimensions exceed the maximum limit of 1920x1080' });
                            fileInput.value = '';
                            return;
                        }

                        // Clear existing previews
                        previewContainer.innerHTML = '';
                        previewContainer.classList.remove('hidden');

                        // Create and show a preview
                        previewContainer.innerHTML = createPreviewElement(file, img.src);

                        const previewElement = previewContainer.querySelector('.file-preview');

                        // Setup remove button
                        const removeBtn = previewElement.querySelector('.remove-btn');
                        removeBtn.addEventListener('click', function() {
                            previewContainer.classList.add('hidden');
                            previewContainer.innerHTML = '';
                            fileInput.value = '';
                        });

                        // Simulate upload progress
                        simulateUpload(previewElement);
                    };
                    img.onerror = function() {
                        iziToast.error({ message: 'Invalid image file' });
                        fileInput.value = '';
                    };
                    img.src = URL.createObjectURL(file);
                } else {
                    // For non-image files (PDF), show preview without image validation
                    previewContainer.innerHTML = '';
                    previewContainer.classList.remove('hidden');
                    previewContainer.innerHTML = createPreviewElement(file, '');

                    const previewElement = previewContainer.querySelector('.file-preview');

                    // Setup remove button
                    const removeBtn = previewElement.querySelector('.remove-btn');
                    removeBtn.addEventListener('click', function() {
                        previewContainer.classList.add('hidden');
                        previewContainer.innerHTML = '';
                        fileInput.value = '';
                    });

                    // Simulate upload progress
                    simulateUpload(previewElement);
                }
            }

            // Click browse text
            browseBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                fileInput.click();
            });

            // Click entire dropzone
            dropzone.addEventListener('click', () => fileInput.click());

            // Handle file input change
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    handleFileSelection(this.files[0]);
                }
            });

            // Handle drag and drop
            dropzone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropzone.classList.add('border-[#E68815]', 'bg-orange-50');
            });

            dropzone.addEventListener('dragleave', () => {
                dropzone.classList.remove('border-[#E68815]', 'bg-orange-50');
            });

            dropzone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropzone.classList.remove('border-[#E68815]', 'bg-orange-50');
                if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                    fileInput.files = e.dataTransfer.files;
                    handleFileSelection(e.dataTransfer.files[0]);
                }
            });

            // Form submission handler
            submitBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const button = this;

                // Show preloader
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

                // Check form validity
                if (!form.checkValidity()) {
                    form.reportValidity();
                    button.innerHTML = `Publish Announcement`;
                    button.disabled = false;
                    return;
                }

                // Submit form after delay for animation
                setTimeout(() => form.submit(), 500);
            });
        });
    </script>
@endpush
