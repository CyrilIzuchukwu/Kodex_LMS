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
                    <!-- Step Label -->
                    <div
                        class="px-4 py-2 inline-block rounded-[10px] shadow-sm border border-[#929292] absolute -top-14 left-1/2 -translate-x-1/2 whitespace-nowrap">
                        <span class="text-[#444444] text-sm font-medium">
                            Course Outcomes
                        </span>
                    </div>
                </div>
                <!-- Line to Next -->
                <div class="w-28 h-[8px] line-gradient"></div>
            </div>

            <!-- Step 3 -->
            <div class="relative flex items-center">
                <div
                    class="w-12 h-12 flex items-center justify-center rounded-full bg-white border round-gradient text-gray-600 font-bold">
                    3
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
                    <i class="uil uil-tag text-white"></i>
                </div>
                <h3 class="text-base font-medium text-[#1B1B1B]">Course Outcomes</h3>
            </div>
        </div>


        <p class="text-gray-600 text-sm mb-6">Enter what students will learn in your course. Press comma or enter to add
            tags.</p>


        <form action="" method="" enctype="multipart/form-data">
            @csrf

            {{-- tag input --}}
            <div class="grid grid-cols-1 mb-6">
                <div>
                    <label class="block text-sm font-medium text-[#1B1B1B] mb-2">What students will learn?</label>

                    <div id="tag-input-container" class="tag-container">
                        <!-- Tags will be inserted here -->
                        <input type="text" id="tag-input" class="tag-input" placeholder="Javascript">
                    </div>

                    <span id="error-message" class="error-message">Please enter at least one learning objective</span>

                    <!-- Hidden textarea to store the actual values for form submission -->
                    <textarea id="hidden-textarea" name="" class="hidden"></textarea>
                </div>
            </div>

            <div class="flex justify-between items-center mb-4">
                <div class="text-sm text-gray-500">
                    <span id="tag-count">0</span> tags added
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
            }

            .tag-input {
                flex: 1;
                border: none;
                outline: none;
                min-width: 100%;
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
                const tagInputContainer = document.getElementById('tag-input-container');
                const tagInput = document.getElementById('tag-input');
                const errorMessage = document.getElementById('error-message');
                const tagCount = document.getElementById('tag-count');
                const nextButton = document.getElementById('next-button');
                const hiddenTextarea = document.getElementById('hidden-textarea');

                let tags = [];

                // Focus styling
                tagInput.addEventListener('focus', () => {
                    tagInputContainer.classList.add('focused');
                });
                tagInput.addEventListener('blur', () => {
                    tagInputContainer.classList.remove('focused');
                    if (tagInput.value.trim() !== '') {
                        createTag(tagInput.value.trim());
                    }
                });

                // Handle Enter & Comma
                tagInput.addEventListener('keydown', function(e) {
                    if (e.key === ',' || e.key === 'Enter') {
                        e.preventDefault();
                        if (tagInput.value.trim() !== '') {
                            createTag(tagInput.value.trim());
                        }
                    }
                    // Backspace deletes last tag
                    if (e.key === 'Backspace' && tagInput.value === '' && tags.length > 0) {
                        removeTag(tags.length - 1);
                    }
                });

                function createTag(text) {
                    text = text.replace(/,/g, '').trim();
                    if (text === '' || tags.includes(text)) {
                        showError('This objective has already been added or is empty');
                        return;
                    }
                    tags.push(text);
                    updateTagDisplay();
                    tagInput.value = '';
                    hideError();
                    updateHiddenTextarea();
                }

                function removeTag(index) {
                    tags.splice(index, 1);
                    updateTagDisplay();
                    updateHiddenTextarea();
                }

                function updateTagDisplay() {
                    const existingTags = tagInputContainer.querySelectorAll('.tag');
                    existingTags.forEach(tag => tag.remove());

                    tags.forEach((tag, index) => {
                        const tagElement = document.createElement('div');
                        tagElement.className = 'tag';
                        tagElement.innerHTML = `
                        <span>${tag}</span>
                        <span class="tag-remove" data-index="${index}">×</span>
                    `;
                        tagInputContainer.insertBefore(tagElement, tagInput);
                    });

                    tagCount.textContent = tags.length;
                    validateTags();
                }

                // for database
                function updateHiddenTextarea() {
                    hiddenTextarea.value = tags.join(',');
                }

                tagInputContainer.addEventListener('click', function(e) {
                    if (e.target.classList.contains('tag-remove')) {
                        const index = parseInt(e.target.getAttribute('data-index'));
                        removeTag(index);
                    }
                });

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
                        showError('Please add at least one learning objective');
                    } else {
                        nextButton.disabled = false;
                        nextButton.classList.remove('opacity-50', 'cursor-not-allowed');
                        hideError();
                    }
                }

                nextButton.addEventListener('click', function() {
                    if (tags.length >= 1) {
                        alert('Learning objectives saved successfully: ' + tags.join(', '));
                        // submit form
                    }
                });

                document.getElementById('prev-button').addEventListener('click', function() {
                    alert('Going to previous step');
                });

                validateTags();
            });
        </script>
    @endpush
@endsection
