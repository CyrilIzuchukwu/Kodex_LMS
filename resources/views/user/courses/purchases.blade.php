@extends('layouts.user')
@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="w-full px-3 py-8">
            <div class="mx-auto">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">My Purchases</h1>
                        <p class="text-gray-500 mt-2">Track and manage your purchased courses</p>
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

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6 px-3 mx-auto">
            <!-- Total Courses Card -->
            <div class="bg-[#1B1B1B] rounded-2xl flex items-center py-12 px-4 gap-4 sm:gap-6 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-center rounded-full w-14 h-14 bg-[#ffffff]">
                    <svg class="w-8 h-8 text-[#8C530D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-[#ffffff] text-sm sm:text-base">Total Courses</p>
                    <h1 class="text-[#ffffff] text-xl sm:text-2xl font-bold">{{ $metrics['total_course_count'] }}</h1>
                </div>
            </div>

            <!-- Active Courses Card -->
            <div class="relative flex items-center py-12 px-4 rounded-2xl bg-white shadow-md hover:shadow-lg transition-all duration-300">
                <div class="flex items-center gap-4 sm:gap-6">
                    <div class="flex items-center justify-center rounded-full w-14 h-14 bg-[#F5CE9F]">
                        <svg class="w-8 h-8 text-[#8C530D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[#1B1B1B] text-sm sm:text-base">Active Courses</p>
                        <h1 class="text-[#1B1B1B] text-xl sm:text-2xl font-bold">{{ $metrics['active_course_count'] }}</h1>
                    </div>
                </div>
                <div class="absolute bottom-0 right-0">
                    <img src="{{ asset('dashboard_assets/images/img/book2.png') }}" alt="book2" class="w-16 h-16 sm:w-20 sm:h-20">
                </div>
            </div>

            <!-- Completed Courses Card -->
            <div class="relative flex items-center py-12 px-4 rounded-2xl bg-white shadow-md hover:shadow-lg transition-all duration-300">
                <div class="flex items-center gap-4 sm:gap-6">
                    <div class="flex items-center justify-center rounded-full w-14 h-14 bg-[#F5CE9F]">
                        <svg class="w-8 h-8 text-[#8C530D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[#1B1B1B] text-sm sm:text-base">Completed Courses</p>
                        <h1 class="text-[#1B1B1B] text-xl sm:text-2xl font-bold">{{ $metrics['completed_course_count'] }}</h1>
                    </div>
                </div>
                <div class="absolute bottom-0 right-0">
                    <img src="{{ asset('dashboard_assets/images/img/file2.png') }}" alt="file2" class="w-16 h-16 sm:w-20 sm:h-20">
                </div>
            </div>
        </div>

        <div class="mt-8">
            @if($myLearning->count())
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl px-3 mb-6">
                    <!-- Continue Your Journey Section -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6">
                        <div class="mb-4 sm:mb-0">
                            <h3 class="text-xl font-bold text-gray-800">Continue Your Learning Journey</h3>
                            <p class="text-sm text-gray-600 mt-1">Track your learning progress and continue your courses</p>
                        </div>
                        <a href="{{ route('user.course.my.learning') }}" class="text-[#E68815] hover:text-[#d47a12] font-medium text-sm flex items-center space-x-1 transition-colors">
                            <span>View All Courses</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @include('user.courses.purchases-list', ['courses' => $myLearning])
                    </div>
                </div>
            @endif

            <div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-xl px-3 mb-6">
                @if($courses->count())
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Recently Purchased Courses</h3>
                            <p class="text-sm text-gray-600 mt-1">Recently purchased courses based on your purchase history</p>
                        </div>
                    </div>

                    <!-- Action Bar -->
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4 mt-4">
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

                    <!-- Courses Container -->
                    <div id="courses-container">
                        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-5" id="courses-grid">
                            @include('user.courses.purchases-list', ['courses' => $courses])
                        </section>
                        <div id="pagination-container" class="pagination">
                            {{ $courses->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                @else
                    @if(!$myLearning->count())
                        <section class="flex items-center justify-center min-h-[50vh]">
                            <div class="p-8 max-w-md text-center">
                                <div class="w-20 h-20 rounded-full bg-[#F5CE9F] flex items-center justify-center mb-6 mx-auto">
                                    <svg class="w-12 h-12 text-[#8C530D]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-semibold text-[#444444] mb-4">No Purchased Courses Found</h2>
                                <p class="text-base text-[#1B1B1B] mb-6">You haven't purchased any courses yet. Explore our catalog to find courses that interest you!</p>
                                <a href="{{ route('user.courses') }}" class="inline-block bg-[#E68815] hover:bg-[#ffad48] text-white py-3 px-8 rounded-[100px] font-semibold text-base transition-colors shadow-sm hover:shadow-md">Explore Courses</a>
                            </div>
                        </section>
                    @endif
                @endif
            </div>
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

            // Dropdown elements
            const categoryDropdown = document.getElementById('categoryDropdown');
            const categoryDropdownMenu = document.getElementById('categoryDropdownMenu');
            const categoryDropdownIcon = document.getElementById('categoryDropdownIcon');
            const selectedCategorySpan = document.getElementById('selectedCategory');

            let searchTimeout = null;
            let currentFilters = {
                search: '{{ request()->input('search', '') }}',
                category: '{{ request()->input('category', '') }}'
            };

            // Check if essential elements exist
            if (!coursesContainer) {
                return;
            }

            // Search functionality with debouncing
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    currentFilters.search = searchInput.value.trim();
                    performFilter();
                }, 500);
            });

            // Category dropdown functionality
            categoryDropdown.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleDropdown(categoryDropdownMenu, categoryDropdownIcon);
            });

            // Category option selection
            document.querySelectorAll('.category-option').forEach(option => {
                option.addEventListener('click', function() {
                    const value = this.dataset.value;
                    currentFilters.category = value === 'all' ? '' : value;
                    selectedCategorySpan.textContent = value === 'all' ? 'Category' : value.charAt(0).toUpperCase() + value.slice(1);
                    closeDropdown(categoryDropdownMenu, categoryDropdownIcon);
                    updateButtonStates();
                    performFilter();
                });
            });

            // All button functionality
            allButton.addEventListener('click', function() {
                currentFilters = { search: '', category: '' };
                searchInput.value = '';
                selectedCategorySpan.textContent = 'Category';
                updateButtonStates();
                performFilter();
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                closeDropdown(categoryDropdownMenu, categoryDropdownIcon);
            });

            // Handle pagination clicks
            document.addEventListener('click', function(e) {
                if (e.target.closest('a') && e.target.closest('#pagination-container')) {
                    e.preventDefault();
                    const url = e.target.closest('a').href;
                    performFilter(url);
                }
            });

            // Utility functions
            function toggleDropdown(menu, icon) {
                const isHidden = menu.classList.contains('hidden');
                if (isHidden) {
                    menu.classList.remove('hidden');
                    icon.classList.add('rotate-180');
                } else {
                    menu.classList.add('hidden');
                    icon.classList.remove('rotate-180');
                }
            }

            function closeDropdown(menu, icon) {
                menu.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }

            function updateButtonStates() {
                const hasFilters = currentFilters.search || currentFilters.category;

                // Update All button
                if (hasFilters) {
                    allButton.classList.remove('bg-[#F5CE9F]', 'text-[#8C530D]');
                    allButton.classList.add('bg-[#EDEDED]', 'text-[#141B34]');
                } else {
                    allButton.classList.add('bg-[#F5CE9F]', 'text-[#8C530D]');
                    allButton.classList.remove('bg-[#EDEDED]', 'text-[#141B34]');
                }

                // Update Category button
                if (currentFilters.category) {
                    categoryDropdown.classList.add('bg-[#F5CE9F]', 'text-[#8C530D]');
                    categoryDropdown.classList.remove('bg-[#EDEDED]', 'text-[#141B34]');
                } else {
                    categoryDropdown.classList.remove('bg-[#F5CE9F]', 'text-[#8C530D]');
                    categoryDropdown.classList.add('bg-[#EDEDED]', 'text-[#141B34]');
                }
            }

            // Perform filtering via AJAX
            function performFilter(url = null) {
                const fetchUrl = url || new URL(window.location.href);
                if (!url) {
                    fetchUrl.searchParams.delete('page'); // Reset pagination
                    Object.keys(currentFilters).forEach(key => {
                        if (currentFilters[key]) {
                            fetchUrl.searchParams.set(key, currentFilters[key]);
                        } else {
                            fetchUrl.searchParams.delete(key);
                        }
                    });
                }

                fetch(fetchUrl.toString(), {
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
                        // Update courses grid
                        const coursesGrid = document.getElementById('courses-grid');
                        const paginationContainer = document.getElementById('pagination-container');

                        if (data.html && data.html.trim()) {
                            if (coursesGrid) {
                                coursesGrid.innerHTML = data.html;
                                if (paginationContainer) {
                                    paginationContainer.innerHTML = data.pagination || '';
                                }
                            } else {
                                coursesContainer.innerHTML = `
                                    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-5" id="courses-grid">
                                        ${data.html}
                                    </section>
                                    <div id="pagination-container">${data.pagination || ''}</div>
                                `;
                            }
                        } else {
                            coursesContainer.innerHTML = `
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
                        }

                        // Update browser URL
                        window.history.pushState({}, '', fetchUrl.toString());

                        // Re-initialize GLightbox for video links
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

            // Initialize button states on page load
            updateButtonStates();

            // Initialize GLightbox for video links
            if (window.GLightbox) {
                GLightbox({ selector: '.glightbox' });
            }
        });
    </script>
@endpush
