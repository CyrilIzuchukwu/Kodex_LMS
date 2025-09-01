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
                    <span class="text-[#E68815] font-semibold">SEO Settings</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="container mx-auto mt-4 mb-5" id="main-content">
        <!-- settings -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
            <div class="col-span-1 md:col-span-4 lg:col-span-4">
                <div class="sticky top-20">
                    <div class="w-auto bg-white rounded-[20px] md:rounded-[30px] px-6 md:px-8 py-6 md:py-8 shadow-sm overflow-hidden">
                        <ul class="space-y-4">
                            <li>
                                <a class="flex items-center space-x-3 p-2 rounded-lg text-[#1B1B1B] hover:bg-[#F5CE9F] transition" href="{{ route('admin.settings.index') }}">
                                    <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                        <i class="uil uil-setting text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-[18px] leading-[100%] tracking-[-0.02em]">General Settings</p>
                                        <p class="text-sm text-[#6B7280]">Manage site name, logo, and description.</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center space-x-3 p-2 rounded-lg bg-[#F5CE9F] text-[#1B1B1B]" href="{{ route('admin.settings.seo') }}">
                                    <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                        <i class="uil uil-search-alt text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-[18px] leading-[100%] tracking-[-0.02em]">SEO</p>
                                        <p class="text-sm text-[#6B7280]">Configure SEO settings for better visibility.</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center space-x-3 p-2 rounded-lg text-[#1B1B1B] hover:bg-[#F5CE9F] transition" href="{{ route('admin.settings.maintenance') }}">
                                    <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                        <i class="uil uil-wrench text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-[18px] leading-[100%] tracking-[-0.02em]">Maintenance</p>
                                        <p class="text-sm text-[#6B7280]">Control maintenance mode and updates.</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center space-x-3 p-2 rounded-lg text-[#1B1B1B] hover:bg-[#F5CE9F] transition" href="{{ route('admin.settings.extensions') }}">
                                    <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                        <i class="uil uil-plug text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-[18px] leading-[100%] tracking-[-0.02em]">Extensions</p>
                                        <p class="text-sm text-[#6B7280]">Manage plugins and extensions.</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-span-1 md:col-span-8 lg:col-span-8">
                <div class="w-auto bg-white rounded-[20px] md:rounded-[30px] px-6 md:px-8 py-6 md:py-8 shadow-sm overflow-hidden">
                    <!-- SEO Settings -->
                    <form id="seo-settings-form" method="POST" action="{{ route('admin.settings.update.seo') }}" class="flex flex-col h-full" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="flex items-center space-x-3 mb-12">
                            <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                <i class="uil uil-search-alt text-xl"></i>
                            </div>
                            <h2 class="font-medium text-[18px] leading-[100%] tracking-[-0.02em] text-[#1B1B1B]">
                                SEO Settings
                            </h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-5">
                                <label for="meta_title" class="block text-sm font-medium text-[#6B7280] mb-1">Meta Title *</label>
                                <input id="meta_title" type="text" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" name="meta_title" value="{{ old('meta_title', seo_settings()->meta_title ?? '') }}" placeholder="Meta Title" autocomplete="off" maxlength="60">
                                @error('meta_title')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="meta_description" class="block text-sm font-medium text-[#6B7280] mb-1">Meta Description *</label>
                                <textarea id="meta_description" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" name="meta_description" placeholder="Meta Description" rows="4" maxlength="160">{{ old('meta_description', seo_settings()->meta_description ?? '') }}</textarea>
                                @error('meta_description')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="meta_keywords" class="block text-sm font-medium text-[#6B7280] mb-1">Meta Keywords</label>
                                <input id="meta_keywords" type="text" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" name="meta_keywords" value="{{ old('meta_keywords', seo_settings()->meta_keywords ?? '') }}" placeholder="e.g., keyword1, keyword2, keyword3" autocomplete="off" maxlength="255">
                                @error('meta_keywords')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="seo_image" class="block text-sm font-medium text-[#6B7280] mb-1">SEO Image</label>
                                <div class="image-dropzone dropzone flex flex-col items-center justify-center p-3 w-full h-36 border-2 border-dashed border-gray-400 rounded-xl cursor-pointer bg-white hover:border-[#E68815] transition">
                                    <input type="file" name="seo_image" accept="image/png,image/jpeg" class="file-input hidden" />
                                    <div>
                                        <i class="uil uil-image-upload text-[#141B34] text-xl"></i>
                                    </div>
                                    <p class="text-sm text-gray-600">
                                        Drag & Drop image or
                                        <span class="browseBtn text-[#E68815] font-medium cursor-pointer">Browse</span>
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, or JPEG format (max 1920 × 1080, 5MB)</p>
                                </div>
                                @error('seo_image')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                                <div id="imagePreviewContainer" class="preview-container mt-3 hidden"></div>
                            </div>

                            <div class="mb-5">
                                <label for="og_title" class="block text-sm font-medium text-[#6B7280] mb-1">Open Graph Title</label>
                                <input id="og_title" type="text" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" name="og_title" value="{{ old('og_title', seo_settings()->og_title ?? '') }}" placeholder="Open Graph Title" autocomplete="off" maxlength="95">
                                @error('og_title')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="og_description" class="block text-sm font-medium text-[#6B7280] mb-1">Open Graph Description</label>
                                <textarea id="og_description" rows="4" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" name="og_description" placeholder="Open Graph Description" maxlength="200">{{ old('og_description', seo_settings()->og_description ?? '') }}</textarea>
                                @error('og_description')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="robots" class="block text-sm font-medium text-[#6B7280] mb-1">Robots Meta Tag</label>
                                <select id="robots" name="robots" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B]">
                                    <option value="index,follow" {{ old('robots', seo_settings()->robots ?? '') == 'index,follow' ? 'selected' : '' }}>Index, Follow</option>
                                    <option value="noindex,nofollow" {{ old('robots', seo_settings()->robots ?? '') == 'noindex,nofollow' ? 'selected' : '' }}>Noindex, Nofollow</option>
                                    <option value="index,nofollow" {{ old('robots', seo_settings()->robots ?? '') == 'index,nofollow' ? 'selected' : '' }}>Index, Nofollow</option>
                                    <option value="noindex,follow" {{ old('robots', seo_settings()->robots ?? '') == 'noindex,follow' ? 'selected' : '' }}>Noindex, Follow</option>
                                </select>
                                @error('robots')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="twitter_card" class="block text-sm font-medium text-[#6B7280] mb-1">Twitter Card Type</label>
                                <select id="twitter_card" name="twitter_card" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B]">
                                    <option value="summary" {{ old('twitter_card', seo_settings()->twitter_card ?? '') == 'summary' ? 'selected' : '' }}>Summary</option>
                                    <option value="summary_large_image" {{ old('twitter_card', seo_settings()->twitter_card ?? '') == 'summary_large_image' ? 'selected' : '' }}>Summary Large Image</option>
                                </select>
                                @error('twitter_card')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button id="submit-btn" type="submit" class="mt-auto w-full bg-[#EB8C22] text-white font-medium py-3 rounded-full hover:bg-[#d1761a] transition">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (seo_settings()?->seo_image)
        <script id="existing-media">
            @json(['seo_image' => seo_settings()?->seo_image])
        </script>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('seo-settings-form');
            const submitBtn = document.getElementById('submit-btn');
            const dropzone = document.querySelector('.image-dropzone');
            const fileInput = dropzone.querySelector('.file-input');
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

            // Load existing SEO image
            function loadExistingMedia() {
                const existingMediaScript = document.getElementById('existing-media');
                if (existingMediaScript && existingMediaScript.textContent.trim()) {
                    try {
                        const sessionData = JSON.parse(existingMediaScript.textContent);
                        if (sessionData && sessionData.seo_image) {
                            displayExistingPhoto(sessionData.seo_image);
                        }
                    } catch (error) {
                        console.error('Error parsing existing media JSON:', error);
                    }
                }
            }

            // Display existing photo
            function displayExistingPhoto(photoUrl) {
                const fileName = photoUrl.split('/').pop();
                const truncatedName = truncateFilename(fileName);

                previewContainer.innerHTML = `
                    <div class="file-preview flex items-center justify-between p-4 bg-white rounded-xl border border-gray-300 shadow-sm">
                        <div class="w-full">
                            <div class="flex justify-between items-center w-full space-x-1 mb-2">
                                <div class="flex items-center space-x-1 overflow-hidden">
                                    <img src="${photoUrl}" alt="SEO image" class="w-8 h-8 object-cover rounded" />
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
                previewContainer.classList.remove('hidden');

                // Setup remove button
                const removeBtn = previewContainer.querySelector('.remove-btn');
                removeBtn.addEventListener('click', function() {
                    previewContainer.innerHTML = '';
                    previewContainer.classList.add('hidden');
                    fileInput.value = '';
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'remove_seo_image';
                    hiddenInput.value = photoUrl;
                    form.appendChild(hiddenInput);
                });
            }

            // Create a preview element for new uploads
            function createPreviewElement(file, previewUrl) {
                const fileSize = formatFileSize(file.size);
                const truncatedName = truncateFilename(file.name);

                return `
                    <div class="file-preview flex items-center justify-between p-4 bg-white rounded-xl border border-gray-300 shadow-sm">
                        <div class="w-full">
                            <div class="flex justify-between items-center w-full space-x-1 mb-2">
                                <div class="flex items-center space-x-1 overflow-hidden">
                                    <img src="${previewUrl}" alt="SEO image" class="w-8 h-8 object-cover rounded" />
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
                if (!file.type.match('image/jpeg') && !file.type.match('image/png')) {
                    iziToast.error({ ...iziToastSettings, message: 'Please select a valid JPEG or PNG image' });
                    fileInput.value = '';
                    return;
                }

                // Validate file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    iziToast.error({ ...iziToastSettings, message: 'Image file size exceeds the maximum limit of 5MB' });
                    fileInput.value = '';
                    return;
                }

                // Validate image dimensions (max 1920x1080)
                const img = new Image();
                img.onload = function() {
                    if (img.width > 1920 || img.height > 1080) {
                        iziToast.error({ ...iziToastSettings, message: 'Image dimensions exceed the maximum limit of 1920x1080' });
                        fileInput.value = '';
                        return;
                    }

                    // Clear existing previews and hidden inputs
                    previewContainer.innerHTML = '';
                    previewContainer.classList.remove('hidden');
                    const existingHiddenInput = form.querySelector('input[name="remove_seo_image"]');
                    if (existingHiddenInput) {
                        existingHiddenInput.remove();
                    }

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
                    iziToast.error({ ...iziToastSettings, message: 'Invalid image file' });
                    fileInput.value = '';
                };
                img.src = URL.createObjectURL(file);
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
                    button.innerHTML = `Save Changes`;
                    button.disabled = false;
                    return;
                }

                // Submit form after delay for animation
                setTimeout(() => form.submit(), 500);
            });

            // Initialize with an existing image
            loadExistingMedia();
        });
    </script>
@endpush
