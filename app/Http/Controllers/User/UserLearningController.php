<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseEnrollment;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class UserLearningController extends Controller
{
    /**
     * @throws Throwable
     */
    public function myCoursesPurchases(Request $request)
    {
        // Get user_id
        $user_id = Auth::id();

        // Recently enrolled courses
        $query = CourseEnrollment::with([
            'course' => function ($query) {
                $query->with(['profile.user', 'category', 'media'])
                    ->select('courses.*')
                    ->withCount('modules');
            }
        ])->where('user_id', $user_id)
            ->whereNull('last_accessed');

        // Apply search filter
        if ($search = trim($request->input('search'))) {
            $query->whereHas('course', function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            });
        }

        // Apply category filter
        if ($category = trim($request->input('category'))) {
            $query->whereHas('course.category', function ($q) use ($category) {
                $q->where('name', $category);
            });
        }

        // Ensure consistent ordering
        $query->orderBy('title');

        // Paginate results
        $courses = $query->latest()
            ->paginate(6)
            ->withQueryString();

        // Fetch categories
        $categories = CourseCategory::select(['id', 'name'])
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        // Handle AJAX request
        if ($request->ajax()) {
            return response()->json([
                'html' => view('user.courses.purchases-list', compact('courses'))->render(),
                'pagination' => $courses->links('vendor.pagination.tailwind')->render()
            ]);
        }

        // My learning Courses (accessed within the last 48 hours)
        $myLearning = CourseEnrollment::with([
            'course' => function ($query) {
                $query->with(['profile.user', 'category', 'media'])
                    ->select('courses.*')
                    ->withCount('modules');
            }
        ])->where('user_id', $user_id)
            ->whereNotNull('last_accessed')
            ->where('last_accessed', '>=', now()->subHours(48))
            ->where('status', 'running')
            ->orderBy('last_accessed', 'desc')
            ->latest()
            ->paginate(3);

        // Calculate metrics
        $totalCourseCount = CourseEnrollment::where('user_id', $user_id)->count();
        $activeCourseCount = CourseEnrollment::where('user_id', $user_id)
            ->whereNotNull('last_accessed')
            ->count();
        $completedCourseCount = CourseEnrollment::where('user_id', $user_id)
            ->where('status', 'completed')
            ->count();

        return view('user.courses.purchases', [
            'title' => 'My Courses Purchases',
            'courses' => $courses,
            'categories' => $categories,
            'myLearning' => $myLearning,
            'metrics' => [
                'total_course_count' => $totalCourseCount,
                'active_course_count' => $activeCourseCount,
                'completed_course_count' => $completedCourseCount,
            ]
        ]);
    }

    /**
     * @throws Throwable
     */
    public function myLearning(Request $request)
    {
        $user_id = Auth::id();

        // Base query for enrolled courses
        $query = CourseEnrollment::with([
            'course' => function ($query) {
                $query->with(['profile.user', 'category', 'media'])
                    ->select('courses.*')
                    ->withCount('modules');
            }
        ])
            ->where('user_id', $user_id)
            ->where('status', 'running');

        // Apply search filter
        if ($search = trim($request->input('search'))) {
            $query->whereHas('course', function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            });
        }

        // Apply category filter
        if ($category = trim($request->input('category'))) {
            $query->whereHas('course.category', function ($q) use ($category) {
                $q->where('name', $category);
            });
        }

        // Apply time-based filter for recent activity
        $query->whereNotNull('last_accessed')
            ->where('last_accessed', '>=', now()->subHours(48));

        // Order and paginate
        $courses = $query->orderByDesc('last_accessed')
            ->paginate(6)
            ->withQueryString();

        // Fetch categories
        $categories = CourseCategory::select(['id', 'name'])
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        // Handle AJAX request
        if ($request->ajax()) {
            return response()->json([
                'html' => view('user.courses.purchases-list', compact('courses'))->render(),
                'pagination' => $courses->links('vendor.pagination.tailwind')->render()
            ]);
        }

        return view('user.courses.my-learning', [
            'title' => 'My Courses Purchases',
            'courses' => $courses,
            'categories' => $categories
        ]);
    }

    public function courseWatch(string $slug, string $module)
    {
        // Get course by slug
        $course = Course::where('slug', $slug)
            ->with([
                'modules.quizzes',
                'modules.resources',
                'category',
                'profile.user',
                'media',
                'enrollments' => function ($query) {
                    $query->where('user_id', auth()->id());
                },
            ])
            ->withCount('modules')
            ->firstOrFail();

        // Load modules with resource count
        $course_modules = $course->modules()
            ->with('resources')
            ->withCount('resources')
            ->get();

        // Get enrollment data
        $enrollment = CourseEnrollment::where('course_id', $course->id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Get requested current module
        $currentModule = Module::where('id', $module)
            ->where('course_id', $course->id)
            ->firstOrFail();

        // Get IDs of quizzes the user has passed
        $passedQuizzes = QuizAttempt::where('user_id', Auth::id())
            ->where('passed', true)
            ->pluck('quiz_id')
            ->toArray();

        // Check if the module is accessible
        $modules = $course->modules;
        $currentModuleIndex = $modules->search(fn($m) => $m->id == $currentModule->id);

        // Check if all previous modules with quizzes are passed
        $allPreviousPassed = true;
        for ($i = 0; $i < $currentModuleIndex; $i++) {
            $prevQuiz = $modules[$i]->quizzes->first();
            if ($prevQuiz && !in_array($prevQuiz->id, $passedQuizzes)) {
                $allPreviousPassed = false;
                break;
            }
        }

        // Check if the current module is completed
        $isCompleted = $currentModule->quizzes->count() > 0 && in_array($currentModule->quizzes->first()->id, $passedQuizzes);

        // Allow access if the module is the first module, completed, or all previous quizzes are passed
        if ($currentModuleIndex > 0 && !$isCompleted && !$allPreviousPassed) {
            abort(403, 'You must pass the quizzes for all previous modules to unlock this module.');
        }

        // Update enrollment with the last accessed and current module
        $updateData = [
            'last_accessed' => now(),
        ];

        if (is_null($enrollment->module_id)) {
            $updateData['module_id'] = $currentModule->id;
        }

        $enrollment->update($updateData);

        // Get video URL and extract YouTube ID
        $videoUrl = $currentModule->video_url ?? 'https://www.youtube.com/watch?v=CpPT2hHnZls';
        if (!$videoUrl) {
            abort(404, 'Module video not found.');
        }

        preg_match('%(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com/(?:embed/|v/|watch\?v=))([\w-]{10,12})%i', $videoUrl, $matches);
        $videoId = $matches[1] ?? 'CpPT2hHnZls';

        if (!$videoId) {
            abort(404, 'Invalid YouTube video URL.');
        }

        $course_outcomes = $course->outcomes;
        $progress = $enrollment->progress;
        $lessons_completed = $enrollment->lessons_completed;

        return view('user.courses.course-watch', [
            'title' => $course->title,
            'course' => $course,
            'course_outcomes' => $course_outcomes,
            'progress' => $progress,
            'lessons_completed' => $lessons_completed,
            'youtube_id' => $videoId,
            'current_module_id' => $module,
            'enrollment' => $enrollment,
            'course_modules' => $course_modules,
            'passedQuizzes' => $passedQuizzes,
        ]);
    }

    public function courseQuiz(string $slug, string $module)
    {
        // Get Course by slug
        $course = Course::where('slug', $slug)
            ->with([
                'category',
                'profile.user',
                'media',
                'enrollments' => function ($query) {
                    $query->where('user_id', auth()->id());
                },
            ])
            ->withCount(['modules'])
            ->firstOrFail();

        // Get Enrollment
        $enrollment = CourseEnrollment::where('course_id', $course->id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Get requested module
        $currentModule = Module::where('id', $module)
            ->where('course_id', $course->id)
            ->firstOrFail();

        // Check if the module is accessible
        $modules = $course->modules;
        $currentModuleIndex = $modules->search(fn($m) => $m->id == $currentModule->id);

        if ($currentModuleIndex > 0) {
            // Get previous module
            $previousModule = $modules[$currentModuleIndex - 1];
            $previousQuiz = Quiz::where('module_id', $previousModule->id)->first();

            if ($previousQuiz) {
                $passedQuiz = QuizAttempt::where('quiz_id', $previousQuiz->id)
                    ->where('user_id', auth()->id())
                    ->where('passed', true)
                    ->exists();

                if (!$passedQuiz) {
                    abort(403, 'You must pass the quiz for the previous module to unlock this module.');
                }
            }
        }

        // Get quiz for the current module
        $quiz = Quiz::where('module_id', $currentModule->id)
            ->with(['questions'])
            ->firstOrFail();

        // Get previous quiz attempts for the user
        $previousAttempts = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get(['id', 'score', 'total_questions', 'percentage', 'passed', 'time_taken', 'completed_at']);

        // Format questions for JavaScript
        $questions = $quiz->questions->map(function ($question) {
            $decoded = is_string($question->options) ? json_decode($question->options, true) : $question->options;

            if (is_array($decoded) && isset($decoded[0]) && is_string($decoded[0])) {
                // Old structure: array of strings
                $options = collect($decoded)->map(function ($optionText) use ($question) {
                    $text = trim($optionText);
                    return [
                        'text' => $text,
                        'correct' => mb_strtolower($text) === mb_strtolower(trim($question->correct_answer ?? '')),
                        'explanation' => $question->explanation ?? '',
                    ];
                })->values()->toArray();
            } else {
                // New structure: array of assoc arrays with 'text', 'correct', 'explanation'
                $options = collect($decoded)->map(function ($option) use ($question) {
                    return [
                        'text' => trim($option['text'] ?? ''),
                        'correct' => (bool) ($option['correct'] ?? false),
                        'explanation' => $option['explanation'] ?? ($question->explanation ?? ''),
                    ];
                })->values()->toArray();
            }

            return [
                'question' => $question->question_text ?? $question->question ?? '',
                'explanation' => $question->explanation ?? '',
                'options' => $options,
            ];
        })->toArray();

        return view('user.courses.quiz', [
            'title' => 'My Learning - ' . $course->title . ' Quiz',
            'course' => $course,
            'enrollment' => $enrollment,
            'currentModule' => $currentModule,
            'quiz' => $quiz,
            'questions' => $questions,
            'previousAttempts' => $previousAttempts,
            'currentModuleIndex' => $currentModuleIndex,
        ]);
    }

    public function submitQuiz(Request $request, string $slug, string $module)
    {
        // Validate request
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'integer|min:0',
            'time_taken' => 'required|integer|min:0',
        ]);

        // Get Course and Module
        $course = Course::where('slug', $slug)->firstOrFail();
        $currentModule = Module::where('id', $module)
            ->where('course_id', $course->id)
            ->firstOrFail();

        // Get Quiz
        $quiz = Quiz::where('module_id', $currentModule->id)
            ->with(['questions'])
            ->firstOrFail();

        // Calculate the score and collect the correct answers
        $correctCount = 0;
        $totalPoints = 0;
        $answers = $request->input('answers');
        $correctAnswers = [];

        foreach ($quiz->questions as $index => $question) {
            $selectedOptionIndex = $answers[$index] ?? null;
            $totalPoints += $question->points;

            $options = json_decode($question->options, true);
            if (!is_array($options)) {
                $options = [];
            }

            $correctIndex = null;
            foreach ($options as $optIndex => $option) {
                if (is_array($option) && isset($option['correct']) && $option['correct'] === true) {
                    $correctIndex = $optIndex;
                    break;
                }
            }

            $correctAnswers[$index] = $correctIndex ?? -1;

            if (
                $selectedOptionIndex !== null &&
                isset($options[$selectedOptionIndex]) &&
                is_array($options[$selectedOptionIndex]) &&
                ($options[$selectedOptionIndex]['correct'] ?? false) === true
            ) {
                $correctCount += $question->points;
            }
        }

        $percentage = $totalPoints > 0 ? round(($correctCount / $totalPoints) * 100, 2) : 0;
        $passed = $percentage >= $quiz->pass_percentage;

        // Store quiz attempt
        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => auth()->id(),
            'score' => $correctCount,
            'total_questions' => $quiz->question_count,
            'percentage' => $percentage,
            'passed' => $passed,
            'time_taken' => $request->input('time_taken'),
            'answers' => json_encode($answers),
            'completed_at' => now(),
        ]);

        // 1. Get the next module
        $nextModule = Module::where('course_id', $course->id)
            ->where('id', '>', $currentModule->id)
            ->orderBy('id', 'asc')
            ->first();

        $enrollment = CourseEnrollment::where('module_id', $module)
            ->where('course_id', $course->id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // 2. Update progress bar
        $totalModules = Module::where('course_id', $course->id)->count();
        $completedModules = $enrollment->lessons_completed;

        // increment if not already at max
        if ($completedModules < $totalModules) {
            $completedModules++;
        }

        $progress = round(($completedModules / $totalModules) * 100, 2);

        // 3. Check if the course is fully completed
        $status = $completedModules >= $totalModules ? 'completed' : 'running';

        // 4. Update enrollment
        $enrollment->update([
            'lessons_completed' => $completedModules,
            'progress' => $progress,
            'status' => $status,
            'module_id' => $nextModule?->id,
        ]);

        return response()->json([
            'success' => true,
            'score' => $correctCount,
            'total_points' => $totalPoints,
            'total_questions' => $quiz->question_count,
            'percentage' => $percentage,
            'passed' => $passed,
            'attempt_id' => $attempt->id,
            'correct_answers' => $correctAnswers,
            'time_taken' => $request->input('time_taken')
        ]);
    }
}
