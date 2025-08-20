@extends('layouts.admin')
@section('content')
    <div>
        <p class="text-[20px] font-medium text-[#5D5D5D] mb-8">
            Course Oversight > <span class="text-[#848484]">Add category</span>
        </p>

        <div class="w-auto bg-white rounded-[24px] px-4 py-4 md:px-6 md:py-6 shadow-sm overflow-hidden">
            <div class="flex flex-col justify-center items-center md:flex-row md:justify-between mb-8 gap-2">
                <!-- Search Bar -->
                <div class="relative w-full md:max-w-xs">
                    <form action="">
                        <span class="absolute left-4 top-[14px] text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                            </svg>
                        </span>
                        <input type="search" id="searchInput" placeholder="Search" value="{{ $searchQuery ?? '' }}" class="w-full pl-10 pr-4 py-3 border-none rounded-full bg-gray-100 focus:outline-none focus:ring-1 focus:border-none focus:ring-[#cc770f] text-sm text-gray-700 placeholder-gray-500" />
                    </form>
                </div>

                <!-- Add Category Button -->
                <button id="open-add-modal" class="flex items-center justify-center space-x-1 w-full md:w-auto bg-[#E68815] hover:bg-[#cc770f] text-white text-sm font-medium px-5 py-3 rounded-full shadow">
                    <i class="uil uil-plus text-sm font-medium"></i>
                    <span>Add Category</span>
                </button>
            </div>

            <div id="content-container">
                @if($categories->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-[24px] gap-y-[20px] mb-4" id="categories-container">
                        @include('admin.category.category-items', ['categories' => $categories])
                    </div>

                    <div id="pagination">
                        {{ $categories->links('vendor.pagination.tailwind') }}
                    </div>
                @else
                    <div id="no-categories" class="flex flex-col items-center justify-center bg-gray-50 text-center">
                        <div class="w-16 h-16 rounded-full bg-[#F5CE9F] flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-[#8C530D]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12h.01M12 16h.01" />
                            </svg>
                        </div>
                        <h2 class="font-[400] text-[#444444] text-[20px] mb-4">No Categories Found</h2>
                        <p class="text-[14px] text-[#1B1B1B] max-w-lg mb-6">It looks like there are no categories available at the moment. Try adding a new category or adjusting your search to find what you're looking for.</p>
                        <button id="open-add-modal" class="inline-block px-6 py-3 bg-[#E68815] text-white text-[14px] font-medium rounded-[5px] hover:bg-[#d67a12] transition-colors">Add New Category</button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Overlay for Adding Category -->
    <div id="add-modal" class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex justify-center items-center z-[9999] overflow-y-auto pt-8 pb-8 px-4 md:px-0 hidden opacity-0 transition-all duration-300 ease-in-out" role="dialog" aria-modal="true">
        <div class="bg-[#F9FAFC] modal-content rounded-[20px] relative shadow-lg max-w-[100%] w-[600px] p-6 md:p-10 z-[10000] self-start mt-8 mb-8 transform scale-95 transition-transform duration-300 ease-in-out">
            <!-- Header -->
            <div class="absolute -top-4 -right-4">
                <button id="close-add-modal" class="w-[50px] h-[50px] flex items-center justify-center rounded-full bg-white shadow-md text-black text-2xl leading-none hover:bg-gray-100 focus:outline-none" style="box-shadow: 0 2px 4px 0 #00000040;">
                    &times;
                </button>
            </div>

            <form id="add-form" action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <div class="flex items-center space-x-2 mb-8">
                        <div class="w-10 h-10 rounded-full bg-[#E68815] flex items-center justify-center">
                            <i class="uil uil-folder text-white"></i>
                        </div>
                        <h3 class="text-base font-medium text-[#1B1B1B]">Add Category</h3>
                    </div>
                    <div class="grid grid-cols-1">
                        <div>
                            <label class="block text-sm font-medium text-[#1B1B1B] mb-2">Category Name *</label>
                            <input name="name" type="text" class="w-full border h-12 border-gray-300 rounded-lg p-2 pl-3 focus:border-[#E68815] text-black text-sm focus:ring-1 focus:ring-[#E68815]" placeholder="Development, Design, Security">
                            <span class="text-red-500 text-xs mt-1 hidden error-message"></span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row justify-end gap-4 mt-8 w-full">
                    <button type="button" id="cancel-add-modal" class="bg-[#EDEDED] w-full md:w-[200px] text-gray-800 text-sm font-medium px-6 py-3 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </button>

                    <button type="submit" class="bg-[#E68815] w-full md:w-auto text-white text-sm px-6 py-3 rounded-full hover:bg-[#cc6f0f] focus:outline-none focus:ring-2 focus:ring-[#E68815] flex items-center justify-center">
                        <span class="submit-text">Save and Continue</span>
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

    <!-- Edit Category Modal -->
    <div id="edit-modal" class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex justify-center items-center z-[9999] overflow-y-auto pt-8 pb-8 px-4 md:px-0 hidden opacity-0 transition-all duration-300 ease-in-out" role="dialog" aria-modal="true">
        <div class="bg-[#F9FAFC] modal-content rounded-[20px] relative shadow-lg max-w-[100%] w-[600px] p-6 md:p-10 z-[10000] self-start mt-8 mb-8 transform scale-95 transition-transform duration-300 ease-in-out">
            <!-- Header -->
            <div class="absolute -top-4 -right-4">
                <button id="close-edit-modal" class="w-[50px] h-[50px] flex items-center justify-center rounded-full bg-white shadow-md text-black text-2xl leading-none hover:bg-gray-100 focus:outline-none" style="box-shadow: 0 2px 4px 0 #00000040;">
                    &times;
                </button>
            </div>

            <form id="edit-form" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-6">
                    <div class="flex items-center space-x-2 mb-8">
                        <div class="w-10 h-10 rounded-full bg-[#E68815] flex items-center justify-center">
                            <i class="uil uil-folder text-white"></i>
                        </div>
                        <h3 class="text-base font-medium text-[#1B1B1B]">Edit Category</h3>
                    </div>
                    <div class="grid grid-cols-1">
                        <div>
                            <label class="block text-sm font-medium text-[#1B1B1B] mb-2">Category Name *</label>
                            <input name="name" type="text" id="edit-category-name" class="w-full border h-12 border-gray-300 rounded-lg p-2 pl-3 focus:border-[#E68815] text-black text-sm focus:ring-1 focus:ring-[#E68815]" placeholder="Development, Design, Security">
                            <span class="text-red-500 text-xs mt-1 hidden error-message"></span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row justify-end gap-4 mt-8 w-full">
                    <button type="button" id="cancel-edit-modal" class="bg-[#EDEDED] w-full md:w-[200px] text-gray-800 text-sm font-medium px-6 py-3 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </button>

                    <button type="submit" class="bg-[#E68815] w-full md:w-auto text-white text-sm px-6 py-3 rounded-full hover:bg-[#cc6f0f] focus:outline-none focus:ring-2 focus:ring-[#E68815] flex items-center justify-center">
                        <span class="submit-text">Save Changes</span>
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

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-[9999] hidden p-4 opacity-0 transition-all duration-300 ease-in-out">
        <div class="modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-full max-w-sm md:max-w-md h-auto p-4 md:p-6 flex flex-col items-center justify-center z-[10000] transform scale-95 transition-transform duration-300 ease-in-out">
            <img src="{{ asset('dashboard_assets/images/img/gradient.png') }}" alt="delete" class="w-12 h-12 md:w-16 md:h-16 mb-4">
            <h2 class="text-base md:text-lg font-semibold text-gray-800 mb-4 text-center">Delete Category?</h2>
            <p class="text-gray-600 mb-6 text-center text-xs md:text-sm">
                Are you sure you want to delete this category? This action cannot be undone.
            </p>

            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-center gap-3 w-full">
                    <button type="button" id="cancel-delete" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#EDEDED] text-gray-700 hover:bg-gray-300 transition-colors text-xs md:text-sm">
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
