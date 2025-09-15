<?php

namespace App\Http\Controllers\User\LearningProgress;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseEnrollment;
use App\Models\Note;
use App\Models\Question;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class LearningController extends Controller
{
    /**
     * @throws Throwable
     */
    public function myCoursesPurchases(Request $request)
    {
        $user_id = Auth::id();
        $title = 'My Purchases';

        // Base query for recently enrolled courses
        $query = CourseEnrollment::with([
            'course' => fn($query) => $query->with(['profile.user', 'category', 'media'])->withCount('modules'),
        ])
            ->where('user_id', $user_id)
            ->whereNull('last_accessed');

        // Apply filters
        $this->applyCourseFilters($query, $request);

        // Paginate results
        $courses = $query->orderBy('title')->latest()->paginate(6)->withQueryString();

        // Fetch categories
        $categories = CourseCategory::select(['id', 'name'])
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        // My learning courses (accessed within the last 48 hours)
        $myLearning = CourseEnrollment::with([
            'course' => fn($query) => $query->with(['profile.user', 'category', 'media'])->withCount('modules'),
        ])
            ->where('user_id', $user_id)
            ->whereNotNull('last_accessed')
            ->where('last_accessed', '>=', now()->subHours(48))
            ->where('status', 'running')
            ->orderByDesc('last_accessed')
            ->paginate(3);

        // Calculate metrics
        $metrics = [
            'total_course_count' => CourseEnrollment::where('user_id', $user_id)->count(),
            'active_course_count' => CourseEnrollment::where('user_id', $user_id)->whereNotNull('last_accessed')->count(),
            'completed_course_count' => CourseEnrollment::where('user_id', $user_id)->where('status', 'completed')->count(),
        ];

        if ($request->ajax()) {
            return response()->json([
                'html' => view('user.courses.purchases-list', compact('courses'))->render(),
                'pagination' => $courses->links('vendor.pagination.tailwind')->render(),
            ]);
        }

        return view('user.courses.purchases', compact('title', 'courses', 'categories', 'myLearning', 'metrics'));
    }

    /**
     * @throws Throwable
     */
    public function myLearning(Request $request)
    {
        $user_id = Auth::id();
        $title = 'My Learning';

        // Base query for running courses
        $query = CourseEnrollment::with([
            'course' => fn($query) => $query->with(['profile.user', 'category', 'media'])->withCount('modules'),
        ])
            ->where('user_id', $user_id)
            ->whereNotNull('last_accessed');

        // Apply filters
        $this->applyCourseFilters($query, $request);

        // Paginate results
        $courses = $query->orderByDesc('last_accessed')->paginate(6)->withQueryString();

        // Fetch categories
        $categories = CourseCategory::select(['id', 'name'])
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('user.courses.purchases-list', compact('courses'))->render(),
                'pagination' => $courses->links('vendor.pagination.tailwind')->render(),
            ]);
        }

        return view('user.courses.my-learning', compact('title', 'courses', 'categories'));
    }

    /**
     * @throws Throwable
     */
    public function watch(Request $request, Course $course, $module)
    {
        if (!is_numeric($module)) {
            abort(400, 'Invalid module ID.');
        }

        $course->load([
            'modules' => fn($query) => $query->with('quizzes', 'resources')->withCount('resources'),
            'category',
            'profile.user',
            'media',
            'enrollments' => fn($query) => $query->where('user_id', Auth::id()),
        ]);

        $enrollment = $course->enrollments->first() ?? abort(403, 'You are not enrolled in this course.');

        $currentModule = $course->modules()->where('id', $module)->firstOrFail();

        // Check module accessibility
        $passedQuizzes = QuizAttempt::where('user_id', Auth::id())
            ->where('passed', true)
            ->pluck('quiz_id')
            ->toArray();

        $currentModuleIndex = $course->modules->search(fn($m) => $m->id == $currentModule->id);

        $allPreviousPassed = $currentModuleIndex === 0 || $course->modules
                ->take($currentModuleIndex)
                ->every(fn($m) => $m->quizzes->isEmpty() || in_array($m->quizzes->first()->id, $passedQuizzes));

        $isCompleted = $currentModule->quizzes->isNotEmpty() && in_array($currentModule->quizzes->first()->id, $passedQuizzes);

        if ($currentModuleIndex > 0 && !$isCompleted && !$allPreviousPassed) {
            abort(403, 'You must pass the quizzes for all previous modules to unlock this module.');
        }

        // Update enrollment
        $enrollment->update([
            'last_accessed' => now(),
            'module_id' => $currentModule->id,
        ]);

        // Extract YouTube video ID
        $videoUrl = $currentModule->video_url ?? 'https://www.youtube.com/watch?v=CpPT2hHnZls';
        preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=))([\w-]{10,12})/i', $videoUrl, $matches);
        $videoId = $matches[1] ?? 'CpPT2hHnZls';

        // Load questions with filtering and sorting
        $query = Question::where('course_id', $course->id)
            ->with(['user', 'module', 'replies.user']);

        if ($module_id = $request->query('module_id')) {
            $query->where('module_id', $module_id);
        }

        if ($search = $request->query('search')) {
            $query->where(fn($q) => $q->where('title', 'like', "%$search%")
                ->orWhere('content', 'like', "%$search%"));
        }

        $sort = $request->query('sort', 'recent');
        if ($sort == 'helpful') {
            $query->withCount('replies')->orderByDesc('replies_count');
        } elseif ($sort == 'unanswered') {
            $query->doesntHave('replies');
        } else {
            $query->orderByDesc('created_at');
        }

        $questions = $query->paginate(2);

        // Load notes
        $notes = Note::where('course_id', $course->id)
            ->where('user_id', Auth::id())
            ->with('module')
            ->orderByDesc('created_at')
            ->get();

        // Handle AJAX request for a specific question
        if ($request->ajax() && $request->query('question_id')) {
            $question = Question::with(['user.profile', 'module', 'replies.user'])
                ->findOrFail($request->query('question_id'));

            return response()->json([
                'question' => [
                    'id' => $question->id,
                    'title' => $question->title,
                    'content' => $question->content,
                    'user' => [
                        'id' => $question->user->id,
                        'name' => $question->user->name,
                        'profile_photo_path' => $question->user->profile && $question->user->profile_photo_path ? asset($question->user->profile->profile_photo_path) : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($question->user->name ?? 'N', 0, 1),
                    ],
                    'created_at_diff' => $question->created_at->diffForHumans(),
                    'module' => [
                        'title' => $question->module->title,
                    ],
                    'replies_count' => $question->replies->count(),
                ],
                'replies' => $question->replies->map(function ($reply) {
                    return [
                        'id' => $reply->id,
                        'content' => $reply->content,
                        'user' => [
                            'id' => $reply->user->id,
                            'name' => $reply->user->name,
                            'profile_photo_path' => $reply->user->profile && $reply->user->profile_photo_path ? asset($reply->user->profile->profile_photo_path) : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($reply->user->name ?? 'N', 0, 1),
                        ],
                        'created_at_diff' => $reply->created_at->diffForHumans(),
                        'is_instructor' => $reply->is_instructor ?? false,
                    ];
                })->toArray(),
            ]);
        }

        // Handle AJAX request for a question list
        if ($request->ajax()) {
            return response()->json([
                'questions_html' => view('user.courses.watch.navigation.questions', compact('questions'))->render(),
                'pagination_html' => $questions->links()->toHtml(),
                'total' => $questions->total(),
            ]);
        }

        // Load Original Question for non-AJAX requests
        $question = $request->query('question_id')
            ? Question::with(['replies', 'user.profile'])->findOrFail($request->query('question_id'))
            : null;

        return view('user.courses.course-watch', [
            'title' => $course->title,
            'course' => $course,
            'course_outcomes' => $course->outcomes,
            'progress' => $enrollment->progress,
            'lessons_completed' => $enrollment->lessons_completed,
            'youtube_id' => $videoId,
            'current_module_id' => $currentModule->id,
            'enrollment' => $enrollment,
            'course_modules' => $course->modules,
            'passedQuizzes' => $passedQuizzes,
            'notes' => $notes,
            'questions' => $questions,
            'question' => $question,
        ]);
    }

    private function applyCourseFilters($query, Request $request)
    {
        if ($search = trim($request->input('search'))) {
            $query->whereHas('course', fn($q) => $q->where('title', 'like', "%$search%")
                ->orWhereHas('category', fn($q) => $q->where('name', 'like', "%$search%")));
        }

        if ($category = trim($request->input('category'))) {
            $query->whereHas('course.category', fn($q) => $q->where('name', $category));
        }
    }
}
