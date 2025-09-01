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
                    <span class="text-[#E68815] font-semibold">Photos & Videos</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="max-w-7xl mx-auto ">
        <div class="flex justify-center space-x-2 md:space-x-4 mb-6 md:mb-10 mt-10 md:mt-20">
            <!-- Steps -->
            <div class="flex items-center justify-center space-x-0">
                <!-- Step 1 -->
                <div class="relative flex items-center">
                    <div class="w-8 h-8 md:w-12 md:h-12 flex items-center relative justify-center rounded-full bg-[#E68815] text-white font-bold shadow-[inset_0_4px_6px_rgba(0,0,0,0.3)]">
                        1
                    </div>
                    <!-- Line to Next -->
                    <div class="w-12 md:w-28 h-[6px] md:h-[8px] line-gradient bg-[#E68815]"></div>
                </div>

                <!-- Step 2 -->
                <div class="relative flex items-center">
                    <div class="w-8 h-8 md:w-12 md:h-12 flex items-center relative justify-center rounded-full bg-[#E68815] text-white font-bold shadow-[inset_0_4px_6px_rgba(0,0,0,0.3)]">
                        2
                    </div>
                    <!-- Line to Next -->
                    <div class="w-12 md:w-28 h-[6px] md:h-[8px] line-gradient bg-[#E68815]"></div>
                </div>

                <!-- Step 3 -->
                <div class="relative flex items-center">
                    <div class="w-8 h-8 md:w-12 md:h-12 flex items-center relative justify-center rounded-full bg-[#E68815] text-white font-bold shadow-[inset_0_4px_6px_rgba(0,0,0,0.3)]">
                        3
                        <!-- Step Label -->
                        <div class="hidden md:block px-4 py-2 rounded-[10px] shadow-sm border border-[#929292] absolute -top-10 md:-top-14 left-1/2 -translate-x-1/2 whitespace-nowrap">
                    <span class="text-[#444444] text-xs md:text-sm font-medium">
                        Photos & Videos
                    </span>
                        </div>
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

        <div class="w-auto bg-white rounded-[20px] px-4 py-4 md:px-6 md:py-6 shadow-sm overflow-hidden">
            <div class="flex flex-row justify-between mb-8 gap-2">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 rounded-full bg-[#E68815] flex items-center justify-center">
                        <i class="uil uil-image text-white"></i>
                    </div>
                    <h3 class="text-base font-medium text-[#1B1B1B]">Photos & Videos</h3>
                </div>
            </div>

            <div>
                <form id="photos-videos-form" action="{{ route('admin.courses.add.store.photos.videos') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Course Photo Upload -->
                        <div>
                            <label class="block text-sm font-medium text-[#1B1B1B] mb-2">
                                Course photo<span class="text-red-500">*</span>
                            </label>

                            <!-- Dropzone -->
                            <div class="image-dropzone dropzone flex flex-col items-center justify-center p-3 w-full h-36 border-2 border-dashed border-gray-400 rounded-xl cursor-pointer bg-white hover:border-[#E68815] transition">
                                <input type="file" name="course_photo" accept="image/png,image/jpeg" class="file-input hidden" />
                                <div>
                                    <i class="uil uil-image-upload text-[#141B34] text-xl"></i>
                                </div>

                                <p class="text-sm text-gray-600">
                                    Drag & Drop image or
                                    <span class="browseBtn text-[#E68815] font-medium cursor-pointer">Browse</span>
                                </p>
                                <p class="text-xs text-gray-400 mt-1">JPG, PNG, or JPEG format (max 1920 × 1080)</p>
                            </div>

                            <!-- Laravel validation errors -->
                            @if ($errors->has('course_photo'))
                                <span class="error-message text-red-500 text-sm mt-1 block">{{ $errors->first('course_photo') }}</span>
                            @endif

                            <!-- Uploaded image preview container -->
                            <div id="imagePreviewContainer" class="preview-container mt-3"></div>
                        </div>

                        <!-- Course Video URL Input -->
                        <div>
                            <label class="block text-sm font-medium text-[#1B1B1B] mb-2">
                                Course video URL (optional)
                            </label>

                            <div class="relative">
                                <input type="url" name="video_url" id="video-url-input" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E68815] focus:border-[#E68815] outline-none transition duration-200 text-gray-900" placeholder="www.youtube.com/..." value="{{ old('video_url', session('course.add.media.video_url', '')) }}"/>
                            </div>

                            <p class="text-xs text-gray-500 mt-1">
                                Supported platforms: YouTube, Vimeo, or direct video links
                            </p>

                            <!-- Laravel validation errors -->
                            @if ($errors->has('video_url'))
                                <span class="error-message text-red-500 text-sm mt-1 block">{{ $errors->first('video_url') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-8 w-full">
                        <a href="{{ route('admin.courses.add.outcomes') }}"
                           class="bg-[#EDEDED] w-full text-gray-800 text-sm font-medium px-6 py-3 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 text-center inline-block">
                            Prev
                        </a>

                        <button type="submit" id="next-button" class="bg-[#E68815] w-full text-white text-sm px-6 py-3 rounded-full hover:bg-[#cc6f0f] focus:outline-none focus:ring-2 focus:ring-[#E68815] flex items-center justify-center transition duration-200">
                            <span class="submit-text">Next</span>
                        </button>
                    </div>

                    <!-- Pass existing data to JavaScript -->
                    <script type="application/json" id="existing-media">
                        @json(session('course.add.media', []))
                    </script>
                </form>
            </div>
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

        .loading-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .error-message {
            color: #EF4444;
            font-size: 12px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('photos-videos-form');
            const nextButton = document.getElementById('next-button');
            let isSubmitting = false;
            let uploadedPhoto = null;

            const showError = (message) => {
                iziToast.error({ ...iziToastSettings, message });
            };

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

            // Load existing media data from session
            function loadExistingMedia() {
                const existingMediaScript = document.getElementById('existing-media');

                if (existingMediaScript) {
                    try {
                        const sessionData = JSON.parse(existingMediaScript.textContent);
                        if (sessionData && sessionData.course_photo && sessionData.course_photo.length > 0) {
                            sessionData.course_photo.forEach(photo => {
                                displayExistingPhoto(photo);
                                uploadedPhoto = true;
                            });
                        }
                    } catch (error) {
                        console.error('Error loading existing media:', error);
                    }
                }
            }

            // Display an existing photo from session
            function displayExistingPhoto(photoUrl) {
                const previewContainer = document.getElementById('imagePreviewContainer');
                const fileName = photoUrl.split('/').pop();
                const truncatedName = truncateFilename(fileName);

                const previewElement = `
                    <div class="file-preview flex items-center justify-between p-4 bg-white rounded-xl border border-gray-300 shadow-sm">
                        <div class="w-full">
                            <div class="flex justify-between items-center w-full space-x-1 mb-2">
                                <div class="flex items-center space-x-1 overflow-hidden">
                                    <img src="${photoUrl}" alt="Course photo" class="w-8 h-8 object-cover rounded" />
                                    <p class="text-sm font-[400] text-[#1B1B1B] truncate" title="${fileName}">${truncatedName}</p>
                                </div>
                                <button type="button" class="remove-btn text-gray-500 hover:text-red-500 flex-shrink-0">
                                    <i class="uil uil-times text-lg"></i>
                                </button>
                            </div>
                            <div>
                                <p class="text-xs block text-gray-500">Existing file</p>
                                <div class="flex items-center space-x-2">
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="progress-bar bg-green-600 h-2 w-full"></div>
                                    </div>
                                    <div>
                                        <span class="progress-text text-sm text-gray-700 font-medium">100%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                previewContainer.innerHTML += previewElement;
                previewContainer.classList.remove('hidden');

                // Setup remove button
                const removeBtn = previewContainer.querySelector('.remove-btn');
                removeBtn.addEventListener('click', function() {
                    previewContainer.innerHTML = '';
                    previewContainer.classList.add('hidden');
                    uploadedPhoto = null;

                    // Clear the file input
                    const fileInput = document.querySelector('.file-input');
                    fileInput.value = '';

                    // Add hidden input to clear the photo from session
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'remove_photo';
                    hiddenInput.value = photoUrl;
                    form.appendChild(hiddenInput);
                });
            }

            // Initialize image upload zone
            function initImageUploadZone() {
                const dropzone = document.querySelector('.image-dropzone');
                const fileInput = dropzone.querySelector('.file-input');
                const browseBtn = dropzone.querySelector('.browseBtn');
                const previewContainer = document.getElementById('imagePreviewContainer');

                // Format file size to readable format
                function formatFileSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                }

                // Create a preview element for new uploads
                function createPreviewElement(file) {
                    const fileSize = formatFileSize(file.size);
                    const truncatedName = truncateFilename(file.name);

                    return `
                        <div class="file-preview flex items-center justify-between p-4 bg-white rounded-xl border border-gray-300 shadow-sm">
                            <div class="w-full">
                                <div class="flex justify-between items-center w-full space-x-1 mb-2">
                                    <div class="flex items-center space-x-1 overflow-hidden">
                                        <i class="uil uil-image-upload text-[#141B34] text-xl flex-shrink-0"></i>
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
                                uploadedPhoto = true;
                            }
                        }
                    }, 100);
                }

                // Handle file selection
                function handleFileSelection(file) {
                    if (!file) return;

                    // Validate file type
                    if (!file.type.match('image/jpeg') && !file.type.match('image/png')) {
                        showError('Please select a valid JPEG or PNG image');
                        fileInput.value = '';
                        return;
                    }

                    // Validate file size (max 5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        showError('Image file size exceeds the maximum limit of 5MB');
                        fileInput.value = '';
                        return;
                    }

                    // Clear existing previews
                    previewContainer.innerHTML = '';
                    previewContainer.classList.remove('hidden');

                    // Create and show preview
                    previewContainer.innerHTML = createPreviewElement(file);

                    const previewElement = previewContainer.querySelector('.file-preview');

                    // Setup remove button
                    const removeBtn = previewElement.querySelector('.remove-btn');
                    removeBtn.addEventListener('click', function() {
                        previewContainer.classList.add('hidden');
                        previewContainer.innerHTML = '';
                        fileInput.value = '';
                        uploadedPhoto = null;
                        // Remove any hidden inputs for clearing photos
                        const existingHiddenInput = form.querySelector('input[name="remove_photo"]');
                        if (existingHiddenInput) {
                            existingHiddenInput.remove();
                        }
                    });

                    // Simulate upload progress
                    simulateUpload(previewElement);
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
            }

            // Form validation
            function validateForm() {
                const photoInput = document.querySelector('input[name="course_photo"]');
                const existingPhotos = form.querySelector('input[name="remove_photo"]');

                // Course photo is required if no existing photo or new upload
                if (!photoInput.files || !photoInput.files[0]) {
                    if (!uploadedPhoto && !existingPhotos) {
                        showError('Please select a course photo');
                        return false;
                    }
                }

                return true;
            }

            // Form submission handler
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                if (isSubmitting) {
                    return; // Prevent double submission
                }

                // Validate form
                if (!validateForm()) {
                    return;
                }

                isSubmitting = true;

                // Show loading state
                nextButton.innerHTML = `
                    <span class="flex items-center justify-center gap-2">
                        <svg class="loading-spinner h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span>Processing...</span>
                    </span>
                `;
                nextButton.disabled = true;

                // Submit the form after a short delay for visual feedback
                setTimeout(() => {
                    form.submit();
                }, 500);
            });

            // Initialize with existing data
            loadExistingMedia();
            initImageUploadZone();
        });
    </script>
@endpush
