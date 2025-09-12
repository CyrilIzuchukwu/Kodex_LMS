<div class="glass-effect rounded-2xl p-6 shadow-lg">
    <h2 class="text-lg font-bold text-gray-800 mb-6">Course Content</h2>
    <div class="space-y-4 max-h-96 overflow-y-auto scrollbar-hide">
        @foreach($course_modules as $index => $module)
            @php
                $isCurrent = $module->id == $current_module_id;

                // Mark completed if the user has passed this module's quiz
                $isCompleted = $module->quizzes->count() > 0 && in_array($module->quizzes->first()->id, $passedQuizzes);

                // Check if ALL previous modules with quizzes are passed
                $allPreviousPassed = true;
                for ($i = 0; $i < $index; $i++) {
                    $prevQuiz = $course_modules[$i]->quizzes->first();
                    if ($prevQuiz && !in_array($prevQuiz->id, $passedQuizzes)) {
                        $allPreviousPassed = false;
                        break;
                    }
                }

                // Lock condition: unlocked if current OR completed OR all previous quizzes passed
                $isLocked = !$isCurrent && !$isCompleted && !$allPreviousPassed;
            @endphp

            @if($isLocked)
                <!-- Locked Module -->
                <div class="module-card bg-gray-50 rounded-xl p-4 border border-gray-200 opacity-75">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                <i class="mdi mdi-lock text-gray-500 text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-600 text-sm">
                                    Module {{ $index + 1 }}
                                </h3>
                                <p class="text-xs text-gray-500">{{ $module->title }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-100 rounded-lg px-3 py-2 text-xs text-gray-500 text-center">
                        Complete all previous quizzes to unlock
                    </div>
                </div>
            @else
                <!-- Unlocked Module -->
                <div class="module-card {{ $isCurrent ? 'bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl p-4 border-2 border-orange-300 shadow-md' : 'bg-white rounded-xl p-4 border border-gray-200 shadow-sm' }}">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 {{ $isCompleted ? 'bg-green-500' : ($isCurrent ? 'bg-orange-500' : 'bg-gray-300') }} rounded-full flex items-center justify-center">
                                <i class="mdi {{ $isCompleted ? 'mdi-check' : ($isCurrent ? 'mdi-play' : 'mdi-lock-open') }} text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 text-sm">
                                    <a href="{{ route('user.course.watch', ['slug' => $course->slug, 'module' => $module->id]) }}">
                                        Module {{ $index + 1 }}
                                    </a>
                                </h3>
                                <p class="text-xs text-gray-600">{{ $module->title }}</p>
                                @if($isCurrent)
                                    <span class="inline-block bg-orange-200 text-orange-800 px-2 py-1 rounded-full text-xs font-medium mt-1">In Progress</span>
                                @elseif($isCompleted)
                                    <span class="inline-block bg-green-200 text-green-800 px-2 py-1 rounded-full text-xs font-medium mt-1">Completed</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Resources Dropdown -->
                    <div class="relative">
                        <button onclick="toggleDropdown('dropdown{{ $module->id }}')" class="w-full bg-orange-50 border border-orange-200 rounded-lg px-3 py-2 text-orange-800 text-xs font-medium flex items-center justify-between hover:bg-orange-100 transition-colors" data-dropdown-toggle>
                            <div class="flex items-center gap-2">
                                <i class="mdi mdi-folder-open-outline"></i>
                                <span>Resources ({{ $module->resources_count ?? 0 }})</span>
                            </div>
                            <i class="mdi mdi-chevron-down"></i>
                        </button>

                        <div id="dropdown{{ $module->id }}" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                            <div class="p-2 space-y-1">
                                @foreach($module->resources as $rIndex => $resource)
                                    <a href="{{ $resource->resource_url }}" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded">
                                        <i class="mdi mdi-file-pdf-box text-red-500"></i>
                                        <span>Resource {{ $rIndex + 1 }}.pdf</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @if($module->quizzes->count() > 0)
                        <!-- Quiz Section -->
                        <div class="mt-3 bg-blue-50 border border-blue-200 rounded-lg p-3">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <i class="mdi mdi-quiz text-blue-600"></i>
                                    <span class="text-sm font-medium text-blue-800">Module Quiz</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    @if(in_array($module->quizzes->first()->id, $passedQuizzes))
                                        <i class="mdi mdi-check text-green-500 text-sm"></i>
                                        <span class="text-xs text-green-600 font-medium">Passed</span>
                                    @else
                                        <i class="mdi mdi-clock-outline text-gray-500 text-sm"></i>
                                        <span class="text-xs text-gray-600 font-medium">Pending</span>
                                    @endif
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 mb-2">{{ $module->quizzes->first()->question_count }} questions • Pass requirement: {{ $module->quizzes->first()->pass_percentage }}%</p>
                            <a href="{{ route('user.course.quiz.start', ['slug' => $course->slug, 'module' => $module->id]) }}" class="w-full bg-blue-600 text-white py-2 px-3 rounded-lg text-xs font-medium text-center block hover:bg-blue-700 transition-colors">
                                {{ in_array($module->quizzes->first()->id, $passedQuizzes) ? 'Review Quiz' : 'Start Quiz' }}
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        @endforeach
    </div>
</div>
