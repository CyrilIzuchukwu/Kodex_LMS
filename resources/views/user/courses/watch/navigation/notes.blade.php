@forelse($notes as $note)
    <div id="note-{{ $note->id }}" class="bg-white rounded-xl p-4 sm:p-6 shadow-sm border hover:shadow-md transition-all duration-300">
        <h3 class="font-semibold text-gray-800 text-base sm:text-lg mb-2">{{ $note->title ?? 'Untitled' }}</h3>
        <p class="text-gray-600 text-sm sm:text-base mb-3">{{ Str::limit($note->content, 200) }}</p>

        <div class="hidden full-content">{{ $note->content }}</div>

        <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-xs sm:text-sm">
            <span class="text-gray-500">{{ $note->created_at->diffForHumans() }}</span>
            <span class="text-gray-400">•</span>
            <span class="text-gray-500">{{ $note->module->title }}</span>
        </div>

        <div class="mt-3 flex gap-3">
            <button onclick="editNote({{ $note->id }})" class="text-blue-600 hover:text-blue-700 text-sm flex items-center gap-1">
                <i class="mdi mdi-pencil"></i> Edit
            </button>
            <button onclick="deleteNote({{ $note->id }})" class="text-red-600 hover:text-red-700 text-sm flex items-center gap-1">
                <i class="mdi mdi-delete"></i> Delete
            </button>
        </div>
    </div>
@empty
    <p id="no-notes" class="text-gray-500 text-center hidden">No notes found.</p>
@endforelse

