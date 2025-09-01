@extends('layouts.admin')
@section('content')
    @php
        $modules = session('course.add.content.modules', []);
        $moduleCount = count($modules);
    @endphp
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
                    <span class="text-[#E68815] font-semibold">Course Content</span>
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
                    </div>
                    <!-- Line to Next -->
                    <div class="w-12 md:w-28 h-[6px] md:h-[8px] line-gradient bg-[#E68815]"></div>
                </div>

                <!-- Step 4 -->
                <div class="relative flex items-center">
                    <div class="w-8 h-8 md:w-12 md:h-12 flex items-center relative justify-center rounded-full bg-[#E68815] text-white font-bold shadow-[inset_0_4px_6px_rgba(0,0,0,0.3)]">
                        4
                        <!-- Step Label -->
                        <div class="hidden md:block px-4 py-2 rounded-[10px] shadow-sm border border-[#929292] absolute -top-10 md:-top-14 left-1/2 -translate-x-1/2 whitespace-nowrap">
                    <span class="text-[#444444] text-xs md:text-sm font-medium">
                        Course Content
                    </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-auto bg-white rounded-[20px] px-4 py-4 md:px-6 md:py-6 shadow-sm overflow-hidden">
            <div class="flex flex-col items-center mb-8 gap-4 md:flex-row md:justify-between md:items-center">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 rounded-full bg-[#E68815] flex items-center justify-center">
                        <i class="uil uil-book-open text-white"></i>
                    </div>
                    <h3 class="text-base font-medium text-[#1B1B1B]">Course Content</h3>
                </div>

                <!-- Add Module Button -->
                <button id="add-module-btn" class="flex items-center justify-center space-x-1 w-full md:w-auto bg-[#E68815] hover:bg-[#cc770f] text-white text-sm font-medium px-5 py-3 rounded-full shadow">
                    <i class="uil uil-plus text-sm font-medium"></i>
                    <span>Add Module</span>
                </button>
            </div>

            <div>
                <form id="course-content-form" action="{{ route('admin.courses.add.store.content') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Errors:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div id="modules-container">
                        @foreach ($modules as $index => $mod)
                            @php
                                $key = $index + 1;
                            @endphp
                            <div class="border rounded-md overflow-hidden mb-6 module-item" data-module-id="{{ $key }}">
                                <div class="flex items-center justify-between px-4 py-3 bg-gray-100 cursor-pointer toggleModule">
                                    <label class="text-[#1B1B1B] text-sm font-medium">Module {{ $key }}:</label>
                                    <div class="flex items-center space-x-2">
                                        <input name="modules[{{ $key }}][title]" type="text" placeholder="Module title"
                                               class="module-title-input border border-[#E1E1E1] !w-full text-[#1B1B1B] text-sm rounded-md px-3 py-2 focus:border-[#E68815] focus:outline-none focus:ring-1 focus:ring-[#E68815]"
                                               value="{{ old('modules.' . $key . '.title', $mod['title'] ?? '') }}" />
                                        @error('modules.' . $key . '.title')
                                        <span class="error-message">{{ $message }}</span>
                                        @enderror
                                        <!-- caret icon -->
                                        <i class="uil uil-angle-down text-[#1B1B1B] text-lg transition-transform duration-300 toggleCaret"></i>
                                        <!-- remove button -->
                                        <button type="button" class="remove-module text-red-500 hover:text-red-700 ml-2">
                                            <i class="uil uil-trash-alt text-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="moduleContent px-4 py-4 transition-all duration-500 ease-in-out max-h-[1000px] overflow-hidden">
                                    <!-- YouTube Video URL -->
                                    <div>
                                        <label class="block text-[#1B1B1B] text-sm font-medium mb-1">YouTube Video URL</label>
                                        <input name="modules[{{ $key }}][video_url]" type="url" placeholder="Paste YouTube Video Link (URL)"
                                               class="w-full border border-[#E1E1E1] text-[#1B1B1B] text-sm rounded-md px-4 py-3 focus:border-[#E68815] focus:outline-none focus:ring-1 focus:ring-[#E68815]"
                                               value="{{ old('modules.' . $key . '.video_url', $mod['video_url'] ?? '') }}" />
                                        @error('modules.' . $key . '.video_url')
                                        <span class="error-message">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mt-8 w-full">
                                        <label class="block text-sm font-medium text-[#1B1B1B] mb-2">
                                            Upload resources<span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex flex-col md:flex-row gap-4">
                                            <!-- Dropzone -->
                                            <div class="image-dropzone dropzone flex flex-col items-center justify-center p-3 w-full md:w-1/3 h-36 border-2 border-dashed border-gray-400 rounded-xl cursor-pointer bg-white hover:border-[#E68815] transition">
                                                <input name="modules[{{ $key }}][resources][]" type="file" accept="image/png,image/jpeg,application/pdf,.doc,.docx" class="file-input hidden" multiple />
                                                <div>
                                                    <i class="uil uil-file-upload text-[#141B34] text-xl"></i>
                                                </div>
                                                <p class="text-sm text-gray-600">
                                                    Drag & Drop files or
                                                    <span class="browseBtn text-[#E68815] font-medium cursor-pointer">Browse</span>
                                                </p>
                                                <p class="text-xs text-gray-400 mt-1">JPG, PNG, PDF, DOC, DOCX (max 5MB)</p>
                                            </div>
                                            <!-- Uploaded file preview container -->
                                            <div class="preview-container grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 w-full md:w-2/3 module-preview-{{ $key }}">
                                                @if (!empty($mod['resources']))
                                                    @foreach ($mod['resources'] as $resource)
                                                        @php
                                                            $extension = pathinfo($resource, PATHINFO_EXTENSION);
                                                            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png']);
                                                        @endphp
                                                        <div class="file-preview flex flex-col justify-between p-4 bg-white rounded-xl border border-gray-300 shadow-sm">
                                                            <div class="w-full">
                                                                <div class="flex justify-between items-center w-full space-x-1 mb-2">
                                                                    <div class="flex items-center space-x-1 overflow-hidden">
                                                                        @if ($isImage)
                                                                            <img src="{{ $resource }}" alt="Resource" class="w-8 h-8 object-cover rounded" />
                                                                        @else
                                                                            <i class="uil uil-file-alt text-[#141B34] text-xl flex-shrink-0"></i>
                                                                        @endif
                                                                        <p class="text-sm font-[400] text-[#1B1B1B] truncate" title="{{ basename($resource) }}">{{ Str::limit(basename($resource), 35) }}</p>
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
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        @error('modules.' . $key . '.resources')
                                        <span class="error-message">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-8 w-full">
                        <a href="{{ route('admin.courses.add.photos.videos') }}" id="prev-button" class="bg-[#EDEDED] block text-center w-full text-gray-800 text-sm font-medium px-6 py-3 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Prev
                        </a>

                        <button type="submit" id="next-button" class="bg-[#E68815] w-full text-white text-sm px-6 py-3 rounded-full hover:bg-[#cc6f0f] focus:outline-none focus:ring-2 focus:ring-[#E68815] flex items-center justify-center transition duration-200">
                            <span class="submit-text">Save</span>
                        </button>
                    </div>
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

        .module-title-input {
            width: 400px;
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

        .preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }

        .file-preview {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 120px;
        }

        @media (max-width: 768px) {
            .preview-container {
                grid-template-columns: 1fr;
            }

            .image-dropzone {
                width: 100% !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('course-content-form');
            const modulesContainer = document.getElementById('modules-container');
            const addModuleBtn = document.getElementById('add-module-btn');
            const nextButton = document.getElementById('next-button');
            let moduleCount = {{ $moduleCount }};
            let isSubmitting = false;

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

            // Format file size to readable format
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
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

            // Add module button event
            addModuleBtn.addEventListener('click', function() {
                addNewModule();
            });

            // Function to create a new module
            function addNewModule() {
                moduleCount++;
                const moduleHTML = `
                    <div class="border rounded-md overflow-hidden mb-6 module-item" data-module-id="${moduleCount}">
                        <div class="flex items-center justify-between px-4 py-3 bg-gray-100 cursor-pointer toggleModule">
                            <label class="text-[#1B1B1B] text-sm font-medium">Module ${moduleCount}:</label>
                            <div class="flex items-center space-x-2">
                                <input name="modules[${moduleCount}][title]" type="text" placeholder="Module title"
                                    class="module-title-input border border-[#E1E1E1] !w-full text-[#1B1B1B] text-sm rounded-md px-3 py-2 focus:border-[#E68815] focus:outline-none focus:ring-1 focus:ring-[#E68815]" />
                                <!-- caret icon -->
                                <i class="uil uil-angle-down text-[#1B1B1B] text-lg transition-transform duration-300 toggleCaret"></i>
                                <!-- remove button -->
                                <button type="button" class="remove-module text-red-500 hover:text-red-700 ml-2">
                                    <i class="uil uil-trash-alt text-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div class="moduleContent px-4 py-4 transition-all duration-500 ease-in-out max-h-[1000px] overflow-hidden">
                            <!-- YouTube Video URL -->
                            <div>
                                <label class="block text-[#1B1B1B] text-sm font-medium mb-1">YouTube Video URL</label>
                                <input name="modules[${moduleCount}][video_url]" type="url" placeholder="Paste YouTube Video Link (URL)"
                                    class="w-full border border-[#E1E1E1] text-[#1B1B1B] text-sm rounded-md px-4 py-3 focus:border-[#E68815] focus:outline-none focus:ring-1 focus:ring-[#E68815]" />
                            </div>
                            <div class="mt-8 w-full">
                                <label class="block text-sm font-medium text-[#1B1B1B] mb-2">
                                    Upload resources<span class="text-red-500">*</span>
                                </label>
                                <div class="flex flex-col md:flex-row gap-4">
                                    <!-- Dropzone -->
                                    <div class="image-dropzone dropzone flex flex-col items-center justify-center p-3 w-full md:w-1/3 h-36 border-2 border-dashed border-gray-400 rounded-xl cursor-pointer bg-white hover:border-[#E68815] transition">
                                        <input name="modules[${moduleCount}][resources][]" type="file" accept="image/png,image/jpeg,application/pdf,.doc,.docx" class="file-input hidden" multiple />
                                        <div>
                                            <i class="uil uil-file-upload text-[#141B34] text-xl"></i>
                                        </div>
                                        <p class="text-sm text-gray-600">
                                            Drag & Drop files or
                                            <span class="browseBtn text-[#E68815] font-medium cursor-pointer">Browse</span>
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">JPG, PNG, PDF, DOC, DOCX (max 5MB)</p>
                                    </div>
                                    <!-- Uploaded file preview container -->
                                    <div class="preview-container grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 w-full md:w-2/3 module-preview-${moduleCount}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Add module to container
                modulesContainer.insertAdjacentHTML('beforeend', moduleHTML);

                // Initialize the new module
                initializeModule(moduleCount);
            }

            // Function to initialize module functionality
            function initializeModule(moduleId) {
                const moduleElement = modulesContainer.querySelector(`[data-module-id="${moduleId}"]`);
                if (!moduleElement) return; // Guard against missing module

                const header = moduleElement.querySelector('.toggleModule');
                const content = moduleElement.querySelector('.moduleContent');
                const caret = moduleElement.querySelector('.toggleCaret');
                const titleInput = moduleElement.querySelector('.module-title-input');
                const removeBtn = moduleElement.querySelector('.remove-module');
                const dropzone = moduleElement.querySelector('.image-dropzone');
                const fileInput = moduleElement.querySelector('.file-input');
                const browseBtn = dropzone.querySelector('.browseBtn');
                const previewContainer = moduleElement.querySelector(`.module-preview-${moduleId}`);

                // Toggle functionality
                const toggleModule = () => {
                    if (content.classList.contains('max-h-0')) {
                        content.classList.remove('max-h-0', 'py-0');
                        content.classList.add('max-h-[1000px]', 'py-4');
                        caret.classList.add('rotate-180');
                    } else {
                        content.classList.remove('max-h-[1000px]', 'py-4');
                        content.classList.add('max-h-0', 'py-0');
                        caret.classList.remove('rotate-180');
                    }
                };

                // Header click event
                header.addEventListener('click', (e) => {
                    if (!titleInput.contains(e.target) && !removeBtn.contains(e.target)) {
                        toggleModule();
                    }
                });

                // Caret click event
                caret.addEventListener('click', (e) => {
                    e.stopPropagation();
                    toggleModule();
                });

                // Remove module event
                removeBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (moduleCount > 1) {
                        moduleElement.remove();
                        moduleCount--;
                        // Renumber remaining modules
                        renumberModules();
                    } else {
                        showError('You must have at least one module.');
                    }
                });

                // Prevent input from triggering toggle
                titleInput.addEventListener('click', (e) => {
                    e.stopPropagation();
                });

                // File upload functionality
                function initFileHandling() {
                    // Click browse text
                    browseBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        fileInput.click();
                    });

                    dropzone.addEventListener('click', (e) => {
                        if (e.target === dropzone || e.target.closest('p') || e.target.closest('i') || e.target.classList.contains('browseBtn')) {
                            e.preventDefault();
                            e.stopPropagation();
                            fileInput.click();
                        }
                    });

                    // Handle file input change
                    fileInput.addEventListener('change', function() {
                        if (this.files && this.files.length > 0) {
                            handleFileSelection(this.files, moduleId);
                        }
                    });

                    // Drag and drop events
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

                        if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                            handleFileSelection(e.dataTransfer.files, moduleId);
                        }
                    });
                }

                // Initialize file handling
                initFileHandling();

                // File selection handler
                function handleFileSelection(files) {
                    Array.from(files).forEach(file => {
                        const validTypes = ['image/jpeg', 'image/png', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                        if (!validTypes.includes(file.type)) {
                            showError('Please select valid JPEG, PNG, PDF, DOC, or DOCX files only');
                            return;
                        }

                        // Validate file size (max 5MB)
                        if (file.size > 5 * 1024 * 1024) {
                            showError('File size exceeds the maximum limit of 5MB');
                            return;
                        }

                        const previewHTML = createPreviewElement(file);
                        previewContainer.insertAdjacentHTML('beforeend', previewHTML);

                        const previewElement = previewContainer.lastElementChild;
                        const removeBtn = previewElement.querySelector('.remove-btn');

                        removeBtn.addEventListener('click', function() {
                            previewElement.remove();
                        });

                        simulateUpload(previewElement);
                    });
                }

                // Create a preview element for new uploads
                function createPreviewElement(file) {
                    const fileSize = formatFileSize(file.size);
                    const truncatedName = truncateFilename(file.name);
                    const isImage = ['image/jpeg', 'image/png'].includes(file.type);

                    // Use FileReader to generate a data URL for images
                    let previewContent = `<i class="uil uil-file-alt text-[#141B34] text-xl flex-shrink-0"></i>`;
                    if (isImage) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const imgElement = previewContainer.querySelector(`[data-filename="${file.name}"] .file-preview-icon`);
                            if (imgElement) {
                                imgElement.outerHTML = `<img src="${e.target.result}" alt="Resource" class="w-8 h-8 object-cover rounded" />`;
                            }
                        };
                        reader.readAsDataURL(file);
                    }

                    return `
                        <div class="file-preview flex flex-col justify-between p-4 bg-white rounded-xl border border-gray-300 shadow-sm" data-filename="${file.name}">
                            <div class="w-full">
                                <div class="flex justify-between items-center w-full space-x-1 mb-2">
                                    <div class="flex items-center space-x-1 overflow-hidden">
                                        <span class="file-preview-icon">${previewContent}</span>
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

                // Initialize remove buttons for existing resources
                const existingRemoveButtons = moduleElement.querySelectorAll('.remove-btn');
                existingRemoveButtons.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const previewElement = this.closest('.file-preview');
                        const imgSrc = previewElement.querySelector('img')?.src;
                        previewElement.remove();
                        if (imgSrc) {
                            const hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.name = `modules[${moduleId}][remove_resources][]`;
                            hiddenInput.value = imgSrc;
                            form.appendChild(hiddenInput);
                        }
                    });
                });
            }

            // Renumber modules after deletion
            function renumberModules() {
                const modules = modulesContainer.querySelectorAll('.module-item');
                let newCount = 0;
                modules.forEach((module) => {
                    newCount++;
                    module.setAttribute('data-module-id', newCount);

                    // Update labels and names
                    const label = module.querySelector('.toggleModule label');
                    if (label) {
                        label.textContent = `Module ${newCount}:`;
                    }

                    const titleInput = module.querySelector('.module-title-input');
                    if (titleInput) {
                        titleInput.name = `modules[${newCount}][title]`;
                    }

                    const videoInput = module.querySelector('input[type="url"]');
                    if (videoInput) {
                        videoInput.name = `modules[${newCount}][video_url]`;
                    }

                    const fileInput = module.querySelector('.file-input');
                    if (fileInput) {
                        fileInput.name = `modules[${newCount}][resources][]`;
                    }

                    // Update preview container class
                    const oldPreview = module.querySelector(`.preview-container`);
                    if (oldPreview) {
                        oldPreview.className = `preview-container grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 w-full md:w-2/3 module-preview-${newCount}`;
                    }

                    // Update remove_resources hidden inputs
                    const removeInputs = form.querySelectorAll(`input[name^="modules["][name$="[remove_resources][]"]`);
                    removeInputs.forEach(input => {
                        const oldId = input.name.match(/modules\[(\d+)]/)?.[1];
                        if (oldId && parseInt(oldId) > newCount) {
                            input.name = input.name.replace(`modules[${oldId}]`, `modules[${parseInt(oldId)-1}]`);
                        }
                    });
                });
                moduleCount = newCount;
            }

            // Form validation
            function validateForm() {
                const modules = modulesContainer.querySelectorAll('.module-item');
                if (modules.length === 0) {
                    showError('At least one module is required.');
                    return false;
                }

                for (let module of modules) {
                    const moduleId = module.getAttribute('data-module-id');
                    const titleInput = module.querySelector('.module-title-input');
                    const previewContainer = module.querySelector(`.module-preview-${moduleId}`);

                    if (!titleInput || !previewContainer) {
                        showError('Module structure is invalid.');
                        return false;
                    }

                    if (titleInput.value.trim() === '') {
                        showError(`Module ${moduleId} title is required.`);
                        titleInput.focus();
                        return false;
                    }

                    if (previewContainer.children.length === 0) {
                        showError(`At least one resource is required for Module ${moduleId}.`);
                        return false;
                    }
                }
                return true;
            }

            // Form submission handler
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                if (isSubmitting) {
                    return;
                }

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
                        <span>Saving...</span>
                    </span>
                `;
                nextButton.disabled = true;

                // Submit the form after a short delay for visual feedback
                setTimeout(() => {
                    form.submit();
                }, 500);
            });

            // Initialize existing modules
            document.querySelectorAll('.module-item').forEach(module => {
                const moduleId = module.getAttribute('data-module-id');
                initializeModule(moduleId);
            });

            // Add initial module if none exist
            if (moduleCount === 0) {
                addNewModule();
            }
        });
    </script>
@endpush
