@extends('layouts.user')
@section('content')
    <div class="mb-6 p-3 md:p-0">
        <nav
            class="bg-white rounded-[20px] md:rounded-[30px] shadow-sm px-4 md:px-6 py-3 flex items-center justify-start w-full">
            <ol class="flex items-center space-x-2 md:space-x-3 text-sm md:text-base font-medium text-[#141B34]">
                <li>
                    <a href="{{ route('user.dashboard') }}"
                        class="hover:text-[#E68815] transition-colors duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7m-7 7v-10"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </li>
                <li>
                    <span class="text-[#E68815] font-semibold">Courses List</span>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Action Bar -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4 mt-4">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full">
            <!-- Search Input -->
            <div class="flex-grow w-full min-w-0">
                <span class="flex items-center bg-[#EDEDED] rounded-full px-4 w-full">
                    <i class="uil uil-search text-[#141B34] text-lg mr-2"></i>
                    <input type="search" id="searchInput" placeholder="Search by course name or category"
                        value="{{ request()->input('search', '') }}"
                        class="bg-transparent outline-none border-0 w-full py-3 text-[#141B34] font-medium text-sm md:text-base focus:ring-0 focus:border-transparent focus:outline-none">
                </span>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
            <button id="allButton"
                class="{{ !request('category') && !request('price') && !request('search') ? 'bg-[#F5CE9F] text-[#8C530D]' : 'bg-[#EDEDED] text-[#141B34]' }} text-sm md:text-base px-6 md:px-10 py-3 rounded-full font-medium hover:bg-[#e6bb85] transition-colors">
                All
            </button>

            <!-- Category Dropdown -->
            <div class="relative w-full sm:w-64">
                <button id="categoryDropdown"
                    class="w-full {{ request('category') ? 'bg-[#F5CE9F] text-[#8C530D]' : 'bg-[#EDEDED] text-[#141B34]' }} rounded-full px-4 md:px-7 py-3 font-medium hover:bg-gray-300 transition-all flex justify-between items-center text-sm md:text-base">
                    <span id="selectedCategory">
                        {{ request('category') ? ucfirst(request('category')) : 'Category' }}
                    </span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" id="categoryDropdownIcon"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div id="categoryDropdownMenu"
                    class="absolute mt-2 w-full bg-white text-black text-sm rounded-2xl shadow-lg overflow-hidden z-50 hidden">
                    <ul>
                        <li class="category-option px-4 md:px-7 py-3 hover:bg-[#E68815] hover:text-white font-medium cursor-pointer transition-colors"
                            data-value="all">
                            All Categories
                        </li>
                        @foreach ($categories as $category)
                            <li class="category-option px-4 md:px-7 py-3 hover:bg-[#E68815] hover:text-white font-medium cursor-pointer transition-colors {{ request('category') == $category->name ? 'bg-[#F5CE9F] text-[#8C530D]' : '' }}"
                                data-value="{{ $category->name }}">
                                {{ ucfirst($category->name) }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Price Dropdown -->
            <div class="relative w-full sm:w-64">
                <button id="priceDropdown"
                    class="w-full {{ request('price') ? 'bg-[#F5CE9F] text-[#8C530D]' : 'bg-[#EDEDED] text-[#141B34]' }} rounded-full px-4 md:px-7 py-3 font-medium hover:bg-gray-300 transition-all flex justify-between items-center text-sm md:text-base">
                    <span id="selectedPrice">
                        @if (request('price'))
                            @switch(request('price'))
                                @case('low_to_high')
                                    Price: Low to High
                                @break

                                @case('high_to_low')
                                    Price: High to Low
                                @break

                                @default
                                    Price
                            @endswitch
                        @else
                            Price
                        @endif
                    </span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" id="priceDropdownIcon" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div id="priceDropdownMenu"
                    class="absolute mt-2 w-full bg-white text-black text-sm rounded-2xl shadow-lg overflow-hidden z-50 hidden">
                    <ul>
                        <li class="price-option px-4 md:px-7 py-3 hover:bg-[#E68815] hover:text-white font-medium cursor-pointer transition-colors"
                            data-value="all">
                            All Prices
                        </li>
                        <li class="price-option px-4 md:px-7 py-3 hover:bg-[#E68815] hover:text-white font-medium cursor-pointer transition-colors {{ request('price') == 'low_to_high' ? 'bg-[#F5CE9F] text-[#8C530D]' : '' }}"
                            data-value="low_to_high">
                            Price: Low to High
                        </li>
                        <li class="price-option px-4 md:px-7 py-3 hover:bg-[#E68815] hover:text-white font-medium cursor-pointer transition-colors {{ request('price') == 'high_to_low' ? 'bg-[#F5CE9F] text-[#8C530D]' : '' }}"
                            data-value="high_to_low">
                            Price: High to Low
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-7" id="courses-container">
        @if ($courses->count())
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-5" id="courses-grid">
                @include('user.courses.course-items', ['courses' => $courses])
            </section>

            <div id="pagination-container">
                {{ $courses->links('vendor.pagination.tailwind') }}
            </div>
        @else
            <!-- Empty State -->
            <div id="no-courses-section"
                class="flex flex-col items-center justify-center py-12 sm:py-20 bg-white rounded-[20px] md:rounded-[30px] shadow-sm">
                <div class="relative mb-6 sm:mb-8">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl bg-[#E68815] flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 sm:w-12 sm:h-12 text-gray-900"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 12h.01M12 16h.01" />
                        </svg>
                    </div>
                    <div
                        class="absolute -top-2 -right-2 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-yellow-400 to-orange-400 flex items-center justify-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-700 mb-4 text-center">No Courses Found</h2>
                <p class="text-gray-500 text-base sm:text-lg text-center max-w-xs sm:max-w-md mb-6 sm:mb-8 px-4">
                    No courses match your current search or filter criteria. Try adjusting your filters or search terms.
                </p>
            </div>
        @endif
    </div>
@endsection

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

            const priceDropdown = document.getElementById('priceDropdown');
            const priceDropdownMenu = document.getElementById('priceDropdownMenu');
            const priceDropdownIcon = document.getElementById('priceDropdownIcon');
            const selectedPriceSpan = document.getElementById('selectedPrice');

            let searchTimeout = null;
            let currentFilters = {
                search: '{{ request()->input('search', '') }}',
                category: '{{ request()->input('category', '') }}',
                price: '{{ request()->input('price', '') }}'
            };

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
                closeDropdown(priceDropdownMenu, priceDropdownIcon);
            });

            // Price dropdown functionality
            priceDropdown.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleDropdown(priceDropdownMenu, priceDropdownIcon);
                closeDropdown(categoryDropdownMenu, categoryDropdownIcon);
            });

            // Category option selection
            document.querySelectorAll('.category-option').forEach(option => {
                option.addEventListener('click', function() {
                    const value = this.dataset.value;
                    currentFilters.category = value === 'all' ? '' : value;
                    selectedCategorySpan.textContent = value === 'all' ? 'Category' : value.charAt(
                        0).toUpperCase() + value.slice(1);
                    closeDropdown(categoryDropdownMenu, categoryDropdownIcon);
                    updateButtonStates();
                    performFilter();
                });
            });

            // Price option selection
            document.querySelectorAll('.price-option').forEach(option => {
                option.addEventListener('click', function() {
                    const value = this.dataset.value;
                    currentFilters.price = value === 'all' ? '' : value;
                    let displayText = 'Price';
                    switch (value) {
                        case 'low_to_high':
                            displayText = 'Price: Low to High';
                            break;
                        case 'high_to_low':
                            displayText = 'Price: High to Low';
                            break;
                    }
                    selectedPriceSpan.textContent = displayText;
                    closeDropdown(priceDropdownMenu, priceDropdownIcon);
                    updateButtonStates();
                    performFilter();
                });
            });

            // All button functionality
            allButton.addEventListener('click', function() {
                currentFilters = {
                    search: '',
                    category: '',
                    price: ''
                };
                searchInput.value = '';
                selectedCategorySpan.textContent = 'Category';
                selectedPriceSpan.textContent = 'Price';
                updateButtonStates();
                performFilter();
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                closeDropdown(categoryDropdownMenu, categoryDropdownIcon);
                closeDropdown(priceDropdownMenu, priceDropdownIcon);
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
                const hasFilters = currentFilters.search || currentFilters.category || currentFilters.price;

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

                // Update Price button
                if (currentFilters.price) {
                    priceDropdown.classList.add('bg-[#F5CE9F]', 'text-[#8C530D]');
                    priceDropdown.classList.remove('bg-[#EDEDED]', 'text-[#141B34]');
                } else {
                    priceDropdown.classList.remove('bg-[#F5CE9F]', 'text-[#8C530D]');
                    priceDropdown.classList.add('bg-[#EDEDED]', 'text-[#141B34]');
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
                    .then(response => response.json())
                    .then(data => {
                        // Update courses grid
                        const coursesGrid = document.getElementById('courses-grid');
                        const paginationContainer = document.getElementById('pagination-container');

                        if (data.html.trim()) {
                            if (coursesGrid) {
                                coursesGrid.innerHTML = data.html;
                                if (paginationContainer) {
                                    paginationContainer.innerHTML = data.pagination;
                                }
                            } else {
                                coursesContainer.innerHTML = `
                                <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-5" id="courses-grid">
                                    ${data.html}
                                </section>
                                <div id="pagination-container">${data.pagination}</div>
                            `;
                            }
                        } else {
                            coursesContainer.innerHTML = `
                            <!-- Empty State -->
                            <div id="no-courses-section" class="flex flex-col items-center justify-center py-12 sm:py-20 bg-white rounded-[20px] md:rounded-[30px] shadow-sm">
                                <div class="relative mb-6 sm:mb-8">
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl bg-[#E68815] flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 sm:w-12 sm:h-12 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12h.01M12 16h.01" />
                                        </svg>
                                    </div>
                                    <div class="absolute -top-2 -right-2 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-yellow-400 to-orange-400 flex items-center justify-center">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h2 class="text-2xl sm:text-3xl font-bold text-gray-700 mb-4 text-center">No Courses Found</h2>
                                <p class="text-gray-500 text-base sm:text-lg text-center max-w-xs sm:max-w-md mb-6 sm:mb-8 px-4">
                                    No courses match your current search or filter criteria. Try adjusting your filters or search terms.
                                </p>
                            </div>`;
                        }

                        // Update browser URL
                        window.history.pushState({}, '', fetchUrl.toString());
                    })
                    .catch(error => {
                        console.error('Error:', error);
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
        });
    </script>
@endpush
