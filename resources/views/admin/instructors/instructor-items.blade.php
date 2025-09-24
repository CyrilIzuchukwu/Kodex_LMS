@forelse($users as $index => $user)
    <tr class="hover:bg-gray-50">
        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 text-center">{{ $users->firstItem() + $index }}</td>

        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-800">
            <div class="flex items-center">
                <a href="{{ route('admin.instructors.show', $user->id) }}" class="flex items-center">
                    <img class="w-8 h-8 md:w-10 md:h-10 rounded-full mr-3" src="{{ $user->profile && $user->profile?->profile_photo_path ? $user->profile?->profile_photo_path : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($user->name, 0, 1) }}" alt="Instructor image">
                    <span class="font-medium">{{ $user->name }}</span>
                </a>
            </div>
        </td>

        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 hidden sm:table-cell text-center">{{ $user->email }}</td>

        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 hidden md:table-cell text-center">{{ $user->profile?->phone_number ?? '(123) 456 7890' }}</td>

        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 hidden md:table-cell text-center">
            @if ($user->hasSocialAccount('google'))
                <div class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-green-600 rounded-full hover:bg-green-700 transition-colors duration-150 space-x-2">
                    <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
                        <i class="uil uil-google text-lg text-green-600"></i>
                    </div>
                    <span>Google Connected</span>
                </div>
            @else
                <div class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 bg-gray-200 rounded-full hover:bg-gray-300 transition-colors duration-150 space-x-2">
                    <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
                        <i class="uil uil-google text-lg text-gray-500"></i>
                    </div>
                    <span>Not Connected</span>
                </div>
            @endif
        </td>

        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 hidden md:table-cell text-center">{{ getTime($user->created_at) }}</td>

        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 hidden md:table-cell text-center">
            <div class="flex items-center justify-center">
                @if($user->status == 'active')
                    <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div>
                    <span>{{ ucfirst($user->status) }}</span>
                @else
                    <div class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"></div>
                    <span>{{ ucfirst($user->status) }}</span>
                @endif
            </div>
        </td>

        <td class="px-2 md:px-6 py-4">
            <div class="flex justify-center space-x-2">
                <!-- View Button with Tooltip -->
                <a href="{{ route('admin.instructors.show', $user->id) }}" class="group relative inline-flex items-center p-2 text-sm font-medium text-gray-500 hover:text-gray-700 bg-transparent rounded-lg hover:bg-gray-100 focus:outline-none" aria-label="View">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span class="absolute bottom-full mb-2 hidden group-hover:block px-2 py-1 text-xs text-white bg-gray-800 rounded-md">View</span>
                </a>

                <!-- Edit Button with Tooltip -->
                <a href="{{ route('admin.instructors.edit', $user->id) }}" class="group relative inline-flex items-center p-2 text-sm font-medium text-gray-500 hover:text-gray-700 bg-transparent rounded-lg hover:bg-gray-100 focus:outline-none" aria-label="Edit">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span class="absolute bottom-full mb-2 hidden group-hover:block px-2 py-1 text-xs text-white bg-gray-800 rounded-md">Edit</span>
                </a>

                <!-- Delete Button with Tooltip -->
                <a data-user-id="{{ $user->id }}" class="delete-user group relative inline-flex items-center p-2 text-sm font-medium text-red-600 hover:text-red-700 bg-transparent rounded-lg hover:bg-gray-100 focus:outline-none" aria-label="Delete">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <span class="absolute bottom-full mb-2 hidden group-hover:block px-2 py-1 text-xs text-white bg-gray-800 rounded-md">Delete</span>
                </a>
            </div>
        </td>
    </tr>
@empty
    <tr class="hover:bg-gray-50">
        <td colspan="8" class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 text-center">
            No Instructors Registered
        </td>
    </tr>
@endforelse
