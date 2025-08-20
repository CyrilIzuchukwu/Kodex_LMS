@foreach($categories as $category)
    <!-- Card -->
    <div class="w-auto px-4 py-4 relative border border-[#EDEDED] !rounded-[5px]" data-category-id="{{ $category->id }}">
        <div class="flex justify-between items-start">
            <div class="flex items-center space-x-2">
                <!-- Icon -->
                <div class="w-8 h-8 rounded-full bg-[#F5CE9F] flex items-center justify-center">
                    <i class="uil uil-graduation-cap text-[#8C530D]"></i>
                </div>
            </div>

            <!-- Dropdown -->
            <div class="relative">
                <button class="open-dropdown p-1 rounded-full hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 6a2 2 0 11.001-4.001A2 2 0 0110 6zM10 12a2 2 0 11.001-4.001A2 2 0 0110 12zM10 18a2 2 0 11.001-4.001A2 2 0 0110 18z" />
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div class="dropdown-menu absolute right-0 mt-2 w-60 bg-white rounded-lg shadow-md border border-gray-100 z-10 hidden">
                    <ul class="py-1 text-sm text-gray-700">
                        <li>
                            <button class="open-edit-modal w-full text-left block text-[13px] text-[#1B1B1B] px-4 py-2 hover:bg-gray-50" data-category-name="{{ $category->name }}" data-category-id="{{ $category->id }}">
                                Edit Category
                            </button>
                        </li>
                        <li>
                            <button class="open-delete-modal block cursor-pointer text-[13px] text-[#1B1B1B] px-4 py-2 hover:bg-gray-50" data-category-id="{{ $category->id }}">
                                Delete Category
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center space-x-2">
            <h2 class="category-name font-[400] text-[#444444] text-[12px]">{{ $category->name }}</h2>
        </div>

        <div class="flex items-center justify-between mt-3">
            <span class="text-[18px] font-medium text-[#1B1B1B]">{{ $category->courses_count ?? 0 }}</span>
            <div class="flex items-center space-x-2">
                <!-- View Courses Badge -->
                <a href="{{ route('admin.categories.show', $category->slug) }}" class="bg-amber-100 text-amber-800 text-[10px] font-medium px-2.5 py-0.5 rounded-full hover:bg-amber-200">
                    View Courses
                </a>

                <!-- Status Badge -->
                <span class="{{ $category->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} text-[10px] font-medium px-2.5 py-0.5 rounded-full">
                {{ $category->status == 'active' ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>
    </div>
@endforeach
