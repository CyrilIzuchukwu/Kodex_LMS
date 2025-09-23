@extends('layouts.instructor')
@section('content')
    <div class="px-1 md:px-6 lg:px-8 py-4 md:py-6 mb-5">
        <!-- Header -->
        <div class="glass-effect header">
            <div class="header-content">
                <a href="{{ route('instructor.dashboard') }}" class="back-btn">
                    <i class="mdi mdi-arrow-left"></i>
                </a>
                <div style="flex: 1;">
                    <h1>Questions & Answers</h1>
                    <p>{{ $course->title }}</p>
                </div>
            </div>
        </div>

        <div class="glass-effect rounded-2xl p-4 sm:p-6 shadow-lg">
            <!-- Q&A Tab Content -->
            <div id="qa-tab" class="tab-content">
                <div id="questions-view" class="{{ request()->query('question_id') ? 'hidden' : '' }}">
                    <!-- Search and Filters -->
                    <form id="question-filter-form" method="POST" action="{{ route('instructor.questions.fetch', ['course' => $course->id]) }}">
                        @csrf
                        <input type="hidden" name="tab" value="qa">

                        <div class="space-y-4 mb-6 sm:mb-8">
                            <div class="relative">
                                <input type="search" name="search" id="search-input" class="w-full border border-gray-200 rounded-full py-3 sm:py-4 pl-2 sm:pl-4 text-sm sm:text-base text-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="Search questions and answers..." value="{{ request()->query('search') }}">
                            </div>

                            <div class="flex flex-wrap gap-2 sm:gap-4">
                                <select name="module_id" id="module-filter" class="bg-orange-100 border border-orange-200 rounded-full px-3 sm:px-4 py-2 text-orange-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <option value="">All Modules</option>
                                    @foreach($course->modules as $module)
                                        <option value="{{ $module->id }}" {{ request()->query('module_id') == $module->id ? 'selected' : '' }}>{{ $module->title }}</option>
                                    @endforeach
                                </select>

                                <select name="sort" id="sort-filter" class="bg-orange-100 border border-orange-200 rounded-full px-3 sm:px-4 py-2 text-orange-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 w-40">
                                    <option value="recent" {{ request()->query('sort', 'recent') == 'recent' ? 'selected' : '' }}>Most Recent</option>
                                    <option value="helpful" {{ request()->query('sort') == 'helpful' ? 'selected' : '' }}>Most Helpful</option>
                                    <option value="unanswered" {{ request()->query('sort') == 'unanswered' ? 'selected' : '' }}>Unanswered</option>
                                </select>

                                <button type="submit" class="btn-primary text-white px-4 sm:px-6 py-2 rounded-full text-xs sm:text-sm font-medium">Apply Filters</button>
                            </div>
                        </div>
                    </form>

                    <!-- Questions Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 sm:mb-6 gap-3 sm:gap-0">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-800">
                            All Questions <span id="question-count" class="text-orange-600 ml-1">{{ $questions->total() }}</span>
                        </h2>
                    </div>

                    <!-- Questions Container -->
                    <div id="questions-container" class="space-y-4 sm:space-y-6 overflow-y-auto smooth-scroll max-h-[60vh]">
                        @include('instructor.questions.questions-list', ['questions' => $questions])
                    </div>

                    <!-- Pagination Container -->
                    <div id="pagination-container" class="mt-6 sm:mt-8">
                        {{ $questions->appends(request()->query())->links() }}
                    </div>
                </div>

                <div id="question-view" class="{{ request()->query('question_id') ? '' : 'hidden' }}">
                    @if(request()->query('question_id') && isset($question))
                        <a href="{{ route('instructor.questions.index', $course->id) }}" class="flex items-center gap-2 mb-4 sm:mb-6 text-orange-600 hover:text-orange-700 font-medium text-sm sm:text-base">
                            <i class="mdi mdi-arrow-left text-lg sm:text-xl"></i>
                            Back to Questions
                        </a>

                        <!-- Original Question -->
                        <div id="question-detail" class="bg-orange-50 rounded-xl p-4 sm:p-6 mb-6 sm:mb-8 border border-orange-200">
                            <div class="flex items-start gap-3 sm:gap-4">
                                <img class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover" src="{{ $question->user->profile && $question->user->profile?->profile_photo_path ? asset($question->user->profile?->profile_photo_path) : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($question->user->name ?? 'N', 0, 1) }}" alt="{{ $question->user->name }}">
                                <div class="flex-1">
                                    <h3 id="question-title" class="font-semibold text-gray-800 text-base sm:text-lg mb-2">{{ $question->title }}</h3>
                                    <p id="question-content" class="text-gray-600 text-sm sm:text-base mb-3">{{ $question->content }}</p>
                                    <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-xs sm:text-sm">
                                        <span class="text-orange-600 font-medium">{{ $question->user->name }}</span>
                                        <span class="text-gray-400">•</span>
                                        <span class="text-gray-500">{{ $question->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Replies -->
                        <div class="space-y-4 sm:space-y-6 overflow-y-auto smooth-scroll max-h-[60vh]" id="replies-container">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                                <span class="text-orange-600 mr-2" id="reply-count">{{ $question->replies->count() }}</span>Replies
                            </h3>

                            @forelse($question->replies as $reply)
                                <div id="reply-{{ $reply->id }}" class="bg-white rounded-xl p-4 sm:p-6 shadow-sm border {{ $reply->is_instructor ? 'border-blue-200' : 'ml-4 sm:ml-8' }}">
                                    <div class="flex items-start gap-3 sm:gap-4">
                                        <img class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover" src="{{ $reply->user->profile && $reply->user->profile?->profile_photo_path ? asset($reply->user->profile?->profile_photo_path) : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($reply->user->name ?? 'N', 0, 1) }}" alt="{{ $reply->user->name }}">
                                        <div class="flex-1">
                                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                                <span class="text-orange-600 font-medium text-sm sm:text-base">{{ $reply->user->name }}</span>
                                                @if($reply->is_instructor)
                                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">Instructor</span>
                                                @endif
                                            </div>
                                            <p class="text-gray-500 text-xs sm:text-sm mb-2 sm:mb-3">{{ $reply->created_at->diffForHumans() }}</p>
                                            <p class="text-gray-700 text-sm sm:text-base leading-relaxed">{{ $reply->content }}</p>

                                            <div class="flex items-center gap-4 mt-3">
                                                <div class="flex items-center gap-2">
                                                    <button onclick="toggleLike('reply', {{ $reply->id }}, 'like')" class="like-btn flex items-center gap-1 text-gray-400 hover:text-green-600 transition-colors {{ ($reply->user_like_status ?? null) === 'liked' ? 'text-green-600' : '' }}" data-type="reply" data-id="{{ $reply->id }}">
                                                        <i class="mdi mdi-thumb-up text-sm"></i>
                                                        <span class="likes-count text-xs">{{ $reply->likes_count ?? 0 }}</span>
                                                    </button>

                                                    <button onclick="toggleLike('reply', {{ $reply->id }}, 'dislike')" class="dislike-btn flex items-center gap-1 text-gray-400 hover:text-red-600 transition-colors {{ ($reply->user_like_status ?? null) === 'disliked' ? 'text-red-600' : '' }}" data-type="reply" data-id="{{ $reply->id }}">
                                                        <i class="mdi mdi-thumb-down text-sm"></i>
                                                        <span class="dislikes-count text-xs">{{ $reply->dislikes_count ?? 0 }}</span>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="hidden full-content">{{ $reply->content }}</div>
                                            @if($reply->user_id === Auth::id())
                                                <div class="mt-3 flex gap-3">
                                                    <button onclick="editReply({{ $reply->id }})" class="text-blue-600 hover:text-blue-700 text-sm flex items-center gap-1">
                                                        <i class="mdi mdi-pencil"></i> Edit
                                                    </button>
                                                    <button onclick="deleteReply({{ $reply->id }})" class="text-red-600 hover:text-red-700 text-sm flex items-center gap-1">
                                                        <i class="mdi mdi-delete"></i> Delete
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p id="no-replies" class="text-gray-500 text-sm sm:text-base">No replies yet.</p>
                            @endforelse
                        </div>

                        <!-- Reply Form -->
                        <div class="bg-gray-50 rounded-xl p-4 sm:p-6 mt-6 relative">
                            <form method="POST" id="reply-form" action="{{ route('instructor.questions.reply.store', $course->id) }}">
                                @csrf
                                <input type="hidden" name="question_id" value="{{ $question->id }}">

                                <div class="mb-4">
                                    <textarea name="reply" id="reply-content" class="w-full text-gray-700 border border-gray-200 rounded-lg p-3 sm:p-4 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-orange-500" rows="4" placeholder="Share your thoughts, provide additional help, or ask a follow-up question..."></textarea>
                                    <span class="text-red-500 text-xs hidden error-message" id="reply-content-error"></span>
                                </div>

                                <div class="flex justify-end mt-3 sm:mt-4">
                                    <button type="submit" class="btn-primary text-white px-6 sm:px-8 py-2 sm:py-3 rounded-full font-medium text-sm sm:text-base transition-all duration-300 flex items-center gap-2" id="reply-submit-btn">
                                        <span class="submit-text">Post Reply</span>
                                        <svg class="loading-spinner hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>

                            <!-- Reply form loading overlay -->
                            <div id="reply-form-loading" class="hidden loading-overlay absolute inset-0 bg-gray-50 bg-opacity-75 flex items-center justify-center">
                                <div class="flex items-center gap-3 text-orange-600">
                                    <svg class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                    </svg>
                                    <span class="font-medium">Posting your reply...</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Placeholder for AJAX-loaded content -->
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
        }

        .header {
            padding: 2rem;
            margin-bottom: 2rem;
            animation: slideDown 0.8s ease-out;
        }

        .header-content {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .back-btn {
            padding: 0.5rem;
            color: #6b7280;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            transition: all 0.3s;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
        }

        .back-btn:hover {
            color: #E68815;
            background: white;
            transform: translateX(-3px);
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: #6b7280;
            font-size: 1.1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
        }

        .btn-primary:hover {
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.4);
            transform: translateY(-1px);
        }

        /* Enhanced input styles with dark placeholders */
        input::placeholder,
        textarea::placeholder {
            color: #6b7280 !important;
            opacity: 1;
        }

        input:focus::placeholder,
        textarea:focus::placeholder {
            color: #9ca3af !important;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Fade in animation for new items */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Smooth scroll with hidden scrollbar */
        .smooth-scroll {
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        /* Hide scrollbar for WebKit browsers (Chrome, Safari, Edge) */
        .smooth-scroll::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for Firefox */
        .smooth-scroll {
            scrollbar-width: none;
        }

        /* Hide scrollbar for IE/Edge */
        .smooth-scroll {
            -ms-overflow-style: none;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Global variables
        const courseId = {{ $course->id }};
        const currentUserId = {{ auth()->id() }};
        const csrfToken = '{{ csrf_token() }}';
        const replyAction = '{{ route("instructor.questions.reply.store", $course->id) }}';
        const questionsAction = '{{ route("instructor.questions.fetch", ["course" => $course->id]) }}';
        const backToQuestionsAction = '{{ route('instructor.questions.index', ['course' => $course->id, 'tab' => 'qa']) }}';
        let currentQuestionId = '{{ request()->query("question_id") ?? null }}';
        const originals = new Map();

        // Action URLs
        const replyUpdateAction = (id) => '{{ route("instructor.questions.reply.update", ["course" => $course->id, "reply" => "ID"]) }}'.replace('ID', id);
        const replyDeleteAction = (id) => '{{ route("instructor.questions.reply.destroy", ["course" => $course->id, "reply" => "ID"]) }}'.replace('ID', id);

        // Utility function for profile image
        function getProfileImage(user) {
            return user.profile_photo_path ? user.profile_photo_path : `https://placehold.co/124x124/E5B983/FFF?text=${user.name.charAt(0)}`;
        }

        // Clear reply form
        function clearReplyForm() {
            const replyForm = document.getElementById('reply-form');
            if (replyForm) {
                replyForm.reset();
                document.getElementById('reply-content-error').classList.add('hidden');
            }
        }

        // Show loading state
        function showLoading(loadingId, buttonId) {
            const button = document.getElementById(buttonId);
            const submitText = button.querySelector('.submit-text');
            const loadingSpinner = button.querySelector('.loading-spinner');

            submitText.classList.add('hidden');
            loadingSpinner.classList.remove('hidden');
            button.disabled = true;

            const loadingOverlay = document.getElementById(loadingId);
            if (loadingOverlay) {
                loadingOverlay.classList.remove('hidden');
            }
        }

        // Hide loading state
        function hideLoading(loadingId, buttonId) {
            const button = document.getElementById(buttonId);
            const submitText = button.querySelector('.submit-text');
            const loadingSpinner = button.querySelector('.loading-spinner');

            submitText.classList.remove('hidden');
            loadingSpinner.classList.add('hidden');
            button.disabled = false;

            const loadingOverlay = document.getElementById(loadingId);
            if (loadingOverlay) {
                loadingOverlay.classList.add('hidden');
            }
        }

        // Toggle like/dislike function
        async function toggleLike(type, id, action) {
            if (!{{ auth()->check() ? 'true' : 'false' }}) {
                iziToast.warning({
                    title: 'Authentication Required',
                    message: 'Please log in to like or dislike posts.',
                    position: 'topRight',
                    transitionIn: 'flipInX',
                    transitionOut: 'flipOutX',
                });
                return;
            }

            const formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('type', type);
            formData.append('id', id);
            formData.append('action', action);

            try {
                const response = await fetch('{{ route("instructor.questions.like.toggle") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    updateLikeUI(type, id, data);
                } else {
                    iziToast.error({
                        title: 'Error',
                        message: data.message || 'Failed to update like status',
                        position: 'topRight',
                    });
                }
            } catch (error) {
                console.error('Error toggling like:', error);
                iziToast.error({
                    title: 'Error',
                    message: 'Error updating like status. Please try again.',
                    position: 'topRight',
                });
            }
        }

        // Update UI after like/dislike action
        function updateLikeUI(type, id, data) {
            const container = document.querySelector(`#${type}-${id}`);
            if (!container) return;

            const likeBtn = container.querySelector('.like-btn');
            const dislikeBtn = container.querySelector('.dislike-btn');
            const likesCount = container.querySelector('.likes-count');
            const dislikesCount = container.querySelector('.dislikes-count');

            // Update counts
            if (likesCount) likesCount.textContent = data.likes_count;
            if (dislikesCount) dislikesCount.textContent = data.dislikes_count;

            // Reset button states
            likeBtn.classList.remove('text-green-600');
            likeBtn.classList.add('text-gray-400');
            dislikeBtn.classList.remove('text-red-600');
            dislikeBtn.classList.add('text-gray-400');

            // Set active state based on user status
            if (data.user_status === 'liked') {
                likeBtn.classList.remove('text-gray-400');
                likeBtn.classList.add('text-green-600');
            } else if (data.user_status === 'disliked') {
                dislikeBtn.classList.remove('text-gray-400');
                dislikeBtn.classList.add('text-red-600');
            }
        }

        // Handle reply form submission
        async function submitReplyForm(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const content = formData.get('reply').trim();

            // Clear previous errors
            document.getElementById('reply-content-error').classList.add('hidden');

            // Basic validation
            if (!content) {
                document.getElementById('reply-content-error').textContent = 'Reply content is required';
                document.getElementById('reply-content-error').classList.remove('hidden');
                return;
            }

            showLoading('reply-form-loading', 'reply-submit-btn');

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                });

                const data = await response.json();
                console.log('Reply response:', data); // Debug log

                if (response.ok) {
                    // Create a new reply element
                    const newReply = createReplyElement(data.reply);
                    const container = document.getElementById('replies-container');
                    container.insertAdjacentHTML('beforeend', newReply);
                    container.lastElementChild.classList.add('fade-in');

                    // Update count
                    const countElement = document.getElementById('reply-count');
                    const currentCount = parseInt(countElement.textContent);
                    countElement.textContent = currentCount + 1;

                    // Remove no-replies if present
                    const noReplies = document.getElementById('no-replies');
                    if (noReplies) noReplies.remove();

                    // Clear form
                    clearReplyForm();

                    // Scroll to new reply
                    container.lastElementChild.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    document.getElementById('reply-content-error').textContent = data.message || 'Failed to post reply';
                    document.getElementById('reply-content-error').classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error posting reply:', error);
                document.getElementById('reply-content-error').textContent = error.message || 'Error posting reply. Please try again.';
                document.getElementById('reply-content-error').classList.remove('hidden');
            } finally {
                hideLoading('reply-form-loading', 'reply-submit-btn');
            }
        }

        // Create reply element HTML
        function createReplyElement(reply) {
            const isOwner = reply.user && reply.user.id === currentUserId;
            return `
                <div id="reply-${reply.id}" class="bg-white rounded-xl p-4 sm:p-6 shadow-sm border ${reply.is_instructor ? 'border-blue-200' : 'ml-4 sm:ml-8'}">
                    <div class="flex items-start gap-3 sm:gap-4">
                        <img class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover" src="${getProfileImage(reply.user)}" alt="${reply.user.name}">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <span class="text-orange-600 font-medium text-sm sm:text-base">${reply.user.name}</span>
                                ${reply.is_instructor ? '<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">Instructor</span>' : ''}
                            </div>
                            <p class="text-gray-500 text-xs sm:text-sm mb-2 sm:mb-3">${reply.created_at_diff}</p>
                            <p class="text-gray-700 text-sm sm:text-base leading-relaxed">${reply.content}</p>

                            <!-- Like/Dislike buttons for reply -->
                            <div class="flex items-center gap-4 mt-3">
                                <div class="flex items-center gap-2">
                                    <button
                                        onclick="toggleLike('reply', ${reply.id}, 'like')"
                                        class="like-btn flex items-center gap-1 text-gray-400 hover:text-green-600 transition-colors ${reply.user_like_status === 'liked' ? 'text-green-600' : ''}"
                                        data-type="reply"
                                        data-id="${reply.id}">
                                        <i class="mdi mdi-thumb-up text-sm"></i>
                                        <span class="likes-count text-xs">${reply.likes_count || 0}</span>
                                    </button>

                                    <button
                                        onclick="toggleLike('reply', ${reply.id}, 'dislike')"
                                        class="dislike-btn flex items-center gap-1 text-gray-400 hover:text-red-600 transition-colors ${reply.user_like_status === 'disliked' ? 'text-red-600' : ''}"
                                        data-type="reply"
                                        data-id="${reply.id}">
                                        <i class="mdi mdi-thumb-down text-sm"></i>
                                        <span class="dislikes-count text-xs">${reply.dislikes_count || 0}</span>
                                    </button>
                                </div>
                            </div>

                            <div class="hidden full-content">${reply.content}</div>
                            ${isOwner ? `
                            <div class="mt-3 flex gap-3">
                                <button onclick="editReply(${reply.id})" class="text-blue-600 hover:text-blue-700 text-sm flex items-center gap-1"><i class="mdi mdi-pencil"></i> Edit</button>
                                <button onclick="deleteReply(${reply.id})" class="text-red-600 hover:text-red-700 text-sm flex items-center gap-1"><i class="mdi mdi-delete"></i> Delete</button>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;
        }

        // View specific question (AJAX load)
        async function viewQuestion(id) {
            currentQuestionId = id;
            document.getElementById('questions-view').classList.add('hidden');
            const view = document.getElementById('question-view');
            view.classList.remove('hidden');

            // Show loader
            view.innerHTML = `
                <div class="flex items-center justify-center py-8 sm:py-12">
                    <div class="flex items-center gap-3 text-orange-600">
                        <svg class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span class="font-medium">Loading question...</span>
                    </div>
                </div>
            `;

            try {
                const url = `{{ route('instructor.questions.index', ['course' => $course->id]) }}?tab=qa&question_id=${id}`;
                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                });
                const data = await response.json();
                console.log('View question response:', data); // Debug log

                if (response.ok && data.question) {
                    const question = data.question;
                    const replies = data.replies || [];
                    const user = question.user;

                    if (!user) {
                        throw new Error('User data missing');
                    }

                    view.innerHTML = `
                        <a href="${backToQuestionsAction}" class="flex items-center gap-2 mb-4 sm:mb-6 text-orange-600 hover:text-orange-700 font-medium text-sm sm:text-base">
                            <i class="mdi mdi-arrow-left text-lg sm:text-xl"></i>
                            Back to Questions
                        </a>

                        <!-- Original Question -->
                        <div id="question-detail" class="bg-orange-50 rounded-xl p-4 sm:p-6 mb-6 sm:mb-8 border border-orange-200">
                            <div class="flex items-start gap-3 sm:gap-4">
                                <img class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover" src="${getProfileImage(user)}" alt="${user.name}">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800 text-base sm:text-lg mb-2">${question.title}</h3>
                                    <p class="text-gray-600 text-sm sm:text-base mb-3">${question.content}</p>
                                    <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-xs sm:text-sm">
                                        <span class="text-orange-600 font-medium">${user.name}</span>
                                        <span class="text-gray-400">•</span>
                                        <span class="text-gray-500">${question.created_at_diff}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Replies -->
                        <div class="space-y-4 sm:space-y-6 overflow-y-auto smooth-scroll max-h-[60vh]" id="replies-container">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                                <span class="text-orange-600 mr-2" id="reply-count">${replies.length}</span>Replies
                            </h3>
                            ${replies.length > 0 ? replies.map(r => createReplyElement(r)).join('') : '<p id="no-replies" class="text-gray-500 text-sm sm:text-base">No replies yet.</p>'}
                        </div>

                        <!-- Reply Form -->
                        <div class="bg-gray-50 rounded-xl p-4 sm:p-6 mt-6 relative">
                            <form method="POST" id="reply-form" action="${replyAction}">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="question_id" value="${id}">

                                <div class="mb-4">
                                    <textarea name="reply" id="reply-content" class="w-full text-gray-700 border border-gray-200 rounded-lg p-3 sm:p-4 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-orange-500" rows="4" placeholder="Share your thoughts, provide additional help, or ask a follow-up question..."></textarea>
                                    <span class="text-red-500 text-xs hidden error-message" id="reply-content-error"></span>
                                </div>

                                <div class="flex justify-end mt-3 sm:mt-4">
                                    <button type="submit" class="btn-primary text-white px-6 sm:px-8 py-2 sm:py-3 rounded-full font-medium text-sm sm:text-base transition-all duration-300 flex items-center gap-2" id="reply-submit-btn">
                                        <span class="submit-text">Post Reply</span>
                                        <svg class="loading-spinner hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>

                            <!-- Reply form loading overlay -->
                            <div id="reply-form-loading" class="hidden loading-overlay absolute inset-0 bg-gray-50 bg-opacity-75 flex items-center justify-center">
                                <div class="flex items-center gap-3 text-orange-600">
                                    <svg class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                    </svg>
                                    <span class="font-medium">Posting your reply...</span>
                                </div>
                            </div>
                        </div>
                    `;

                    // Re-attach reply form listener
                    document.getElementById('reply-form').addEventListener('submit', submitReplyForm);
                } else {
                    view.innerHTML = `<p class="text-red-500 text-center">${data.message || 'Failed to load question'}</p>`;
                }
            } catch (error) {
                console.error('Error loading question:', error);
                view.innerHTML = '<p class="text-red-500 text-center">Error loading question. Please try again.</p>';
            }
        }

        // Load questions (AJAX for search/filter/pagination)
        async function loadQuestions(page = null) {
            const form = document.getElementById('question-filter-form');
            const formData = new FormData(form);
            if (page) formData.set('page', page);

            const container = document.getElementById('questions-container');
            container.innerHTML = `
                <div class="flex items-center justify-center py-8">
                    <div class="flex items-center gap-3 text-orange-600">
                        <svg class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span class="font-medium">Loading questions...</span>
                    </div>
                </div>
            `;

            try {
                const response = await fetch(questionsAction, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                });
                const data = await response.json();

                if (response.ok) {
                    container.innerHTML = data.questions_html || '<p id="no-questions" class="text-gray-500 text-center">No questions found.</p>';
                    document.getElementById('question-count').textContent = data.total || 0;
                    document.getElementById('pagination-container').innerHTML = data.pagination_html || '';

                    // Attach pagination click events
                    document.querySelectorAll('#pagination-container a').forEach(link => {
                        link.addEventListener('click', (e) => {
                            e.preventDefault();
                            const linkUrl = new URL(link.href);
                            loadQuestions(linkUrl.searchParams.get('page'));
                        });
                    });
                } else {
                    container.innerHTML = `<p class="text-red-500 text-center">${data.message || 'Failed to load questions'}</p>`;
                }
            } catch (error) {
                console.error('Error loading questions:', error);
                container.innerHTML = '<p class="text-red-500 text-center">Error loading questions. Please try again.</p>';
            }
        }

        // Debounce function
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Cancel edit
        function cancelEdit(key, elemId) {
            const elem = document.getElementById(elemId);
            elem.innerHTML = originals.get(key);
            originals.delete(key);
        }

        // Edit reply
        function editReply(id) {
            const elemId = `reply-${id}`;
            const elem = document.getElementById(elemId);
            if (!elem) return;

            const originalHTML = elem.innerHTML;
            const key = `reply-${id}`;
            originals.set(key, originalHTML);

            const content = elem.querySelector('.full-content').textContent.trim();

            elem.innerHTML = `
                <div class="relative p-4 sm:p-6">
                    <form id="edit-reply-form-${id}" action="${replyUpdateAction(id)}">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="mb-4">
                            <textarea name="reply" class="w-full text-gray-700 border border-gray-200 rounded-lg p-3 sm:p-4 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-orange-500" rows="4">${content}</textarea>
                            <span class="text-red-500 text-xs hidden error-message" id="edit-content-error-${id}"></span>
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="cancelEdit('${key}', '${elemId}')" class="bg-gray-200 text-gray-700 px-4 sm:px-6 py-2 sm:py-3 rounded-full font-medium text-sm sm:text-base">
                                Cancel
                            </button>
                            <button type="submit" class="btn-primary text-white px-6 sm:px-8 py-2 sm:py-3 rounded-full font-medium text-sm sm:text-base transition-all duration-300 flex items-center gap-2" id="edit-submit-${id}">
                                <span class="submit-text">Save Changes</span>
                                <svg class="loading-spinner hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                    <div id="edit-loading-${id}" class="hidden loading-overlay absolute inset-0 bg-opacity-75 flex items-center justify-center">
                        <div class="flex items-center gap-3 text-orange-600">
                            <svg class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            <span class="font-medium">Saving...</span>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById(`edit-reply-form-${id}`).addEventListener('submit', (e) => submitEditReply(e, id, elemId));
        }

        // Submit edit reply
        async function submitEditReply(e, id, elemId) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const content = formData.get('reply').trim();

            document.getElementById(`edit-content-error-${id}`).classList.add('hidden');

            if (!content) {
                document.getElementById(`edit-content-error-${id}`).textContent = 'Reply content is required';
                document.getElementById(`edit-content-error-${id}`).classList.remove('hidden');
                return;
            }

            showLoading(`edit-loading-${id}`, `edit-submit-${id}`);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    const elem = document.getElementById(elemId);
                    elem.outerHTML = createReplyElement(data.reply);
                    originals.delete(`reply-${id}`);
                } else {
                    document.getElementById(`edit-content-error-${id}`).textContent = data.message || 'Failed to update reply';
                    document.getElementById(`edit-content-error-${id}`).classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error updating reply:', error);
                document.getElementById(`edit-content-error-${id}`).textContent = 'Error updating reply. Please try again.';
                document.getElementById(`edit-content-error-${id}`).classList.remove('hidden');
            } finally {
                hideLoading(`edit-loading-${id}`, `edit-submit-${id}`);
            }
        }

        // Delete reply
        function deleteReply(id) {
            handleDeleteClick(
                event,
                replyDeleteAction(id),
                'reply',
                id,
                'reply-count',
                'replies-container',
                'no-replies'
            );
        }

        // Handle delete with iziToast confirmation
        function handleDeleteClick(e, actionUrl, type, id, countElementId, containerId, noItemId) {
            e.preventDefault();
            iziToast.question({
                timeout: false,
                close: false,
                displayMode: 'once',
                id: `${type}-delete-confirmation-${id}`,
                title: 'Are you sure?',
                message: `Do you want to delete this ${type}?`,
                position: 'topRight',
                transitionIn: "flipInX",
                transitionOut: "flipOutX",
                buttons: [
                    ['<button><b>Yes, Delete</b></button>', async function (instance, toast) {
                        const formData = new FormData();
                        formData.append('_token', csrfToken);
                        formData.append('_method', 'DELETE');

                        try {
                            const response = await fetch(actionUrl, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json',
                                }
                            });
                            const data = await response.json();

                            if (response.ok) {
                                const elem = document.getElementById(`${type}-${id}`);
                                if (elem) elem.remove();
                                const countElem = document.getElementById(countElementId);
                                let count = countElem ? parseInt(countElem.textContent) - 1 : 0;
                                if (countElem) {
                                    countElem.textContent = count;
                                }
                                if (count === 0 && containerId && noItemId) {
                                    document.getElementById(containerId).insertAdjacentHTML('beforeend', `<p id="${noItemId}" class="text-gray-500 text-sm sm:text-base">No ${type}s yet.</p>`);
                                }
                            } else {
                                iziToast.error({
                                    title: 'Error',
                                    message: data.message || `Failed to delete ${type}`,
                                    position: 'topRight',
                                    transitionIn: 'flipInX',
                                    transitionOut: 'flipOutX',
                                });
                            }
                        } catch (error) {
                            console.error(`Error deleting ${type}:`, error);
                            iziToast.error({
                                title: 'Error',
                                message: `Error deleting ${type}. Please try again.`,
                                position: 'topRight',
                                transitionIn: 'flipInX',
                                transitionOut: 'flipOutX',
                            });
                        }
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }, true],
                    ['<button>No</button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }]
                ]
            });
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Form submissions
            document.getElementById('reply-form')?.addEventListener('submit', submitReplyForm);

            // Filter form
            document.getElementById('question-filter-form')?.addEventListener('submit', async (e) => {
                e.preventDefault();
                await loadQuestions();
            });

            // Search input debounce
            document.getElementById('search-input')?.addEventListener('input', debounce(async () => {
                await loadQuestions();
            }, 500));

            // Filter dropdowns
            document.getElementById('module-filter')?.addEventListener('change', async () => {
                await loadQuestions();
            });

            document.getElementById('sort-filter')?.addEventListener('change', async () => {
                await loadQuestions();
            });

            // Pagination
            document.querySelectorAll('#pagination-container a').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const url = new URL(link.href);
                    loadQuestions(url.searchParams.get('page'));
                });
            });

            // Load specific question if present
            if (currentQuestionId) {
                viewQuestion(currentQuestionId);
            }
        });
    </script>
@endpush
