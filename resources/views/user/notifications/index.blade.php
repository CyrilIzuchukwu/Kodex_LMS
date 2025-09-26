@php use Carbon\Carbon; @endphp
@extends('layouts.user')
@section('content')
    <div class="px-3 md:px-3 lg:px-4  mb-5">
        <!-- Header Section -->
        <nav class="bg-white mb-10 rounded-[20px] md:rounded-[30px] shadow-sm px-4 md:px-6 py-3 flex items-center justify-start w-full">
            <ol class="flex items-center space-x-2 md:space-x-3 text-sm md:text-base font-medium text-[#141B34]">
                <li>
                    <a href="{{ route('user.dashboard') }}" class="hover:text-[#E68815] transition-colors duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-7 7v-10"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </li>
                <li>
                    <span class="text-[#E68815] font-semibold">Notifications</span>
                </li>
            </ol>
        </nav>

        @if($notifications->total() > 0)
            <div class="mb-6 md:mb-8 animate-fade-in">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-2 md:gap-3">
                        <form action="{{ route('user.notifications.markAllRead') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-brand text-white px-4 md:px-6 py-2 md:py-3 rounded-xl font-medium flex items-center justify-center space-x-2 text-sm md:text-base hover:bg-opacity-90 transition-colors">
                                <i class="uil uil-check-circle text-lg"></i>
                                <span>Mark All Read</span>
                            </button>
                        </form>

                        <button id="deleteAllBtn" class="bg-white text-red-600 px-4 md:px-6 py-2 md:py-3 rounded-xl font-medium border border-red-200 flex items-center justify-center space-x-2 text-sm md:text-base hover:bg-red-50 transition-colors">
                            <i class="uil uil-trash-alt text-lg"></i>
                            <span>Delete All</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
            <!-- Total Notifications -->
            <div
                class="card-hover bg-white backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 shadow-lg border border-white animate-slide-up">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-[#f5ce9f] rounded-xl flex items-center justify-center">
                        <i class="uil uil-bell text-white text-lg md:text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-600 text-xs md:text-sm font-medium">Total Notifications</p>
                        <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $notifications->total() }}</p>
                    </div>
                </div>
            </div>

            <!-- Unread Notifications -->
            <div class="card-hover bg-white backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 shadow-lg border border-white animate-slide-up" style="animation-delay: 0.1s">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-red-500 rounded-xl flex items-center justify-center">
                        <i class="uil uil-exclamation-circle text-white text-lg md:text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-600 text-xs md:text-sm font-medium">Unread</p>
                        <p class="text-xl md:text-2xl font-bold text-gray-900">{{ auth()->user()->unreadNotifications->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- This Week -->
            <div class="card-hover bg-white backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 shadow-lg border border-white animate-slide-up" style="animation-delay: 0.2s">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-green-500 rounded-xl flex items-center justify-center">
                        <i class="uil uil-calendar-alt text-white text-lg md:text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-600 text-xs md:text-sm font-medium">This Week</p>
                        <p class="text-xl md:text-2xl font-bold text-gray-900">{{ auth()->user()->notifications()->where('created_at', '>=', now()->startOfWeek())->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="mb-6">
            <div class="flex flex-wrap gap-2 bg-white p-2 rounded-xl shadow-sm border">
                <a href="{{ route('user.notifications.index') }}"
                   class="filter-tab {{ !request('filter') ? 'active' : '' }} px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors">
                    All Notifications
                </a>

                <a href="{{ route('user.notifications.index', ['filter' => 'unread']) }}"
                   class="filter-tab {{ request('filter') == 'unread' ? 'active' : '' }} px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors">
                    Unread
                </a>

                <a href="{{ route('user.notifications.index', ['filter' => 'student']) }}"
                   class="filter-tab {{ request('filter') == 'student' ? 'active' : '' }} px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors">
                    Student Activity
                </a>

                <a href="{{ route('user.notifications.index', ['filter' => 'course']) }}"
                   class="filter-tab {{ request('filter') == 'course' ? 'active' : '' }} px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors">
                    Course Updates
                </a>

                <a href="{{ route('user.notifications.index', ['filter' => 'system']) }}"
                   class="filter-tab {{ request('filter') == 'system' ? 'active' : '' }} px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors">
                    System
                </a>
            </div>
        </div>

        <!-- Notifications List -->
        <div
            class="bg-white backdrop-blur-sm rounded-xl md:rounded-2xl shadow-lg border border-white overflow-hidden animate-fade-in">
            <div class="p-3 sm:p-4 md:p-6 border-b border-gray-100">
                <h3 class="text-base sm:text-lg md:text-xl font-semibold text-gray-900">Recent Notifications</h3>
                <p class="text-gray-600 text-xs sm:text-sm md:text-base">Stay informed about your course activities</p>
            </div>

            <div id="notificationsList" class="divide-y divide-gray-100">
                @forelse($notifications as $notification)
                    <div class="notification-item p-3 sm:p-4 md:p-6 hover:bg-gray-50 transition-colors cursor-pointer {{ $notification->read_at ? '' : 'unread' }}"
                         data-notification-id="{{ $notification->id }}"
                         data-read="{{ $notification->read_at ? 'true' : 'false' }}">
                        <div class="flex items-start gap-2 sm:gap-3">
                            <div class="flex-shrink-0 relative">
                                @php
                                    $notificationType = $notification->data['type'] ?? 'default';
                                    $iconClass = match($notificationType) {
                                        'student_enrollment' => 'uil-user-plus',
                                        'quiz_submission' => 'uil-clipboard-alt',
                                        'course_update' => 'uil-book-open',
                                        'question_asked' => 'uil-question-circle',
                                        'course_purchase' => 'uil-star',
                                        'system_update' => 'uil-cog',
                                        default => 'uil-megaphone'
                                    };
                                    $bgColor = match($notificationType) {
                                        'student_enrollment' => 'from-green-500 to-emerald-500',
                                        'quiz_submission' => 'from-blue-500 to-purple-500',
                                        'course_update' => 'from-orange-500 to-red-500',
                                        'question_asked' => 'from-purple-500 to-pink-500',
                                        'course_purchase' => 'from-yellow-500 to-orange-500',
                                        'system_update' => 'from-gray-500 to-gray-600',
                                        default => 'from-[#EB8C22] to-[#d17a1e]'
                                    };
                                @endphp

                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 bg-gradient-to-br {{ $bgColor }} rounded-full flex items-center justify-center">
                                    <i class="uil {{ $iconClass }} text-white text-base sm:text-lg"></i>
                                </div>

                                @if(!$notification->read_at)
                                    <div class="w-2 h-2 sm:w-3 sm:h-3 bg-[#EB8C22] rounded-full absolute -ml-1 -mt-1 border-2 border-white"></div>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-1 sm:mb-2">
                                    <p class="font-medium {{ $notification->read_at ? 'text-gray-700' : 'text-gray-900' }} text-sm sm:text-base">
                                        {{ $notification->data['title'] ?? 'Notification' }}
                                    </p>
                                    <div class="flex items-center space-x-2 mt-1 sm:mt-0">
                                        <span class="text-xs text-gray-500">
                                            {{ Carbon::parse($notification->created_at)->diffForHumans() }}
                                        </span>
                                        <button
                                            class="delete-notification text-gray-400 hover:text-red-500 transition-colors"
                                            data-notification-id="{{ $notification->id }}">
                                            <i class="uil uil-times text-sm"></i>
                                        </button>
                                    </div>
                                </div>

                                <p class="text-xs sm:text-sm text-gray-600 mb-2">
                                    {!! Str::limit(strip_tags($notification->data['content'] ?? 'No content available'), 100) !!}
                                </p>

                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                    <div class="flex items-center space-x-2 sm:space-x-4">
                                        @php
                                            $badgeColor = match($notificationType) {
                                                'student_enrollment', 'quiz_submission', 'question_asked', 'course_purchase' => 'bg-green-100 text-green-800',
                                                'course_update' => 'bg-orange-100 text-orange-800',
                                                'system_update' => 'bg-gray-100 text-gray-800',
                                                default => 'bg-blue-100 text-blue-800'
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 sm:py-1 rounded-full text-xs font-medium {{ $badgeColor }}">
                                            {{ ucwords(str_replace('_', ' ', $notificationType)) }}
                                        </span>

                                        @if($notification->data['action_url'] ?? false)
                                            <a href="{{ $notification->data['action_url'] }}"
                                               class="text-xs text-blue-600 hover:text-blue-800 transition-colors">
                                                {{ $notification->data['action_text'] ?? 'View Details' }}
                                            </a>
                                        @endif
                                    </div>

                                    @if($notification->data['attachment_url'] ?? false)
                                        <a href="{{ $notification->data['attachment_url'] }}" class="text-[#EB8C22] hover:text-[#d17a1e] text-xs" target="_blank">
                                            <i class="uil uil-download-alt mr-1"></i>
                                            Download
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 sm:p-6 md:p-8 text-center">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="uil uil-bell-slash text-xl sm:text-2xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-600 text-sm sm:text-base">No notifications found.</p>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">You're all caught up! New notifications will appear here.</p>
                    </div>
                @endforelse
            </div>

            @if($notifications->hasPages())
                <div class="p-3 sm:p-4 md:p-6 border-t border-gray-100">
                    <!-- Laravel Pagination -->
                    {{ $notifications->appends(request()->query())->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-[9999] hidden p-4">
            <div class="logout-modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-full max-w-sm md:max-w-md h-auto p-4 md:p-6 flex flex-col items-center justify-center z-[10000]">
                <div class="w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="uil uil-trash-alt text-red-600 text-xl"></i>
                </div>

                <h2 class="text-base md:text-lg font-semibold text-gray-800 mb-4 text-center">Delete All Notifications?</h2>
                <p class="text-gray-600 mb-6 text-center text-xs md:text-sm">
                    This action cannot be undone. All notifications will be permanently
                    removed.
                </p>

                <form id="deleteAllForm" action="{{ route('user.notifications.deleteAll') }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-center gap-3 w-full">
                        <button type="button" id="cancelDelete"
                                class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#EDEDED] text-gray-700 hover:bg-gray-300 transition-colors text-xs md:text-sm">
                            Cancel
                        </button>

                        <button type="submit" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#E30800] text-white hover:bg-red-600 transition-colors text-xs md:text-sm">
                            Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Individual Delete Modal -->
        <div id="deleteIndividualModal" class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-[9999] hidden p-4">
            <div class="logout-modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-full max-w-sm md:max-w-md h-auto p-4 md:p-6 flex flex-col items-center justify-center z-[10000]">
                <div class="w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="uil uil-trash-alt text-red-600 text-xl"></i>
                </div>

                <h2 class="text-base md:text-lg font-semibold text-gray-800 mb-4 text-center">Delete Notification?</h2>
                <p class="text-gray-600 mb-6 text-center text-xs md:text-sm">
                    This notification will be permanently removed.
                </p>

                <form id="deleteIndividualForm" method="POST" class="flex-1 w-full">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-center gap-3 w-full">
                        <button type="button" id="cancelIndividualDelete"
                                class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#EDEDED] text-gray-700 hover:bg-gray-300 transition-colors text-xs md:text-sm">
                            Cancel
                        </button>

                        <button type="submit" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#E30800] text-white hover:bg-red-600 transition-colors text-xs md:text-sm">
                            Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
        }

        .header {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            animation: slideDown 0.8s ease-out;
        }

        .header-content {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
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
            width: 36px;
            height: 36px;
        }

        .back-btn:hover {
            color: #E68815;
            background: white;
            transform: translateX(-3px);
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: #6b7280;
            font-size: 1rem;
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @media (min-width: 768px) {
            .card-hover:hover {
                transform: translateY(-8px);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            }
        }

        .filter-tab {
            color: #6b7280;
            background: transparent;
            text-decoration: none;
        }

        .filter-tab.active {
            background: #f5ce9f;
            color: #1f2937;
        }

        .filter-tab:hover:not(.active) {
            background: #f3f4f6;
            color: #374151;
        }

        .notification-item {
            position: relative;
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .animate-slide-up {
            animation: slideUp 0.5s ease-out;
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

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile-specific styles */
        @media (max-width: 640px) {
            .animate-slide-up {
                animation-delay: 0s !important;
            }

            .notification-item {
                padding: 0.75rem 1rem;
            }

            .notification-item .flex.items-start {
                gap: 0.5rem;
            }

            .notification-item .text-sm {
                font-size: 0.875rem;
            }

            .notification-item .text-xs {
                font-size: 0.75rem;
            }

            .notification-item .rounded-full {
                padding: 0.3rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mark individual notification as read when clicked
            document.querySelectorAll('.notification-item').forEach(item => {
                item.addEventListener('click', function (e) {
                    // Don't trigger if clicking on delete button or action links
                    if (e.target.closest('.delete-notification') || e.target.closest('a')) {
                        return;
                    }

                    const notificationId = this.dataset.notificationId;
                    const isRead = this.dataset.read === 'true';

                    if (!isRead) {
                        // Mark as read via AJAX
                        fetch(`/user/notifications/${notificationId}/mark-read`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Update UI
                                    this.classList.remove('unread');
                                    this.dataset.read = 'true';

                                    // Remove unread indicator
                                    const indicator = this.querySelector('.bg-\\[\\#EB8C22\\]');
                                    if (indicator) {
                                        indicator.remove();
                                    }

                                    // Update unread count in stats
                                    updateUnreadCount();
                                }
                            })
                            .catch(error => {
                                console.error('Error marking notification as read:', error);
                            });
                    }
                });
            });

            // Delete all functionality
            const deleteAllBtn = document.getElementById('deleteAllBtn');
            const deleteModal = document.getElementById('deleteModal');
            const cancelDelete = document.getElementById('cancelDelete');

            if (deleteAllBtn && cancelDelete && deleteModal) {
                deleteAllBtn.addEventListener('click', function () {
                    deleteModal.classList.remove('hidden');
                });

                cancelDelete.addEventListener('click', function () {
                    deleteModal.classList.add('hidden');
                });
            }

            // Individual delete functionality
            let currentDeleteNotificationId = null;
            const deleteIndividualModal = document.getElementById('deleteIndividualModal');
            const deleteIndividualForm = document.getElementById('deleteIndividualForm');
            const cancelIndividualDelete = document.getElementById('cancelIndividualDelete');

            document.querySelectorAll('.delete-notification').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    currentDeleteNotificationId = this.dataset.notificationId;
                    deleteIndividualForm.action = `/user/notifications/${currentDeleteNotificationId}/delete`;
                    deleteIndividualModal.classList.remove('hidden');
                });
            });

            cancelIndividualDelete.addEventListener('click', function () {
                deleteIndividualModal.classList.add('hidden');
            });

            // Handle form submissions with AJAX for better UX
            document.getElementById('deleteAllForm').addEventListener('submit', function (e) {
                e.preventDefault();

                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        _method: 'DELETE'
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload(); // Reload to show updated state
                        } else {
                            showError('Error deleting notifications');
                        }
                    })
                    .catch(error => {
                        showError('Error deleting notifications', error);
                    });
            });

            deleteIndividualForm.addEventListener('submit', function (e) {
                e.preventDefault();

                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        _method: 'DELETE'
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove notification from UI
                            const notificationElement = document.querySelector(`[data-notification-id="${currentDeleteNotificationId}"]`);
                            if (notificationElement) {
                                notificationElement.remove();
                            }

                            deleteIndividualModal.classList.add('hidden');
                            showSuccess('Notification deleted');
                            updateUnreadCount();
                        } else {
                            showError('Error deleting notification');
                        }
                    })
                    .catch(error => {
                        showError('Error deleting notification', error);
                    });
            });

            // Update unread count function
            function updateUnreadCount() {
                const unreadElements = document.querySelectorAll('.notification-item.unread');
                const unreadCount = unreadElements.length;

                // Update stats card
                const unreadStatElement = document.querySelector('.bg-red-500').parentElement.querySelector('.font-bold');
                if (unreadStatElement) {
                    unreadStatElement.textContent = unreadCount;
                }
            }

            // Toast notification function
            const showError = (message) => {
                iziToast.error({ ...iziToastSettings, message });
            };

            const showSuccess = (message) => {
                iziToast.success({ ...iziToastSettings, message });
            };
        });
    </script>
@endpush
