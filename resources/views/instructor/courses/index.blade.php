@extends('layouts.instructor')
@section('content')
    <div class="px-1 md:px-6 lg:px-8 py-6">
        <!-- Header -->
        <div class="glass-effect header w-full bg-opacity-80 backdrop-blur-md">
            <div class="header-content flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 sm:p-6">
                <!-- Back Button -->
                <a href="{{ route('instructor.dashboard') }}" class="back-btn flex-shrink-0">
                    <i class="mdi mdi-arrow-left text-2xl"></i>
                </a>

                <!-- Course Title and Subtitle -->
                <div class="flex-1 w-full">
                    <h1 class="text-lg sm:text-2xl md:text-3xl font-bold truncate">{{ $course->title }}</h1>
                    <p class="text-sm sm:text-base text-white/80 mt-1">{{ $course->subtitle }}</p>
                </div>

                <!-- Course Stats -->
                <div class="flex flex-row items-center justify-between sm:justify-end gap-4 sm:gap-6 w-full sm:w-auto">
                    <div class="text-center">
                        <p class="text-xl sm:text-2xl md:text-3xl font-bold">{{ $course->modules_count }}</p>
                        <p class="text-white/80 text-xs sm:text-sm">Modules</p>
                    </div>
                    <div class="text-center">
                        <p class="text-xl sm:text-2xl md:text-3xl font-bold">{{ $course->students_count ?? 0 }}</p>
                        <p class="text-white/80 text-xs sm:text-sm">Students</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modules Management Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @forelse($modules as $index => $module)
                <div class="module-card bg-white rounded-2xl shadow-md border border-gray-100 hover:shadow-lg transition-all duration-300 overflow-hidden animate-slide-up">
                    <!-- Module Header -->
                    <div class="bg-gradient-to-r from-gray-50 to-accent/10 px-4 py-4 border-b border-gray-100">
                        <div class="flex flex-col gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-accent rounded-full flex items-center justify-center text-white font-bold text-base shadow-md">
                                    {{ $index + 1 }}
                                </div>
                                <h3 class="text-base font-bold text-gray-900">@truncate($module->title, 22)</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Module Content -->
                    <div class="p-4">
                        <!-- Module Stats -->
                        <div class="grid grid-cols-1 gap-3 mb-4">
                            <div class="bg-accent/10 rounded-lg p-2 text-center">
                                <p class="text-lg font-bold text-gray-900">{{ $module->resources_count }}</p>
                                <p class="text-gray-600 text-xs">Resources</p>
                            </div>
                            <div class="bg-green-50 rounded-lg p-2 text-center">
                                <p class="text-lg font-bold text-gray-900">{{ $module->students_count }}</p>
                                <p class="text-gray-600 text-xs">Students</p>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="flex flex-col gap-2">
                            @if($module->quiz_count == 0)
                                <a href="{{ route('instructor.courses.module.quiz.create', $module->id) }}" class="flex items-center gap-2 bg-purple-50 text-purple-700 px-3 py-1 rounded-lg hover:bg-purple-100 transition-colors justify-center text-sm">
                                    <i class="uil uil-plus-circle text-xs"></i>
                                    <span>Create Quiz</span>
                                </a>
                            @else
                                @foreach($module->quizzes as $quiz)
                                    <div class="flex flex-col sm:flex-row items-center justify-center gap-2 w-full max-w-md mx-auto">
                                        <!-- Edit Quiz -->
                                        <a href="{{ route('instructor.courses.module.quiz.edit', $quiz->id) }}" class="flex items-center justify-center gap-2 bg-purple-50 text-purple-700 px-4 py-2 rounded-lg hover:bg-purple-100 transition-colors w-full sm:w-auto text-sm">
                                            <i class="uil uil-edit text-xs"></i>
                                            <span>Edit Quiz</span>
                                        </a>

                                        <!-- Delete Quiz -->
                                        <button onclick="showDeleteModal('deleteModal', '{{ route('instructor.courses.module.quiz.delete', $quiz->id) }}')" class="flex items-center justify-center gap-2 bg-red-50 text-red-700 px-4 py-2 rounded-lg hover:bg-red-100 transition-colors w-full sm:w-auto text-sm">
                                            <i class="uil uil-trash text-xs"></i>
                                            <span>Delete Quiz</span>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-1 sm:col-span-2 lg:col-span-4 text-center py-12 sm:py-16">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-6 bg-accent/10 rounded-2xl flex items-center justify-center">
                        <i class="uil uil-book-open text-3xl sm:text-4xl text-accent"></i>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">No Modules Yet</h3>
                    <p class="text-gray-600 text-sm sm:text-base mb-8 max-w-md mx-auto">
                        Start building your course by creating your first module. Modules help organize your content into manageable sections.
                    </p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed hidden inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-[9999] p-4 opacity-0 transition-all duration-300 ease-in-out">
        <div class="modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-full max-w-sm md:max-w-md h-auto p-4 md:p-6 flex flex-col items-center justify-center z-[10000] transform scale-95 transition-transform duration-300 ease-in-out">
            <img src="{{ asset('dashboard_assets/images/img/gradient.png') }}" alt="delete" class="w-12 h-12 md:w-16 md:h-16 mb-4">
            <h2 class="text-base md:text-lg font-semibold text-gray-800 mb-4 text-center">Delete Quiz?</h2>
            <p class="text-gray-600 mb-6 text-center text-xs md:text-sm">
                Are you sure you want to delete this quiz? This action cannot be undone.
            </p>
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-center gap-3 w-full">
                    <button type="button" onclick="closeModal('deleteModal')" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#EDEDED] text-gray-700 hover:bg-gray-300 transition-colors text-xs md:text-sm">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#E30800] text-white hover:bg-red-600 transition-colors text-xs md:text-sm flex items-center justify-center">
                        <span class="submit-text">Delete</span>
                        <span class="preloader flex items-center justify-center gap-2 hidden">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
        }

        .header {
            padding: 2rem;
            margin-bottom: 2rem;
            animation: slideDown 0.8s ease-out;
        }

        .header-content {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .back-btn {
            padding: 0.5rem;
            color: #6b7280;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            transition: all 0.3s;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
        }

        .back-btn:hover {
            color: #E68815;
            background: white;
            transform: translateX(-3px);
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: #6b7280;
            font-size: 1.1rem;
        }

        .module-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .module-card:hover {
            transform: translateY(-4px);
        }

        /* Custom animations */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-up {
            animation: slideInUp 0.5s ease-out;
        }

        /* Accent color styles */
        .bg-accent {
            background-color: #E68815;
        }

        .text-accent {
            color: #E68815;
        }

        .bg-accent-dark {
            background-color: #D47A0F; /* Slightly darker shade for hover */
        }

        .bg-accent\/10 {
            background-color: rgba(230, 136, 21, 0.1);
        }

        .bg-accent\/20 {
            background-color: rgba(230, 136, 21, 0.2);
        }

        .shadow-accent\/25 {
            --tw-shadow-color: rgba(230, 136, 21, 0.25);
            box-shadow: 0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px var(--tw-shadow-color);
        }

        .hover\:bg-accent\/20:hover {
            background-color: rgba(230, 136, 21, 0.2);
        }

        /* Responsive Grid Styles */
        @media (min-width: 1024px) {
            .grid-cols-4 {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        @media (min-width: 640px) and (max-width: 1023px) {
            .grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 639px) {
            .grid-cols-1 {
                grid-template-columns: 1fr;
            }

            .module-card {
                margin-bottom: 1rem;
            }

            .module-card:hover {
                transform: none; /* Disable hover transform on mobile */
            }

            /* Adjust breadcrumb navigation */
            nav {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            /* Action bar buttons */
            .flex-1 {
                width: 100%; /* Full-width buttons on mobile */
                text-align: center;
            }

            /* Module description truncation */
            .truncate {
                max-width: 100%;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            /* Adjust font sizes and spacing */
            h1 {
                font-size: 1.5rem; /* Smaller title on mobile */
            }

            h2 {
                font-size: 1.25rem; /* Smaller section title */
            }

            h3 {
                font-size: 1.125rem; /* Smaller module title */
            }

            p.text-sm {
                font-size: 0.875rem; /* Smaller text for descriptions */
            }

            /* Quick actions */
            .flex-col {
                flex-direction: column; /* Stack quick actions vertically */
            }

            .flex-col > * {
                width: 100%; /* Full-width buttons */
                justify-content: center;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Modal functionality
        function showDeleteModal(modalId, actionUrl) {
            const modal = document.getElementById(modalId);
            const form = document.getElementById('delete-form');
            form.action = actionUrl; // Dynamically set the form action
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modal.classList.remove('opacity-0');
            modal.querySelector('.modal-content').classList.remove('scale-95');
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('opacity-0');
            modal.querySelector('.modal-content').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        // Form handling for delete
        const deleteForm = document.getElementById('delete-form');
        if (deleteForm) {
            const submitBtn = deleteForm.querySelector('[type="submit"]');
            const submitText = submitBtn.querySelector('.submit-text');
            const preloader = submitBtn.querySelector('.preloader');

            deleteForm.addEventListener('submit', async (e) => {
                e.preventDefault();

                // Show spinner
                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                preloader.classList.remove('hidden');

                try {
                    const response = await fetch(deleteForm.action, {
                        method: 'POST',
                        body: new FormData(deleteForm),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const contentType = response.headers.get('content-type');
                    let data;

                    if (contentType && contentType.includes('application/json')) {
                        data = await response.json();
                    } else {
                        // Handle non-JSON response (e.g., redirect)
                        data = { success: response.ok };
                    }

                    submitBtn.disabled = false;
                    submitText.classList.remove('hidden');
                    preloader.classList.add('hidden');

                    if (data.success) {
                        showSuccess(data.message || 'Quiz deleted successfully!');
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        showError(data.message || 'Failed to delete quiz. Please try again.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    submitBtn.disabled = false;
                    submitText.classList.remove('hidden');
                    preloader.classList.add('hidden');
                    showError('An error occurred. Please try again.');
                }
            });
        }

        const showError = (message) => {
            iziToast.error({ ...iziToastSettings, message });
        };

        const showSuccess = (message) => {
            iziToast.success({ ...iziToastSettings, message });
        };
    </script>
@endpush
