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

                </div>
                <!-- Line to Next -->
                <div class="w-28 h-[8px] line-gradient bg-[#E68815]"></div>
            </div>


            <!-- Step 4 -->
            <div class="relative flex items-center">
                <div
                    class="w-12 h-12 flex items-center relative justify-center rounded-full bg-[#E68815] text-white font-bold shadow-[inset_0_4px_6px_rgba(0,0,0,0.3)]">
                    4

                    <!-- Step Label -->
                    <div
                        class="px-4 py-2 inline-block rounded-[10px] shadow-sm border border-[#929292] absolute -top-14 left-1/2 -translate-x-1/2 whitespace-nowrap">
                        <span class="text-[#444444] text-sm font-medium">
                            Course Content
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-auto bg-white rounded-[20px] px-4 py-4 md:px-6 md:py-6 shadow-sm overflow-hidden ">

        {{-- header  --}}
        <div class="flex flex-row justify-between mb-8 gap-2 items-center md:flex-row md:justify-between">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 rounded-full bg-[#E68815] flex items-center justify-center">
                    <i class="uil uil-book-open text-white"></i>
                </div>
                <h3 class="text-base font-medium text-[#1B1B1B]">Course Content</h3>
            </div>

            <!-- Add Module Button -->
            <button id="add-module-btn"
                class="flex items-center justify-center space-x-1 w-full md:w-auto bg-[#E68815] hover:bg-[#cc770f] text-white text-sm font-medium px-5 py-3 rounded-full shadow mt-6">
                <i class="uil uil-plus text-sm font-medium"></i>
                <span>Add Module</span>
            </button>
        </div>


        {{-- content  --}}
        <div>
            <form action="" method="" enctype="multipart/form-data">
                @csrf



                <div id="modules-container">
                    <!-- Initial module will be here -->
                </div>



                {{-- buttons  --}}
                <div class="grid grid-cols-2 gap-4 mt-8 w-full">
                    <a href="" type="button" id="prev-button"
                        class="bg-[#EDEDED] block text-center w-full text-gray-800 text-sm font-medium px-6 py-3 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Prev
                    </a>

                    <button type="submit" id="next-button"
                        class="bg-[#E68815] w-full text-white text-sm px-6 py-3 rounded-full hover:bg-[#cc6f0f] focus:outline-none focus:ring-2 focus:ring-[#E68815] flex items-center justify-center transition duration-200">
                        <span class="submit-text">Save</span>
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

            .module-title-input {
                width: 400px;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
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
                function createPreviewElement(file) {
                    const fileSize = formatFileSize(file.size);
                    const truncatedName = truncateFilename(file.name);

                    return `
            <div class="file-preview flex items-center justify-between h-36 p-4 bg-white rounded-xl border border-gray-300 shadow-sm" data-filename="${file.name}">
                <div class="w-full">
                    <div class="flex justify-between items-center w-full space-x-1 mb-2">
                        <div class="flex items-center space-x-1 overflow-hidden">
                            <i class="uil uil-image-upload text-[#141B34] text-xl flex-shrink-0"></i>
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
                    }, 100);
                }

                // Handle file selection
                function handleFileSelection(files) {
                    if (!files || files.length === 0) return;

                    // Clear existing previews if needed, or keep for multiple uploads
                    // previewContainer.innerHTML = ''; // Uncomment to replace instead of add

                    Array.from(files).forEach(file => {
                        // Validate file type
                        if (!file.type.match('image/jpeg') && !file.type.match('image/png')) {
                            alert('Please select valid JPEG or PNG images only');
                            return;
                        }

                        // Create and show preview
                        const previewHTML = createPreviewElement(file);
                        previewContainer.insertAdjacentHTML('beforeend', previewHTML);

                        const previewElements = previewContainer.querySelectorAll('.file-preview');
                        const previewElement = previewElements[previewElements.length - 1];

                        // Setup remove button
                        const removeBtn = previewElement.querySelector('.remove-btn');
                        removeBtn.addEventListener('click', function() {
                            previewElement.remove();
                            // Note: For multiple files, we might want to update the file input
                        });

                        // Simulate upload progress
                        simulateUpload(previewElement);
                    });
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
                    if (this.files && this.files.length > 0) {
                        handleFileSelection(this.files);
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

                    if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                        handleFileSelection(e.dataTransfer.files);
                    }
                });
            });
        </script>
    @endpush


    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modulesContainer = document.getElementById('modules-container');
                const addModuleBtn = document.getElementById('add-module-btn');
                let moduleCount = 0;

                // Add initial module
                addNewModule();

                // Add module button event
                addModuleBtn.addEventListener('click', function() {
                    addNewModule();
                });

                // Function to create a new module
                function addNewModule() {
                    moduleCount++;
                    const moduleId = `module-${moduleCount}`;
                    const moduleHTML = `
            <div class="border rounded-md overflow-hidden mb-6 module-item" data-module-id="${moduleCount}">
                {{-- module title with caret --}}
                <div class="flex items-center justify-between px-4 py-3 bg-gray-100 cursor-pointer toggleModule">
                    <label class="text-[#1B1B1B] text-sm font-medium">Module ${moduleCount}:</label>

                    <div class="flex items-center space-x-2">
                        <input name="modules[${moduleCount}][title]" type="text" placeholder="Module title"
                            class="module-title-input border border-[#E1E1E1] !w-full text-[#1B1B1B] text-sm rounded-md px-3 py-2 focus:border-[#E68815] focus:outline-none focus:ring-1 focus:ring-[#E68815]"  />

                        <!-- caret icon -->
                        <i class="uil uil-angle-down text-[#1B1B1B] text-lg transition-transform duration-300 toggleCaret"></i>

                        <!-- remove button -->
                        <button type="button" class="remove-module text-red-500 hover:text-red-700 ml-2">
                            <i class="uil uil-trash-alt text-lg"></i>
                        </button>
                    </div>
                </div>

                {{-- module content --}}
                <div class="moduleContent px-4 py-4 transition-all duration-500 ease-in-out max-h-[1000px] overflow-hidden">
                    <!-- YouTube Video URL -->
                    <div>
                        <label class="block text-[#1B1B1B] text-sm font-medium mb-1">YouTube Video URL</label>
                        <input name="modules[${moduleCount}][video_url]" type="url" placeholder="Paste YouTube Video Link (URL)"
                            class="w-full border border-[#E1E1E1] text-[#1B1B1B] text-sm rounded-md px-4 py-3 focus:border-[#E68815] focus:outline-none focus:ring-1 focus:ring-[#E68815]" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8 w-full">
                        {{-- for cover image --}}
                        <div class="">
                            <label class="block text-sm font-medium text-[#1B1B1B] mb-2">
                                Upload resources<span class="text-red-500">*</span>
                            </label>

                            <!-- Dropzone -->
                            <div class="image-dropzone dropzone flex flex-col items-center justify-center p-3 w-full h-36 border-2 border-dashed border-gray-400 rounded-xl cursor-pointer bg-white hover:border-[#E68815] transition">
                                <input name="modules[${moduleCount}][resources][]" type="file" accept="image/png,image/jpeg" class="file-input hidden" multiple />

                                <div>
                                    <i class="uil uil-image-upload text-[#141B34] text-xl"></i>
                                </div>

                                <p class="text-sm text-gray-600">
                                    Drag & Drop images or
                                    <span class="browseBtn text-[#E68815] font-medium cursor-pointer">Browse</span>
                                </p>
                                <p class="text-xs text-gray-400 mt-1">JPG, PNG, or JPEG format (max 1920 × 1080)</p>
                            </div>
                        </div>

                        <!-- Uploaded image preview container -->
                        <div class="preview-container mt-[27px] space-y-3 module-preview-${moduleCount}"></div>
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
                    const moduleElement = document.querySelector(`[data-module-id="${moduleId}"]`);
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
                            alert('You must have at least one module.');
                        }
                    });

                    // Prevent input from triggering toggle
                    titleInput.addEventListener('click', (e) => {
                        e.stopPropagation();
                    });

                    // File upload functionality
                    function initFileHandling() {
                        // Click browse text -
                        browseBtn.addEventListener('click', (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            fileInput.click();
                        });


                        dropzone.addEventListener('click', (e) => {
                            // Only trigger if clicking directly on the dropzone, not on its children
                            if (e.target === dropzone || e.target === dropzone.querySelector('i') ||
                                e.target === dropzone.querySelector('p') || e.target === dropzone.querySelector(
                                    'span')) {
                                e.preventDefault();
                                e.stopPropagation();
                                fileInput.click();
                            }
                        });

                        // Handle file input change
                        fileInput.addEventListener('change', function(e) {
                            if (this.files && this.files.length > 0) {
                                handleFileSelection(this.files, moduleId);
                                // Don't reset the input value here to maintain file selection
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
                    function handleFileSelection(files, modId) {
                        Array.from(files).forEach(file => {
                            if (!file.type.match('image/jpeg') && !file.type.match('image/png')) {
                                alert('Please select valid JPEG or PNG images only');
                                return;
                            }

                            const previewHTML = createPreviewElement(file, modId);
                            previewContainer.insertAdjacentHTML('beforeend', previewHTML);

                            const previewElement = previewContainer.lastElementChild;
                            const removeBtn = previewElement.querySelector('.remove-btn');

                            removeBtn.addEventListener('click', function() {
                                previewElement.remove();
                            });

                            simulateUpload(previewElement);
                        });
                    }

                    // Helper functions
                    function formatFileSize(bytes) {
                        if (bytes === 0) return '0 Bytes';
                        const k = 1024;
                        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                        const i = Math.floor(Math.log(bytes) / Math.log(k));
                        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                    }

                    function truncateFilename(name, maxLength = 35) {
                        if (name.length <= maxLength) return name;
                        const extensionIndex = name.lastIndexOf('.');
                        if (extensionIndex === -1) return name.substring(0, maxLength - 3) + '...';

                        const extension = name.substring(extensionIndex);
                        const nameWithoutExt = name.substring(0, extensionIndex);

                        if (nameWithoutExt.length <= maxLength - extension.length) return name;

                        return nameWithoutExt.substring(0, maxLength - extension.length - 3) + '...' + extension;
                    }

                    function createPreviewElement(file, modId) {
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
                }

                // Renumber modules after deletion
                function renumberModules() {
                    const modules = document.querySelectorAll('.module-item');
                    modules.forEach((module, index) => {
                        const moduleId = index + 1;
                        module.setAttribute('data-module-id', moduleId);

                        // Update labels and names
                        const label = module.querySelector('.toggleModule label');
                        label.textContent = `Module ${moduleId}:`;

                        const titleInput = module.querySelector('.module-title-input');
                        titleInput.name = `modules[${moduleId}][title]`;

                        const videoInput = module.querySelector('input[type="url"]');
                        videoInput.name = `modules[${moduleId}][video_url]`;

                        const fileInput = module.querySelector('.file-input');
                        fileInput.name = `modules[${moduleId}][resources][]`;

                        // Update preview container class
                        const previewContainer = module.querySelector('[class^="preview-container"]');
                        previewContainer.className =
                            `preview-container mt-[27px] space-y-3 module-preview-${moduleId}`;
                    });
                }
            });
        </script>
    @endpush
@endsection
