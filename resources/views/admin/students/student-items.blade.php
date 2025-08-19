@forelse($users as $index => $user)
    <tr class="hover:bg-gray-50">
        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 text-center">{{ $users->firstItem() + $index }}</td>

        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-800">
            <div class="flex items-center">
                <a href="#" class="flex items-center">
                    <img class="w-8 h-8 md:w-10 md:h-10 rounded-full mr-3" src="{{ $user->profile && $user->profile->profile_photo_path ? $user->profile->profile_photo_path : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($user->name, 0, 1) }}" alt="Student image">
                    <span class="font-medium">{{ $user->name }}</span>
                </a>
            </div>
        </td>

        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 hidden sm:table-cell text-center">{{ $user->email }}</td>

        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 hidden md:table-cell text-center">{{ $user->profile->phone_number }}</td>

        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 hidden md:table-cell text-center">{{ getTime($user->created_at) }}</td>

        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 hidden md:table-cell text-center">
            <div class="flex items-center justify-center">
                @if($user->status == 'active')
                    <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div>
                    <span>Active</span>
                @else
                    <div class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"></div>
                    <span>Blocked</span>
                @endif
            </div>
        </td>

        <td class="px-2 md:px-6 py-4">
            <div class="flex justify-center relative" x-data="{ open: false }" @click.away="open = false">
                <!-- Gray-colored icon button -->
                <button
                    @click="open = !open"
                    class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 hover:text-gray-700 bg-transparent rounded-lg hover:bg-gray-100 focus:outline-none"
                    type="button"
                    aria-label="Actions menu">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                    </svg>
                </button>

                <!-- Dropdown menu positioned to the left -->
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-full mr-1 top-0 z-20 bg-gray-50 divide-y divide-gray-200 rounded-md shadow-lg w-44 ring-1 ring-gray-300 dark:bg-gray-700 dark:divide-gray-600 dark:ring-gray-600"
                     style="display: none;">
                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                        <li>
                            <a href="{{ route('admin.students.show', $user->id) }}" class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.students.edit', $user->id) }}" class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                        </li>

                        <li>
                            <a data-user-id="{{ $user->id }}" class="delete-user cursor-pointer flex items-center px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-red-400 dark:hover:text-white">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </td>
    </tr>
@empty
    <tr class="hover:bg-gray-50">
        <td colspan="6" class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 text-center">
            No Students Registered
        </td>
    </tr>
@endforelse
