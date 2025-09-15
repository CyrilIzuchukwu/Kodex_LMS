@extends('layouts.user')

@section('content')
    <div class="bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="w-full px-3 py-8">
            <div class="mx-auto">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Learning Journey</h1>
                        <p class="text-gray-500 mt-2">Track and manage your learning progress</p>
                    </div>

                    <a href="{{ route('user.courses') }}" class="bg-[#E68815] hover:bg-[#d47a12] text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl w-full md:w-auto text-center">
                        <span class="flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Explore Courses</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center px-2 mb-6 gap-4 mt-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full">
                <!-- Search Input -->
                <div class="flex-grow w-full min-w-0">
                            <span class="flex items-center bg-[#EDEDED] rounded-full px-4 w-full">
                                <i class="uil uil-search text-[#141B34] text-lg mr-2"></i>
                                <input type="search" id="searchInput" placeholder="Search by course name or category" value="{{ request()->input('search', '') }}" class="bg-transparent outline-none border-0 w-full py-3 text-[#141B34] font-medium text-sm md:text-base focus:ring-0 focus:border-transparent focus:outline-none">
                            </span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                <button id="allButton" class="{{ (!request('category') && !request('search')) ? 'bg-[#F5CE9F] text-[#8C530D]' : 'bg-[#EDEDED] text-[#141B34]' }} text-sm md:text-base px-6 md:px-10 py-3 rounded-full font-medium hover:bg-[#e6bb85] transition-colors">
                    All
                </button>

                <!-- Category Dropdown -->
                <div class="relative w-full sm:w-64">
                    <button id="categoryDropdown" class="w-full {{ request('category') ? 'bg-[#F5CE9F] text-[#8C530D]' : 'bg-[#EDEDED] text-[#141B34]' }} rounded-full px-4 md:px-7 py-3 font-medium hover:bg-gray-300 transition-all flex justify-between items-center text-sm md:text-base">
                                <span id="selectedCategory">
                                    {{ request('category') ? ucfirst(request('category')) : 'Category' }}
                                </span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" id="categoryDropdownIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="categoryDropdownMenu" class="absolute mt-2 w-full bg-white text-black text-sm rounded-2xl shadow-lg overflow-hidden z-50 hidden">
                        <ul>
                            <li class="category-option px-4 md:px-7 py-3 hover:bg-[#E68815] hover:text-white font-medium cursor-pointer transition-colors" data-value="all">
                                All Categories
                            </li>
                            @foreach($categories as $category)
                                <li class="category-option px-4 md:px-7 py-3 hover:bg-[#E68815] hover:text-white font-medium cursor-pointer transition-colors {{ request('category') == $category->name ? 'bg-[#F5CE9F] text-[#8C530D]' : '' }}" data-value="{{ $category->name }}">
                                    {{ ucfirst($category->name) }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8" id="courses-container">
            @if($courses->count())
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl px-3 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4" id="courses-grid">
                        @include('user.courses.purchases-list', ['courses' => $courses])
                    </div>
                    <div id="pagination-container" class="mt-6">
                        {{ $courses->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            @else
                <section class="flex items-center justify-center min-h-[35vh]" id="no-courses-section">
                    <div class="p-8 max-w-md text-center">
                        <div class="w-16 h-16 rounded-full bg-[#F5CE9F] flex items-center justify-center mb-6 mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-[#8C530D]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12h.01M12 16h.01" />
                            </svg>
                        </div>
                        <h2 class="font-[400] text-[#444444] text-[20px] mb-4">No Courses Found</h2>
                        <p class="text-[14px] text-[#1B1B1B] mb-6">You haven't purchased any courses yet.</p>
                    </div>
                </section>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .pulse-animation {
            animation: pulse 1.5s infinite ease-in-out;
        }
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.2);
                opacity: 0.7;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const coursesContainer = document.getElementById('courses-container');
            const allButton = document.getElementById('allButton');
            const categoryDropdown = document.getElementById('categoryDropdown');
            const categoryDropdownMenu = document.getElementById('categoryDropdownMenu');
            const categoryDropdownIcon = document.getElementById('categoryDropdownIcon');
            const selectedCategorySpan = document.getElementById('selectedCategory');

            let searchTimeout = null;
            let currentFilters = {
                search: '{{ request()->input('search', '') }}',
                category: '{{ request()->input('category', '') }}'
            };

            if (!coursesContainer) return;

            // Search functionality with debouncing
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        currentFilters.search = searchInput.value.trim();
                        performFilter();
                    }, 500);
                });
            }

            // Category dropdown functionality
            if (categoryDropdown) {
                categoryDropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleDropdown(categoryDropdownMenu, categoryDropdownIcon);
                });
            }

            // Category option selection
            document.querySelectorAll('.category-option').forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    const value = this.dataset.value;
                    currentFilters.category = value === 'all' ? '' : value;
                    selectedCategorySpan.textContent = value === 'all' ? 'Category' : value.charAt(0).toUpperCase() + value.slice(1);
                    closeDropdown(categoryDropdownMenu, categoryDropdownIcon);
                    updateButtonStates();
                    performFilter();
                });
            });

            // All button functionality
            if (allButton) {
                allButton.addEventListener('click', function() {
                    currentFilters = { search: '', category: '' };
                    if (searchInput) searchInput.value = '';
                    if (selectedCategorySpan) selectedCategorySpan.textContent = 'Category';
                    updateButtonStates();
                    performFilter();
                });
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                if (categoryDropdownMenu && categoryDropdownIcon) {
                    closeDropdown(categoryDropdownMenu, categoryDropdownIcon);
                }
            });

            // Handle pagination clicks
            document.addEventListener('click', function(e) {
                const paginationLink = e.target.closest('#pagination-container a');
                if (paginationLink) {
                    e.preventDefault();
                    performFilter(paginationLink.href);
                }
            });

            // Utility functions
            function toggleDropdown(menu, icon) {
                if (menu && icon) {
                    const isHidden = menu.classList.contains('hidden');
                    menu.classList.toggle('hidden', !isHidden);
                    icon.classList.toggle('rotate-180', isHidden);
                }
            }

            function closeDropdown(menu, icon) {
                if (menu && icon) {
                    menu.classList.add('hidden');
                    icon.classList.remove('rotate-180');
                }
            }

            function updateButtonStates() {
                if (!allButton || !categoryDropdown || !selectedCategorySpan) return;

                const hasFilters = currentFilters.search || currentFilters.category;

                // Update All button
                allButton.classList.toggle('bg-[#F5CE9F]', !hasFilters);
                allButton.classList.toggle('text-[#8C530D]', !hasFilters);
                allButton.classList.toggle('bg-[#EDEDED]', hasFilters);
                allButton.classList.toggle('text-[#141B34]', hasFilters);

                // Update Category button
                categoryDropdown.classList.toggle('bg-[#F5CE9F]', currentFilters.category);
                categoryDropdown.classList.toggle('text-[#8C530D]', currentFilters.category);
                categoryDropdown.classList.toggle('bg-[#EDEDED]', !currentFilters.category);
                categoryDropdown.classList.toggle('text-[#141B34]', !currentFilters.category);
            }

            // Perform filtering via AJAX
            function performFilter(url = null) {
                const fetchUrl = url ? new URL(url) : new URL(window.location.href);
                if (!url) {
                    fetchUrl.searchParams.delete('page');
                    Object.entries(currentFilters).forEach(([key, value]) => {
                        if (value) {
                            fetchUrl.searchParams.set(key, value);
                        } else {
                            fetchUrl.searchParams.delete(key);
                        }
                    });
                }

                fetch(fetchUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        coursesContainer.innerHTML = data.html && data.html.trim() ? `
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl px-3 mb-6">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6">
                                    <div class="mb-4 sm:mb-0">
                                        <h3 class="text-xl font-bold text-gray-800">Continue Your Learning Journey</h3>
                                        <p class="text-sm text-gray-600 mt-1">Recommended courses based on your purchase</p>
                                    </div>
                                    <a href="{{ route('user.course.my.learning') }}" class="text-[#E68815] hover:text-[#d47a12] font-medium text-sm flex items-center space-x-1 transition-colors">
                                        <span>View All Courses</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="courses-grid">
                                    ${data.html}
                                </div>
                                <div id="pagination-container" class="mt-6">
                                    ${data.pagination || ''}
                                </div>
                            </div>
                        ` : `
                            <section class="flex items-center justify-center min-h-[35vh]" id="no-courses-section">
                                <div class="p-8 max-w-md text-center">
                                    <div class="w-16 h-16 rounded-full bg-[#F5CE9F] flex items-center justify-center mb-6 mx-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-[#8C530D]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12h.01M12 16h.01" />
                                        </svg>
                                    </div>
                                    <h2 class="font-[400] text-[#444444] text-[20px] mb-4">No Courses Found</h2>
                                    <p class="text-[14px] text-[#1B1B1B] mb-6">No courses match your current search or filter criteria. Try adjusting your filters or search terms.</p>
                                </div>
                            </section>
                        `;

                        window.history.pushState({}, '', fetchUrl);
                        if (window.GLightbox) {
                            GLightbox({ selector: '.glightbox' });
                        }
                    })
                    .catch(error => {
                        coursesContainer.innerHTML = `
                            <section class="flex items-center justify-center min-h-[35vh]" id="no-courses-section">
                                <div class="p-8 max-w-md text-center">
                                    <h2 class="font-[400] text-[#444444] text-[20px] mb-4">Error Loading Courses</h2>
                                    <p class="text-[14px] text-[#1B1B1B] mb-6">An error occurred while fetching courses. Please try again.</p>
                                </div>
                            </section>
                        `;
                    });
            }

            updateButtonStates();
            if (window.GLightbox) {
                GLightbox({ selector: '.glightbox' });
            }
        });
    </script>
@endpush
