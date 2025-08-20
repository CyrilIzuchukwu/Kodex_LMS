@forelse($courses as $index => $course)
    <tr class="hover:bg-gray-50">
        <td class="px-4 py-4 text-xs text-gray-700 text-center sm:px-6 sm:text-sm">
            {{ $courses->firstItem() + $index }}
        </td>

        <td class="px-4 py-4 text-xs text-gray-700 text-left sm:px-6 sm:text-sm">
            {{ $course->title }}
        </td>

        @if(Route::is('admin.courses.index'))
            <td class="px-4 py-4 text-xs text-gray-700 text-left sm:px-6 sm:text-sm">
                <a href="{{ route('admin.categories.show', $course->course_category->slug) }}" class="font-semibold">
                    {{ $course->course_category->name }}
                </a>
            </td>
        @endif

        <td class="px-4 py-4 text-xs text-gray-700 text-center hidden sm:table-cell sm:px-6 sm:text-sm">
            <span class="bg-amber-100 text-amber-800 text-[10px] font-medium px-2.5 py-0.5 rounded-full">
                {{ $course->students_enrolled ?? 0 }}
            </span>
        </td>

        <td class="px-4 py-4 text-xs text-gray-700 text-center hidden md:table-cell sm:px-6 sm:text-sm">
            ₦ {{ number_format($course->price, 2) }}
        </td>
        <td class="px-4 py-4 sm:px-6">
            <div class="flex justify-center relative">
                <button class="inline-flex items-center p-2 text-sm font-medium text-gray-500 hover:text-gray-700 bg-transparent rounded-lg hover:bg-gray-100 focus:outline-none" type="button" aria-label="Actions menu">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"></path>
                    </svg>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr class="hover:bg-gray-50">
        <td colspan="5" class="px-4 py-4 text-xs text-gray-700 text-center sm:px-6 sm:text-sm">
            No Courses Registered
        </td>
    </tr>
@endforelse
