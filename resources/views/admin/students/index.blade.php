@extends('layouts.admin')
@section('content')
    <div id="studentManagement">
        <!-- Page Header -->
        <p class="text-base md:text-lg font-medium text-[#5D5D5D] mb-8 md:mb-16">
            User Management > <span class="text-[#848484]">Students</span>
        </p>

        <!-- Action Bar -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full">
                <!-- Add Student Button -->
                <div class="flex-shrink-0 w-full sm:w-auto">
                    <button id="addStudentBtn" class="bg-[#E68815] px-4 md:px-6 py-3 rounded-full text-sm md:text-base font-medium text-white hover:bg-[#cc6f0f] transition-colors w-full sm:w-auto">
                        + Add Student
                    </button>
                </div>

                <!-- Search Input -->
                <div class="flex-grow w-full min-w-0">
                    <span class="flex items-center bg-[#EDEDED] rounded-full px-4 w-full">
                        <i class="uil uil-search text-[#141B34] text-lg mr-2"></i>
                        <input type="search" id="searchInput" placeholder="Search by name or email" value="{{ $searchQuery ?? '' }}" class="bg-transparent outline-none border-0 w-full py-3 text-[#141B34] font-medium text-sm md:text-base focus:ring-0 focus:border-transparent focus:outline-none">
                    </span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                <button id="allButton" class="{{ !request('status') ? 'bg-[#F5CE9F] text-[#8C530D]' : 'bg-[#EDEDED] text-[#141B34]' }} text-sm md:text-base px-6 md:px-10 py-3 rounded-full font-medium hover:bg-[#e6bb85] transition-colors">
                    All
                </button>

                <div class="relative w-full sm:w-64">
                    <button id="courseDropdown" class="w-full bg-[#EDEDED] rounded-full px-4 md:px-7 py-3 text-[#141B34] font-medium hover:bg-gray-300 transition-all flex justify-between items-center text-sm md:text-base">
                        <span id="selectedCourse">Status</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" id="dropdownIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="dropdownMenu" class="absolute mt-2 w-full bg-white text-black text-sm rounded-2xl shadow-lg overflow-hidden z-50 hidden">
                        <ul>
                            <li class="dropdown-option px-4 md:px-7 py-3 hover:bg-[#E68815] hover:text-white font-medium cursor-pointer transition-colors" data-value="Active Users">
                                Active Users
                            </li>
                            <li class="dropdown-option px-4 md:px-7 py-3 hover:bg-[#E68815] hover:text-white font-medium cursor-pointer transition-colors" data-value="Blocked Users">
                                Blocked Users
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="w-auto bg-white rounded-[20px] md:rounded-[30px] px-2 md:px-3 py-3 shadow-sm overflow-hidden">
            <div class="overflow-x-auto bg-white mb-10 md:mb-20 rounded-[20px] md:rounded-[30px]">
                <table class="min-w-full divide-y divide-gray-200 border-collapse">
                    <thead class="bg-[#EDEDED]">
                        <tr>
                            <th class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center">#</th>
                            <th class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-left">Student Name</th>
                            <th class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center hidden sm:table-cell">Email</th>
                            <th class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center hidden md:table-cell">Phone</th>
                            <th class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center hidden md:table-cell">Registered</th>
                            <th class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center hidden md:table-cell">Status</th>
                            <th class="px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-[#fcfafa] divide-y divide-gray-200" id="users-container">
                        @include('admin.students.student-items', ['users' => $users])
                    </tbody>
                </table>
            </div>

            {{ $users->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-[9999] hidden p-4">
        <div class="modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-full max-w-sm md:max-w-md h-auto p-4 md:p-6 flex flex-col items-center justify-center z-[10000]">
            <img src="{{ asset('dashboard_assets/images/img/gradient.png') }}" alt="delete" class="w-12 h-12 md:w-16 md:h-16 mb-4">
            <h2 class="text-base md:text-lg font-semibold text-gray-800 mb-4 text-center">Delete Student?</h2>
            <p class="text-gray-600 mb-6 text-center text-xs md:text-sm">
                Are you sure you want to remove this student from the system? This action cannot be undone.
            </p>

            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-center gap-3 w-full">
                    <button type="button" id="cancelDelete" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#EDEDED] text-gray-700 hover:bg-gray-300 transition-colors text-xs md:text-sm">
                        Cancel
                    </button>

                    <button type="submit" id="confirmDelete" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#E30800] text-white hover:bg-red-600 transition-colors text-xs md:text-sm">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .modal-content {
            transform: scale(0.95) translateY(-20px);
            opacity: 0;
            transition: all 0.3s ease-in-out;
        }
        .modal-content.show {
            transform: scale(1) translateY(0);
            opacity: 1;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            const usersContainer = document.getElementById('users-container');
            let searchTimeout = null;

            // Initialize action cards for existing rows
            initializeActionCards();

            // Delete modal functionality
            setupDeleteModal();

            // Debounced Search
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    const query = searchInput.value.trim();
                    if (query.length >= 2 || query.length === 0) {
                        performSearch(query);
                    }
                }, 500);
            });

            // Perform search via AJAX
            function performSearch(query) {
                const url = new URL(window.location.href);
                url.searchParams.set('search', query);
                url.searchParams.delete('page');

                fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newTableBody = doc.getElementById('users-container');

                        if (newTableBody) {
                            usersContainer.innerHTML = newTableBody.innerHTML;
                            window.history.pushState({}, '', url.toString());
                            initializeActionCards(); // Reinitialize for new content
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            // Action card functionality
            function initializeActionCards() {
                // Close any open action cards when clicking anywhere
                document.addEventListener('click', function() {
                    document.querySelectorAll('.action-card').forEach(card => {
                        card.classList.add('hidden');
                    });
                });

                // Initialize action cards for each row
                document.querySelectorAll('.toggle-action-card').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.stopPropagation();

                        // Get the user ID from the data attribute
                        const userId = this.closest('tr').dataset.userId;
                        const actionCard = document.getElementById(`action-card-${userId}`);

                        // Hide all other action cards
                        document.querySelectorAll('.action-card').forEach(card => {
                            if (card !== actionCard) {
                                card.classList.add('hidden');
                            }
                        });

                        // Position and show this action card
                        if (actionCard) {
                            const rect = this.getBoundingClientRect();
                            actionCard.style.top = `${rect.bottom + window.scrollY}px`;
                            actionCard.style.left = `${rect.left + window.scrollX - 100}px`;
                            actionCard.classList.toggle('hidden');
                        }
                    });
                });

                // Prevent action card from closing when clicking inside it
                document.querySelectorAll('.action-card').forEach(card => {
                    card.addEventListener('click', function(e) {
                        e.stopPropagation();
                    });
                });
            }

            // Setup delete modal functionality
            function setupDeleteModal() {
                const deleteModal = document.getElementById('deleteModal');
                const deleteForm = document.getElementById('delete-form');
                const cancelDelete = document.getElementById('cancelDelete');

                // Open modal when the delete button is clicked
                document.querySelectorAll('.delete-user').forEach(button => {
                    button.addEventListener('click', function() {
                        const userId = this.getAttribute('data-user-id');
                        const deleteUrl = `{{ route('admin.students.destroy', ':id') }}`.replace(':id', userId);

                        // Update form action
                        deleteForm.setAttribute('action', deleteUrl);

                        // Show modal
                        deleteModal.classList.remove('hidden');
                        setTimeout(() => {
                            document.querySelector('.modal-content').classList.add('show');
                        }, 10);
                    });
                });

                // Close modal when cancel is clicked
                cancelDelete.addEventListener('click', function() {
                    deleteModal.classList.add('hidden');
                    document.querySelector('.modal-content').classList.remove('show');
                });

                // Handle form submission
                deleteForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const submitBtn = document.getElementById('confirmDelete');
                    const originalBtnText = submitBtn.innerHTML;

                    // Show loading state
                    submitBtn.innerHTML = `
                        <span class="flex items-center justify-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Deleting...
                        </span>
                    `;
                    submitBtn.disabled = true;

                    fetch(this.action, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            user_id: this.getAttribute('data-user-id')
                        })
                    })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => Promise.reject(err));
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                iziToast.success({ ...iziToastSettings, message: data.message });
                                setTimeout(() => window.location.href = data.redirect, 3000);
                            }
                        })
                        .catch(error => {
                            iziToast.error({
                                ...iziToastSettings,
                                message: error.message || 'An error occurred while deleting the student'
                            });
                        })
                        .finally(() => {
                            submitBtn.innerHTML = originalBtnText;
                            submitBtn.disabled = false;
                        });
                });
            }

            // Preserve search query on page load
            @if(request('search'))
                searchInput.value = "{{ request('search') }}";
            @endif
        });
    </script>
@endpush
