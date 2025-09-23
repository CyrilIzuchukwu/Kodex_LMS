@forelse($courses as $index => $course)
    <tr class="hover:bg-gray-100 transition-colors duration-150">
        <td class="px-6 py-4 whitespace-nowrap text-center">
            <span class="text-sm font-medium text-gray-900">{{ $courses->firstItem() + $index }}</span>
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-center">
            <span class="text-sm font-medium text-gray-900">{{ $course->title }}</span>
        </td>

        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 text-center">
            <div class="flex items-center">
                <a href="{{ route('admin.instructors.show', $course->profile?->user->id ?? '#') }}" class="flex items-center">
                    <img class="w-8 h-8 md:w-10 md:h-10 rounded-full mr-3" src="{{ $course->profile && $course->profile?->profile_photo_path ? asset($course->profile?->profile_photo_path) : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($course->profile?->user->name ?? 'N', 0, 1) }}" alt="Instructor image">
                    <span class="font-medium">{{ $course->profile?->user->name ?? 'Not Assigned' }}</span>
                </a>
            </div>
        </td>

        <td class="px-6 py-4 whitespace-nowrap sm:table-cell text-center">
            <span class="text-sm text-gray-900">{{ $course->enrollments_count ?? 0 }}</span>
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-center">
            <a href="{{ route('admin.categories.show', $course->category->slug) }}" class="inline-flex items-center px-3 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full hover:bg-blue-200 transition-colors duration-150">
                {{ $course->category->name }}
            </a>
        </td>

        <td class="px-6 py-4 whitespace-nowrap sm:table-cell text-center">
            <span class="text-sm text-gray-900">{{ $course->modules_count ?? 0 }}</span>
        </td>

        <td class="px-6 py-4 whitespace-nowrap md:table-cell text-center">
            <span class="text-sm text-gray-900">₦ {{ number_format($course->price, 2) }}</span>
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <div class="flex justify-center space-x-2">
                <!-- Edit Course Button with Tooltip -->
                <a href="{{ route('admin.courses.edit.details', $course->id) }}" class="relative inline-flex items-center p-2 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-150 group" aria-label="Edit">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span class="absolute bottom-full mb-2 hidden group-hover:block px-2 py-1 text-xs text-white bg-gray-800 rounded-md">Edit</span>
                </a>

                <!-- Delete Course Button with Tooltip -->
                <a href="#" class="delete-course relative inline-flex items-center p-2 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-150 group" data-course-id="{{ $course->id }}" aria-label="Delete">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4"/>
                    </svg>
                    <span class="absolute bottom-full mb-2 hidden group-hover:block px-2 py-1 text-xs text-white bg-gray-800 rounded-md">Delete</span>
                </a>
            </div>
        </td>
    </tr>
@empty
    <tr class="hover:bg-gray-100">
        <td colspan="8" class="px-6 py-4 text-sm text-gray-500 text-center">
            No Courses Registered
        </td>
    </tr>
@endforelse

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const showError = (message) => {
                iziToast.error({ ...iziToastSettings, message });
            };

            const showSuccess = (message) => {
                iziToast.success({ ...iziToastSettings, message });
            };

            // Delete modal logic
            const deleteModal = document.getElementById('delete-modal');
            const deleteForm = document.getElementById('delete-form');
            const cancelDeleteBtn = document.getElementById('cancel-delete');
            const deleteButtons = document.querySelectorAll('.delete-course'); // Select all delete buttons
            const submitButton = deleteForm.querySelector('button[type="submit"]');
            const submitText = submitButton.querySelector('.submit-text');
            const preloader = submitButton.querySelector('.preloader');

            // Show modal when a delete button is clicked
            deleteButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const courseId = button.getAttribute('data-course-id'); // Get course ID from data attribute
                    deleteForm.action = `{{ route('admin.courses.destroy', ':id') }}`.replace(':id', courseId); // Set form action dynamically
                    deleteModal.classList.remove('hidden', 'opacity-0');
                    deleteModal.querySelector('.modal-content').classList.remove('scale-95');
                });
            });

            // Close modal on cancel
            cancelDeleteBtn.addEventListener('click', () => {
                deleteModal.classList.add('hidden', 'opacity-0');
                deleteModal.querySelector('.modal-content').classList.add('scale-95');
            });

            // Handle form submission via AJAX
            deleteForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const formData = new FormData(deleteForm);
                const csrfToken = formData.get('_token');

                submitText.classList.add('hidden');
                preloader.classList.remove('hidden');

                fetch(deleteForm.action, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => Promise.reject(err));
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            showSuccess(data.message || 'Course deleted successfully');
                            setTimeout(() => window.location.reload(), 3000); // Reload page after 3 seconds
                        }
                    })
                    .catch(error => {
                        showError(error.message || 'An error occurred while deleting the course');
                    })
                    .finally(() => {
                        submitText.classList.remove('hidden');
                        preloader.classList.add('hidden');
                    });
            });
        });
    </script>
@endpush
