@forelse($questions as $question)
    <div id="question-{{ $question->id }}" class="bg-white rounded-xl p-4 sm:p-6 shadow-sm border hover:shadow-md transition-all duration-300">
        <div class="flex items-start gap-3 sm:gap-4">
            <img class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover" src="{{ $question->user->profile && $question->user->profile->profile_photo_path ? asset($question->user->profile->profile_photo_path) : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($question->user->name ?? 'N', 0, 1) }}" alt="{{ $question->user->name }}">
            <div class="flex-1">
                <h3 class="font-semibold text-gray-800 text-base sm:text-lg mb-2">{{ $question->title }}</h3>
                <p class="text-gray-600 text-sm sm:text-base mb-3">{{ Str::limit($question->content, 200) }}</p>

                <div class="hidden full-content">{{ $question->content }}</div>

                <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-xs sm:text-sm">
                    <span class="text-orange-600 font-medium">{{ $question->user->name }}</span>
                    <span class="text-gray-400">•</span>
                    <span class="text-gray-500">{{ $question->created_at->diffForHumans() }}</span>
                    <span class="text-gray-400">•</span>
                    <span class="text-gray-500">{{ $question->module->title }}</span>
                </div>

                @if($question->user_id === Auth::id())
                    <div class="mt-3 flex gap-3">
                        <button onclick="editQuestion({{ $question->id }})" class="text-blue-600 hover:text-blue-700 text-sm flex items-center gap-1">
                            <i class="mdi mdi-pencil"></i> Edit
                        </button>
                        <button onclick="deleteQuestion({{ $question->id }})" class="text-red-600 hover:text-red-700 text-sm flex items-center gap-1">
                            <i class="mdi mdi-delete"></i> Delete
                        </button>
                    </div>
                @endif
            </div>
            <button onclick="viewQuestion({{ $question->id }})" class="relative p-2 text-orange-600 hover:bg-orange-50 rounded-lg transition-colors min-w-[40px] sm:min-w-[48px]">
                <i class="mdi mdi-reply-circle text-xl sm:text-2xl"></i>
                <span class="absolute -top-1 -right-1 w-4 h-4 sm:w-5 sm:h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">{{ $question->replies->count() }}</span>
            </button>
        </div>
    </div>
@empty
    <p id="no-questions" class="text-gray-500 text-center">No questions found.</p>
@endforelse
