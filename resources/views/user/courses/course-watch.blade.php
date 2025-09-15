@extends('layouts.user')
@section('content')
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
                                <a href="{{ route('user.course.certificate.download', $course->id) }}" class="btn-primary bg-orange-500 text-white px-8 py-3 rounded-full font-medium transition-all duration-300 flex items-center justify-center gap-2 hover:bg-orange-600">
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
                    @include('user.courses.watch.navigation.tabs', ['questions' => $questions, 'notes' => $notes])
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
