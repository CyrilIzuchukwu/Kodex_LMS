@forelse($loginHistories as $index => $history)
    <tr class="hover:bg-gray-50">
        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 text-center">{{ $loginHistories->firstItem() + $index }}</td>
        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-800">
            <div class="flex items-center">
                <a href="{{ route('admin.instructors.show', $history->user->id) }}" class="flex items-center">
                    <img class="w-8 h-8 md:w-10 md:h-10 rounded-full mr-3" src="{{ $history->user->profile && $history->user->profile->profile_photo_path ? $history->user->profile->profile_photo_path : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($history->user->name, 0, 1) }}" alt="User image">
                    <span class="font-medium">{{ $history->user->name }}</span>
                </a>
            </div>
        </td>
        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 text-center hidden sm:table-cell">{{ $history->ip_address }}</td>
        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 text-center hidden md:table-cell">{{ $history->user_agent }}</td>
        <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 text-center">{{ getTime($history->login_at) }}</td>
    </tr>
@empty
    <tr class="hover:bg-gray-50">
        <td colspan="5" class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 text-center">
            No Login History Available
        </td>
    </tr>
@endforelse
