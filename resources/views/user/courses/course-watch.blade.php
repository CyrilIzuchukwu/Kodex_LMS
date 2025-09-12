@extends('layouts.user')
@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <div class="px-2 lg:p-8">
        <div class="mx-auto">
            <!-- Header with Course Title and Progress -->
            @include('user.courses.watch.header-title', ['course' => $course, 'progress' => $progress, 'lessons_completed' => $lessons_completed])

            <!-- Video Player -->
            @include('user.courses.watch.video-player', ['course' => $course])

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Left Column - Course Content (2/3 width) -->
                <div class="xl:col-span-2 space-y-8">
                    <!-- Certificate Section -->
                    <div class="bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl p-6 border border-orange-200">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                                    <i class="mdi mdi-certificate text-orange-600 text-xl"></i>
                                </div>

                                <div>
                                    <h3 class="font-semibold text-gray-800">Course Certificate</h3>
                                    <p class="text-sm text-gray-600">Earn a verified certificate upon completion</p>
                                </div>
                            </div>

                            @if($progress >= 100)
                                <a href="{{ route('user.course.certificate.download', $course->slug) }}" class="btn-primary bg-orange-500 text-white px-8 py-3 rounded-full font-medium transition-all duration-300 flex items-center justify-center gap-2 hover:bg-orange-600">
                                    <i class="mdi mdi-download"></i>
                                    Download Certificate
                                </a>
                            @else
                                <button class="btn-primary bg-gray-400 text-gray-200 px-8 py-3 rounded-full font-medium transition-all duration-300 flex items-center justify-center gap-2 cursor-not-allowed" disabled title="Complete the course to unlock the certificate">
                                    <i class="mdi mdi-lock text-gray-200"></i>
                                    Download Certificate
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Navigation Tabs -->
                    <div class="glass-effect rounded-2xl p-6 shadow-lg">
                        <div class="flex flex-wrap gap-3 mb-6">
                            <button class="tab-active rounded-full px-8 py-3 font-medium text-sm transition-all duration-300" onclick="showTab('qa')" id="qa-btn">
                                Q&A
                            </button>

                            <button class="text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-full px-8 py-3 font-medium text-sm transition-all duration-300" onclick="showTab('notes')" id="notes-btn">
                                Notes
                            </button>
                        </div>

                        <!-- Q&A Tab -->
                        <div class="" id="qa-tab">
                            <div id="qa-questions">
                                <!-- Search and Filters -->
                                <div class="space-y-4 mb-8">
                                    <div class="relative">
                                        <input type="search" class="w-full bg-gray-50 border border-gray-200 rounded-full px-6 py-4 pl-12 text-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="Search questions and answers...">
                                    </div>

                                    <div class="flex flex-wrap gap-4">
                                        <select class="bg-orange-100 border border-orange-200 rounded-full px-4 py-2 text-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                            <option>All Modules</option>
                                            @foreach($course->modules as $module)
                                                <option value="{{ $module->id }}">{{ $module->title }}</option>
                                            @endforeach
                                        </select>

                                        <select class="bg-orange-100 border border-orange-200 rounded-full px-4 py-2 text-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                            <option>Most Recent</option>
                                            <option>Most Helpful</option>
                                            <option>Unanswered</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Questions Header -->
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-xl font-bold text-gray-800">
                                        All Questions <span class="text-orange-600 ml-1">247</span>
                                    </h2>

                                    <button class="btn-primary text-white px-6 py-2 rounded-full text-sm font-medium transition-all duration-300">
                                        Ask Question
                                    </button>
                                </div>

                                <!-- Question Cards -->
                                <div class="space-y-6">
                                    <!-- Single Question -->
                                    <div class="bg-white rounded-xl p-6 shadow-sm border hover:shadow-md transition-all duration-300">
                                        <div class="flex items-start gap-4">
                                            <img
                                                class="w-12 h-12 rounded-full object-cover"
                                                src="https://images.unsplash.com/photo-1494790108755-2616b612b19b?w=50&h=50&fit=crop&crop=face"
                                                alt="Student">
                                            <div class="flex-1">
                                                <h3 class="font-semibold text-gray-800 mb-2">Data Cleaning Best Practices</h3>
                                                <p class="text-gray-600 mb-3">What are the most effective techniques for handling missing data in large datasets? I'm working with a customer database that has about 30% missing values.</p>
                                                <div class="flex items-center gap-4 text-sm">
                                                    <span class="text-orange-600 font-medium">Jessica Chen</span>
                                                    <span class="text-gray-400">•</span>
                                                    <span class="text-gray-500">2 days ago</span>
                                                    <span class="text-gray-400">•</span>
                                                    <span class="text-gray-500">Module 2</span>
                                                </div>
                                            </div>
                                            <button onclick="showReplies()" class="relative p-2 text-orange-600 hover:bg-orange-50 rounded-lg transition-colors">
                                                <i class="mdi mdi-reply-circle text-2xl"></i>
                                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Another Question -->
                                    <div class="bg-white rounded-xl p-6 shadow-sm border hover:shadow-md transition-all duration-300">
                                        <div class="flex items-start gap-4">
                                            <img
                                                class="w-12 h-12 rounded-full object-cover"
                                                src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=50&h=50&fit=crop&crop=face"
                                                alt="Student">
                                            <div class="flex-1">
                                                <h3 class="font-semibold text-gray-800 mb-2">Visualization Tool Recommendations</h3>
                                                <p class="text-gray-600 mb-3">Which visualization tool would you recommend for creating interactive dashboards - Tableau, Power BI, or something else?</p>
                                                <div class="flex items-center gap-4 text-sm">
                                                    <span class="text-orange-600 font-medium">Michael Rodriguez</span>
                                                    <span class="text-gray-400">•</span>
                                                    <span class="text-gray-500">5 days ago</span>
                                                    <span class="text-gray-400">•</span>
                                                    <span class="text-gray-500">Module 4</span>
                                                </div>
                                            </div>
                                            <button class="relative p-2 text-orange-600 hover:bg-orange-50 rounded-lg transition-colors">
                                                <i class="mdi mdi-reply-circle text-2xl"></i>
                                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">1</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <button class="w-full mt-8 bg-gray-100 hover:bg-gray-200 text-gray-700 py-4 rounded-xl font-medium transition-colors">
                                    Load More Questions
                                </button>
                            </div>

                            <!-- Replies Section -->
                            <div id="qa-replies" class="hidden">
                                <button onclick="backToQuestions()" class="flex items-center gap-2 mb-6 text-orange-600 hover:text-orange-700 font-medium">
                                    <i class="mdi mdi-arrow-left"></i>
                                    Back to Questions
                                </button>

                                <!-- Original Question -->
                                <div class="bg-orange-50 rounded-xl p-6 mb-8 border border-orange-200">
                                    <div class="flex items-start gap-4">
                                        <img
                                            class="w-12 h-12 rounded-full object-cover"
                                            src="https://images.unsplash.com/photo-1494790108755-2616b612b19b?w=50&h=50&fit=crop&crop=face"
                                            alt="Student">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-800 mb-2">Data Cleaning Best Practices</h3>
                                            <p class="text-gray-600 mb-3">What are the most effective techniques for handling missing data in large datasets? I'm working with a customer database that has about 30% missing values.</p>
                                            <div class="flex items-center gap-4 text-sm">
                                                <span class="text-orange-600 font-medium">Jessica Chen</span>
                                                <span class="text-gray-400">•</span>
                                                <span class="text-gray-500">2 days ago</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Replies -->
                                <div class="space-y-6">
                                    <h3 class="text-lg font-semibold text-gray-800"><span class="text-orange-600 mr-2">3</span>Replies</h3>

                                    <!-- Instructor Reply -->
                                    <div class="bg-white rounded-xl p-6 shadow-sm border border-blue-200">
                                        <div class="flex items-start gap-4">
                                            <img
                                                class="w-10 h-10 rounded-full object-cover"
                                                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=50&h=50&fit=crop&crop=face"
                                                alt="Instructor">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="text-orange-600 font-medium">Dr. Sarah Johnson</span>
                                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">Instructor</span>
                                                </div>
                                                <p class="text-gray-500 text-sm mb-3">2 days ago</p>
                                                <p class="text-gray-700 leading-relaxed">
                                                    Great question! For handling 30% missing data, I'd recommend starting with understanding the pattern of missingness.
                                                    Use techniques like multiple imputation for numerical data and mode imputation for categorical data.
                                                    Also consider if the missing data is missing completely at random (MCAR) or if there's a pattern.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Student Reply -->
                                    <div class="bg-white rounded-xl p-6 shadow-sm border ml-8">
                                        <div class="flex items-start gap-4">
                                            <img
                                                class="w-10 h-10 rounded-full object-cover"
                                                src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=50&h=50&fit=crop&crop=face"
                                                alt="Student">
                                            <div class="flex-1">
                                                <span class="text-orange-600 font-medium">Alex Kumar</span>
                                                <p class="text-gray-500 text-sm mb-3">1 day ago</p>
                                                <p class="text-gray-700 leading-relaxed">
                                                    I've found that visualization tools like missingno library in Python are really helpful for understanding missing data patterns before deciding on the imputation strategy.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reply Form -->
                                    <div class="bg-gray-50 rounded-xl p-6">
                                    <textarea
                                        class="w-full bg-white border border-gray-200 rounded-lg p-4 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                        rows="4"
                                        placeholder="Share your thoughts or ask a follow-up question..."></textarea>
                                        <div class="flex justify-end mt-4">
                                            <button class="btn-primary text-white px-8 py-3 rounded-full font-medium transition-all duration-300">
                                                Post Reply
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes Tab -->
                        <div class="hidden" id="notes-tab">
                            <div class="text-center py-12">
                                <i class="mdi mdi-note-text text-6xl text-gray-300 mb-4"></i>
                                <h3 class="text-xl font-semibold text-gray-600 mb-2">Personal Notes</h3>
                                <p class="text-gray-500 mb-6">Keep track of important concepts and insights</p>
                                <button class="btn-primary text-white px-8 py-3 rounded-full font-medium transition-all duration-300">
                                    Create First Note
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Course Modules and Resources (1/3 width) -->
                <div class="xl:col-span-1 space-y-6">
                    <!-- Instructor Overview -->
                    @include('user.courses.watch.instructor-content', ['course' => $course])

                    <!-- Course Content -->
                    @include('user.courses.watch.course-content', ['course_modules' => $course_modules, 'course' => $course, 'current_module_id' => $current_module_id])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Smooth masking fix */
        #youtube-player {
            background-color: transparent !important;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .gradient-border {
            background: linear-gradient(white, white) padding-box,
            linear-gradient(135deg, #E68815, #f59e0b) border-box;
            border: 2px solid transparent;
        }

        .video-container {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            position: relative;
            overflow: hidden;
        }

        .video-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="8" fill="rgba(255,255,255,0.1)"/></svg>') center/cover;
            opacity: 0.3;
        }

        .progress-ring {
            transform: rotate(-90deg);
        }

        .btn-primary {
            background: linear-gradient(135deg, #E68815 0%, #f59e0b 100%);
            box-shadow: 0 10px 25px rgba(230, 136, 21, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(230, 136, 21, 0.4);
        }

        .module-card {
            transition: all 0.3s ease;
        }

        .module-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .tab-active {
            background: linear-gradient(135deg, #F5CE9F 0%, #E68815 100%);
            color: #8C530D;
            font-weight: 600;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Tab switching functionality
        function showTab(tabName) {
            // Hide all tabs
            document.getElementById("qa-tab").classList.add("hidden");
            document.getElementById("notes-tab").classList.add("hidden");

            // Reset button styles
            const buttons = ['qa-btn', 'notes-btn'];
            buttons.forEach(btnId => {
                const btn = document.getElementById(btnId);
                btn.classList.remove("tab-active");
                btn.classList.add("text-gray-600", "bg-gray-100", "hover:bg-gray-200");
            });

            // Show an active tab and style active button
            const activeTab = document.getElementById(tabName + "-tab");
            const activeBtn = document.getElementById(tabName + "-btn");

            activeTab.classList.remove("hidden");
            activeBtn.classList.add("tab-active");
            activeBtn.classList.remove("text-gray-600", "bg-gray-100", "hover:bg-gray-200");

            // If switching to Q&A tab, ensure questions view is shown
            if (tabName === "qa") {
                document.getElementById("qa-questions").classList.remove("hidden");
                document.getElementById("qa-replies").classList.add("hidden");
            }
        }

        // Q&A navigation
        function showReplies() {
            document.getElementById("qa-questions").classList.add("hidden");
            document.getElementById("qa-replies").classList.remove("hidden");
        }

        function backToQuestions() {
            document.getElementById("qa-questions").classList.remove("hidden");
            document.getElementById("qa-replies").classList.add("hidden");
        }

        // Dropdown functionality
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            const isHidden = dropdown.classList.contains('hidden');

            // Close all dropdowns first
            document.querySelectorAll('[id^="dropdown"]').forEach(dd => dd.classList.add('hidden'));

            // Toggle the clicked dropdown
            if (isHidden) {
                dropdown.classList.remove('hidden');
            }
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('[data-dropdown-toggle]') && !event.target.closest('[id^="dropdown"]')) {
                document.querySelectorAll('[id^="dropdown"]').forEach(dd => dd.classList.add('hidden'));
            }
        });

        // Initialize page with Q&A tab active
        document.addEventListener('DOMContentLoaded', function() {
            showTab('qa');
        });
    </script>

    <script src="https://www.youtube.com/iframe_api"></script>
    <script>
        let player;
        let isPlayerReady = false;

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('youtube-player', {
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        function onPlayerReady() {
            isPlayerReady = true;
            console.log('Player ready');
        }

        function onPlayerStateChange(event) {
            const container = event.target.getIframe().parentElement;
            const playButton = container.querySelector('.play-button');
            const iframe = container.querySelector('iframe');
            const loader = container.querySelector('.loader');

            if (event.data === YT.PlayerState.BUFFERING) {
                loader.classList.remove("opacity-0");
            } else {
                loader.classList.add("opacity-0");
            }

            if (event.data === YT.PlayerState.PLAYING) {
                playButton.classList.add("opacity-0");
                iframe.classList.remove("opacity-0");
            } else if (event.data === YT.PlayerState.PAUSED || event.data === YT.PlayerState.ENDED) {
                playButton.classList.remove("opacity-0");
                iframe.classList.add("opacity-0");
            }
        }

        function toggleYouTubeVideo(container) {
            if (!isPlayerReady) {
                console.warn('Player not ready yet. Retrying in 500ms...');
                setTimeout(() => toggleYouTubeVideo(container), 500);
                return;
            }

            const currentState = player.getPlayerState();

            if (currentState === YT.PlayerState.PLAYING) {
                player.pauseVideo();
            } else {
                player.playVideo();
            }
        }
    </script>
@endpush
