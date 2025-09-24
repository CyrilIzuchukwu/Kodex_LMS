<?php

namespace App\Http\Controllers\User\LearningProgress;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use App\Notifications\QuizPassed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    public function courseQuiz(Course $course, $module)
    {
        $currentModule = Module::where('id', $module)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $enrollment = CourseEnrollment::where('course_id', $course->id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $course->load([
            'category',
            'profile.user',
            'media',
            'enrollments' => fn($query) => $query->where('user_id', Auth::id()),
        ])->withCount('modules');

        // Check module accessibility
        $modules = $course->modules;
        $currentModuleIndex = $modules->search(fn($m) => $m->id == $currentModule->id);

        if ($currentModuleIndex > 0) {
            $previousModule = $modules[$currentModuleIndex - 1];
            $previousQuiz = Quiz::where('module_id', $previousModule->id)->first();

            if ($previousQuiz && !QuizAttempt::where('quiz_id', $previousQuiz->id)
                    ->where('user_id', Auth::id())
                    ->where('passed', true)
                    ->exists()) {
                abort(403, 'You must pass the quiz for the previous module to unlock this module.');
            }
        }

        $quiz = Quiz::where('module_id', $currentModule->id)
            ->with('questions')
            ->firstOrFail();

        $previousAttempts = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get(['id', 'score', 'total_questions', 'percentage', 'passed', 'time_taken', 'completed_at']);

        $questions = $quiz->questions->map(function ($question) {
            $decoded = is_string($question->options) ? json_decode($question->options, true) : $question->options;

            if (is_array($decoded) && isset($decoded[0]) && is_string($decoded[0])) {
                $options = collect($decoded)->map(function ($optionText) use ($question) {
                    $text = trim($optionText);
                    return [
                        'text' => $text,
                        'correct' => mb_strtolower($text) === mb_strtolower(trim($question->correct_answer ?? '')),
                        'explanation' => $question->explanation ?? '',
                    ];
                })->values()->toArray();
            } else {
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
            'title' => "My Learning - $course->title Quiz",
            'course' => $course,
            'enrollment' => $enrollment,
            'currentModule' => $currentModule,
            'quiz' => $quiz,
            'questions' => $questions,
            'previousAttempts' => $previousAttempts,
            'currentModuleIndex' => $currentModuleIndex,
        ]);
    }

    public function submitQuiz(Request $request, Course $course, $module)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'answers' => 'required|array',
            'answers.*' => 'integer|min:0',
            'time_taken' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'error'
            ], 422);
        }

        $currentModule = Module::where('id', $module)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $quiz = Quiz::where('module_id', $currentModule->id)
            ->with('questions')
            ->firstOrFail();

        $correctCount = 0;
        $totalPoints = 0;
        $answers = $request->input('answers');
        $correctAnswers = [];

        foreach ($quiz->questions as $index => $question) {
            $selectedOptionIndex = $answers[$index] ?? null;
            $totalPoints += $question->points;

            $options = json_decode($question->options, true) ?? [];
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

        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => Auth::id(),
            'score' => $correctCount,
            'total_questions' => $quiz->question_count,
            'percentage' => $percentage,
            'passed' => $passed,
            'time_taken' => $request->input('time_taken'),
            'answers' => json_encode($answers),
            'completed_at' => now(),
        ]);

        $enrollment = CourseEnrollment::where('module_id', $module)
            ->where('course_id', $course->id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($passed) {
            $nextModule = Module::where('course_id', $course->id)
                ->where('id', '>', $currentModule->id)
                ->orderBy('id')
                ->first();

            $totalModules = Module::where('course_id', $course->id)->count();
            $completedModules = $enrollment->lessons_completed + 1;
            $progress = round(($completedModules / $totalModules) * 100, 2);
            $status = $completedModules >= $totalModules ? 'completed' : 'running';

            $enrollment->update([
                'lessons_completed' => $completedModules,
                'progress' => $progress,
                'status' => $status,
                'module_id' => $nextModule?->id ?? $currentModule?->id,
            ]);

            // Notify user
            Notification::send(User::where('id', Auth::id())->get(), new QuizPassed($attempt));
        }

        return response()->json([
            'success' => true,
            'score' => $correctCount,
            'total_points' => $totalPoints,
            'total_questions' => $quiz->question_count,
            'percentage' => $percentage,
            'passed' => $passed,
            'attempt_id' => $attempt->id,
            'correct_answers' => $correctAnswers,
            'time_taken' => $request->input('time_taken'),
        ]);
    }
}
