@extends('layouts.admin')
@section('content')
    <div>
        <p class="text-base md:text-[20px] font-medium text-[#5D5D5D] mb-8">
            Course Oversight > <span class="text-[#848484]">Create Course</span>
        </p>
    </div>

    <div class="space-x-4 mb-10 mt-20">

        <!-- Steps -->
        <div class="flex items-center justify-center space-x-0">
            <!-- Step 1 (Active) -->
            <div class="relative flex items-center">
                <div
                    class="w-12 h-12 flex items-center relative justify-center rounded-full bg-[#E68815] text-white font-bold shadow-[inset_0_4px_6px_rgba(0,0,0,0.3)]">

                    1

                </div>

                <!-- Line to Next -->
                <div class="w-28 h-[8px] line-gradient bg-[#E68815]"></div>
            </div>

            <!-- Step 2 -->
            <div class="relative flex items-center">
                <div
                    class="w-12 h-12 flex items-center relative justify-center rounded-full bg-[#E68815] text-white font-bold shadow-[inset_0_4px_6px_rgba(0,0,0,0.3)]">
                    2

                </div>
                <!-- Line to Next -->
                <div class="w-28 h-[8px] line-gradient bg-[#E68815]"></div>
            </div>

            <!-- Step 3 -->
            <div class="relative flex items-center">
                <div
                    class="w-12 h-12 flex items-center relative justify-center rounded-full bg-[#E68815] text-white font-bold shadow-[inset_0_4px_6px_rgba(0,0,0,0.3)]">
                    3

                    <!-- Step Label -->
                    <div
                        class="px-4 py-2 inline-block rounded-[10px] shadow-sm border border-[#929292] absolute -top-14 left-1/2 -translate-x-1/2 whitespace-nowrap">
                        <span class="text-[#444444] text-sm font-medium">
                            Course & Video
                        </span>
                    </div>
                </div>
                <!-- Line to Next -->
                <div class="w-28 h-[8px] line-gradient"></div>
            </div>


            <!-- Step 4 -->
            <div class="relative flex items-center">
                <div
                    class="w-12 h-12 flex items-center justify-center rounded-full bg-white border round-gradient text-gray-600 font-bold">
                    4
                </div>
            </div>
        </div>
    </div>

    <div class="w-auto bg-white rounded-[20px] px-4 py-4 md:px-6 md:py-6 shadow-sm overflow-hidden ">

        {{-- header  --}}
        <div class="flex flex-row justify-between mb-8 gap-2">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 rounded-full bg-[#E68815] flex items-center justify-center">
                    <i class="uil uil-image text-white"></i>
                </div>
                <h3 class="text-base font-medium text-[#1B1B1B]">Course & Video</h3>
            </div>
        </div>



        {{-- content  --}}
        <div>
            <form action="" method="" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8 w-full">
                    {{-- for cover image --}}
                    <div class="grid grid-cols-1 gap-4">
                        <div class="">
                            <label class="block text-sm font-medium text-[#1B1B1B] mb-2">
                                Course photo<span class="text-red-500">*</span>
                            </label>

                            <!-- Dropzone -->
                            <div
                                class="image-dropzone dropzone flex flex-col items-center justify-center p-3 w-full h-36 border-2 border-dashed border-gray-400 rounded-xl cursor-pointer bg-white hover:border-[#E68815] transition">
                                <input type="file" accept="image/png,image/jpeg" class="file-input hidden" />

                                <div>
                                    <i class="uil uil-image-upload text-[#141B34] text-xl"></i>
                                </div>

                                <p class="text-sm text-gray-600">
                                    Drag & Drop image or
                                    <span class="browseBtn text-[#E68815] font-medium cursor-pointer">Browse</span>
                                </p>
                                <p class="text-xs text-gray-400 mt-1">JPG, PNG, or JPEG format (max 1920 × 1080)</p>
                            </div>
                        </div>

                        <!-- Uploaded image preview container -->
                        <div id="imagePreviewContainer" class="preview-container"></div>
                    </div>

                    {{-- for video cover --}}
                    <div class="grid grid-cols-1 gap-4">
                        <div class="">
                            <label class="block text-sm font-medium text-[#1B1B1B] mb-2">
                                Course video cover
                            </label>

                            <!-- Dropzone -->
                            <div
                                class="video-dropzone dropzone flex flex-col items-center justify-center w-full h-36 p-3 border-2 border-dashed border-gray-400 rounded-xl cursor-pointer bg-white hover:border-[#E68815] transition">
                                <input type="file" accept="video/mp4,video/mkv" class="file-input hidden" />

                                <div>
                                    <i class="uil uil-video text-[#141B34] text-xl"></i>
                                </div>

                                <p class="text-sm text-gray-600">
                                    Drag & Drop video or
                                    <span class="browseBtn text-[#E68815] font-medium cursor-pointer">Browse</span>
                                </p>
                                <p class="text-xs text-gray-400 mt-1">MP4, MKV format (max 200MB)</p>
                            </div>
                        </div>

                        <!-- Uploaded video preview container -->
                        <div id="videoPreviewContainer" class="preview-container"></div>
                    </div>
                </div>


                {{-- buttons  --}}
                <div class="grid grid-cols-2 gap-4 mt-8 w-full">
                    <button type="button" id="prev-button"
                        class="bg-[#EDEDED] w-full text-gray-800 text-sm font-medium px-6 py-3 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Prev
                    </button>

                    <button type="submit" id="next-button"
                        class="bg-[#E68815] w-full text-white text-sm px-6 py-3 rounded-full hover:bg-[#cc6f0f] focus:outline-none focus:ring-2 focus:ring-[#E68815] flex items-center justify-center transition duration-200">
                        <span class="submit-text">Next</span>
                    </button>
                </div>
            </form>

        </div>



    </div>


    @push('styles')
        <style>
            .line-gradient {
                box-shadow: 0px 4px 4px 0px #00000040 inset;
            }

            .round-gradient {
                box-shadow: 0px 2px 4px 0px #00000040;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize both upload zones
                initUploadZone('.image-dropzone', '#imagePreviewContainer', 'image');
                initUploadZone('.video-dropzone', '#videoPreviewContainer', 'video');

                function initUploadZone(dropzoneSelector, previewContainerSelector, type) {
                    const dropzone = document.querySelector(dropzoneSelector);
                    const fileInput = dropzone.querySelector('.file-input');
                    const browseBtn = dropzone.querySelector('.browseBtn');
                    const previewContainer = document.querySelector(previewContainerSelector);

                    // Format file size to readable format
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

                    // Create preview element
                    function createPreviewElement(file, type) {
                        const fileSize = formatFileSize(file.size);
                        const truncatedName = truncateFilename(file.name);
                        const iconClass = type === 'image' ? 'uil-image-upload' : 'uil-video';

                        return `
                <div class="file-preview flex items-center justify-between p-4 bg-white rounded-xl border border-gray-300 shadow-sm ">
                    <div class="w-full">
                        <div class="flex justify-between items-center w-full space-x-1 mb-2">
                            <div class="flex items-center space-x-1 overflow-hidden">
                                <i class="uil ${iconClass} text-[#141B34] text-xl flex-shrink-0"></i>
                                <p class="text-sm font-[400] text-[#1B1B1B] truncate" title="${file.name}">${truncatedName}</p>
                            </div>
                            <button class="remove-btn text-gray-500 hover:text-red-500 flex-shrink-0">
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
                        }, 100); // Update every 250ms for 5 seconds total
                    }

                    // Handle file selection
                    function handleFileSelection(file) {
                        if (!file) return;

                        // Validate file type
                        if (type === 'image') {
                            if (!file.type.match('image/jpeg') && !file.type.match('image/png')) {
                                alert('Please select a valid JPEG or PNG image');
                                return;
                            }
                        } else if (type === 'video') {
                            if (!file.type.match('video/mp4') && !file.type.match('video/x-matroska')) {
                                alert('Please select a valid MP4 or MKV video');
                                return;
                            }

                            // Check file size for videos (max 200MB)
                            if (file.size > 200 * 1024 * 1024) {
                                alert('Video file size exceeds the maximum limit of 200MB');
                                return;
                            }
                        }

                        // Create and show preview
                        previewContainer.innerHTML = createPreviewElement(file, type);
                        previewContainer.classList.remove('hidden');

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

                    // Handle drag & drop
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
            });
        </script>
    @endpush
@endsection
