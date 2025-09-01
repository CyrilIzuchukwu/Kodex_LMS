@foreach($categories as $category)
    <!-- Card -->
    <div class="w-auto px-4 py-4 relative border border-[#EDEDED] rounded-xl bg-white transition-colors duration-200 hover:bg-gray-50" data-category-id="{{ $category->id }}">
        <div class="flex justify-between items-start">
            <div class="flex items-center space-x-2">
                <!-- Icon -->
                <div class="w-8 h-8 rounded-full bg-[#F5CE9F] flex items-center justify-center">
                    <i class="uil uil-graduation-cap text-[#8C530D]"></i>
                </div>
            </div>

            <!-- Tooltip Buttons -->
            <div class="flex items-center space-x-2">
                <!-- Edit Button with Tooltip -->
                <div class="relative group">
                    <button class="open-edit-modal p-2 rounded-full hover:bg-gray-200 transition-colors duration-150" data-category-name="{{ $category->name }}" data-category-id="{{ $category->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                    <span class="absolute right-0 top-10 w-24 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none">
                        Edit Category
                    </span>
                </div>

                <!-- Delete Button with Tooltip -->
                <div class="relative group">
                    <button class="open-delete-modal p-2 rounded-full hover:bg-gray-200 transition-colors duration-150" data-category-id="{{ $category->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 4v12m4-12v12" />
                        </svg>
                    </button>
                    <span class="absolute right-0 top-10 w-24 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none">
                        Delete Category
                    </span>
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
                <a href="{{ route('admin.categories.show', $category->slug) }}" class="bg-amber-100 text-amber-800 text-[10px] font-medium px-2.5 py-0.5 rounded-full hover:bg-amber-200 transition-colors duration-150">
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
