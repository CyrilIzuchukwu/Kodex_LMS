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
                    <span class="text-[#E68815] font-semibold">Course Outcones</span>
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
                    </div>
                    <!-- Line to Next -->
                    <div class="w-12 md:w-28 h-[6px] md:h-[8px] line-gradient bg-[#E68815]"></div>
                </div>

                <!-- Step 2 -->
                <div class="relative flex items-center">
                    <div class="w-8 h-8 md:w-12 md:h-12 flex items-center relative justify-center rounded-full bg-[#E68815] text-white font-bold shadow-[inset_0_4px_6px_rgba(0,0,0,0.3)]">
                        2
                        <!-- Step Label -->
                        <div class="hidden md:block px-4 py-2 rounded-[10px] shadow-sm border border-[#929292] absolute -top-10 md:-top-14 left-1/2 -translate-x-1/2 whitespace-nowrap">
                    <span class="text-[#444444] text-xs md:text-sm font-medium">
                        Course Outcomes
                    </span>
                        </div>
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

        <div class="w-auto bg-white rounded-[20px] px-4 py-4 md:px-6 md:py-6 shadow-sm overflow-hidden ">
            <div class="flex flex-row justify-between mb-8 gap-2">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 rounded-full bg-[#E68815] flex items-center justify-center">
                        <i class="uil uil-tag text-white"></i>
                    </div>
                    <h3 class="text-base font-medium text-[#1B1B1B]">Edit Course Outcomes</h3>
                </div>
            </div>

            <p class="text-gray-600 text-sm mb-6">
                Update what students will learn in your course. Press comma or enter to add tags.
            </p>

            <form id="course-outcomes-form" action="{{ route('admin.courses.edit.update.outcomes', $course->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-[#1B1B1B] mb-2">What students will learn?</label>

                        <div id="tag-input-container" class="tag-container">
                            <!-- Tags will be inserted here -->
                            <input type="text" id="tag-input" class="tag-input" placeholder="Javascript">
                        </div>

                        <span id="error-message" class="error-message">Please enter at least one learning objective</span>

                        <!-- Laravel validation errors -->
                        @if ($errors->has('learning_objectives'))
                            <span class="error-message" style="display: block;">{{ $errors->first('learning_objectives') }}</span>
                        @endif

                        <!-- Hidden textarea to store the actual values for form submission -->
                        <textarea id="hidden-textarea" name="learning_objectives" class="hidden"></textarea>

                        <!-- Pass existing data to JavaScript -->
                        <script type="application/json" id="existing-objectives">
                            @json($sessionDetails ?? $course->outcomes)
                        </script>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-4">
                    <div class="text-sm text-gray-500">
                        <span id="tag-count">0</span> tags added
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-8 w-full">
                    <a href="{{ route('admin.courses.edit.details', $course->id) }}" class="bg-[#EDEDED] w-full text-gray-800 text-sm font-medium px-6 py-3 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Prev
                    </a>

                    <button type="submit" id="next-button" class="bg-[#E68815] w-full text-white text-sm px-6 py-3 rounded-full hover:bg-[#cc6f0f] focus:outline-none focus:ring-2 focus:ring-[#E68815] flex items-center justify-center transition duration-200">
                        <span class="submit-text">Update & Next</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .tag-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
            min-height: 42px;
            padding: 6px 10px;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            background: white;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .tag {
            display: inline-flex;
            align-items: center;
            background-color: #E1E1E1;
            color: #1B1B1B;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 500;
        }

        .tag-remove {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            margin-left: 6px;
            background-color: #929292;
            color: white;
            border-radius: 50%;
            cursor: pointer;
            font-size: 12px;
            line-height: 1;
            transition: background-color 0.15s ease-in-out;
        }

        .tag-remove:hover {
            background-color: #ef4444;
        }

        .tag-input {
            flex: 1;
            border: none;
            outline: none;
            min-width: 100px;
            font-size: 14px;
            color: #1B1B1B;
        }

        .tag-input:focus {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
        }

        .tag-input::placeholder {
            color: #9CA3AF;
        }

        .error-message {
            display: none;
            color: #EF4444;
            font-size: 12px;
            margin-top: 4px;
        }

        .focused {
            border-color: #E68815 !important;
            box-shadow: 0 0 0 1px #E68815;
        }

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
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tagInputContainer = document.getElementById('tag-input-container');
            const tagInput = document.getElementById('tag-input');
            const errorMessage = document.getElementById('error-message');
            const tagCount = document.getElementById('tag-count');
            const nextButton = document.getElementById('next-button');
            const hiddenTextarea = document.getElementById('hidden-textarea');
            const form = document.getElementById('course-outcomes-form');

            let tags = [];
            let isSubmitting = false;

            // Load existing objectives from session data or course outcomes
            function loadExistingObjectives() {
                const existingObjectivesScript = document.getElementById('existing-objectives');
                if (existingObjectivesScript) {
                    try {
                        const existingData = JSON.parse(existingObjectivesScript.textContent);

                        // Check if it's session data with learning_objectives property
                        if (existingData && existingData.learning_objectives && Array.isArray(existingData.learning_objectives)) {
                            tags = [...existingData.learning_objectives];
                        }
                        // Check if it's a direct array from course outcomes
                        else if (Array.isArray(existingData)) {
                            tags = [...existingData];
                        }

                        updateTagDisplay();
                        updateHiddenTextarea();
                    } catch (error) {
                        console.error('Error loading existing objectives:', error);
                    }
                }
            }

            // Focus styling
            tagInput.addEventListener('focus', () => {
                tagInputContainer.classList.add('focused');
            });

            tagInput.addEventListener('blur', () => {
                tagInputContainer.classList.remove('focused');
                // Small delay to allow for blur when clicking remove buttons
                setTimeout(() => {
                    if (tagInput.value.trim() !== '') {
                        createTag(tagInput.value.trim());
                    }
                }, 100);
            });

            // Handle Enter & Comma
            tagInput.addEventListener('keydown', function(e) {
                if (e.key === ',' || e.key === 'Enter') {
                    e.preventDefault();
                    if (tagInput.value.trim() !== '') {
                        createTag(tagInput.value.trim());
                    }
                }
                // Backspace deletes last tag when input is empty
                if (e.key === 'Backspace' && tagInput.value === '' && tags.length > 0) {
                    removeTag(tags.length - 1);
                }
            });

            // Handle clicking on the container to focus input
            tagInputContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('tag-remove')) {
                    e.preventDefault();
                    const index = parseInt(e.target.getAttribute('data-index'));
                    removeTag(index);
                } else if (!e.target.classList.contains('tag')) {
                    tagInput.focus();
                }
            });

            function createTag(text) {
                text = text.replace(/,/g, '').trim();

                if (text === '') {
                    showError('Please enter a valid learning objective');
                    return;
                }

                if (tags.includes(text)) {
                    showError('This objective has already been added');
                    return;
                }

                if (tags.length >= 10) { // Optional limit
                    showError('Maximum 10 learning objectives allowed');
                    return;
                }

                tags.push(text);
                updateTagDisplay();
                tagInput.value = '';
                hideError();
                updateHiddenTextarea();
            }

            function removeTag(index) {
                if (index >= 0 && index < tags.length) {
                    tags.splice(index, 1);
                    updateTagDisplay();
                    updateHiddenTextarea();
                    validateTags();
                }
            }

            function updateTagDisplay() {
                // Remove existing tags
                const existingTags = tagInputContainer.querySelectorAll('.tag');
                existingTags.forEach(tag => tag.remove());

                // Add current tags
                tags.forEach((tag, index) => {
                    const tagElement = document.createElement('div');
                    tagElement.className = 'tag';
                    tagElement.innerHTML = `
                <span>${escapeHtml(tag)}</span>
                <span class="tag-remove" data-index="${index}" title="Remove tag">×</span>
            `;
                    tagInputContainer.insertBefore(tagElement, tagInput);
                });

                tagCount.textContent = tags.length;
                validateTags();
            }

            function updateHiddenTextarea() {
                hiddenTextarea.value = tags.join(',');
            }

            function showError(message) {
                errorMessage.textContent = message;
                errorMessage.style.display = 'block';
                tagInputContainer.classList.add('border-red-500');
            }

            function hideError() {
                errorMessage.style.display = 'none';
                tagInputContainer.classList.remove('border-red-500');
            }

            function validateTags() {
                if (tags.length < 1) {
                    nextButton.disabled = true;
                    nextButton.classList.add('opacity-50', 'cursor-not-allowed');
                    if (tags.length === 0 && tagInput.value.trim() === '') {
                        showError('Please add at least one learning objective');
                    }
                } else {
                    nextButton.disabled = false;
                    nextButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    hideError();
                }
            }

            // Form submission handler
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                if (isSubmitting) {
                    return; // Prevent double submission
                }

                // Final validation
                if (tags.length < 1) {
                    showError('Please add at least one learning objective');
                    return;
                }

                // Add any remaining text in input as tag
                if (tagInput.value.trim() !== '') {
                    createTag(tagInput.value.trim());
                    if (tags.length < 1) {
                        return; // If tag creation failed
                    }
                }

                isSubmitting = true;

                // Show loading state
                nextButton.innerHTML = `
            <span class="flex items-center justify-center gap-2">
                <svg class="loading-spinner h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span>Updating...</span>
            </span>
        `;
                nextButton.disabled = true;

                // Update hidden textarea one final time
                updateHiddenTextarea();

                // Submit the form after a short delay for visual feedback
                setTimeout(() => {
                    form.submit();
                }, 500);
            });

            // Utility function to escape HTML
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            // Initialize with existing objectives and validate
            loadExistingObjectives();
            validateTags();
        });
    </script>
@endpush
