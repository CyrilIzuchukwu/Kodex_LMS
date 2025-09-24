<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\User;
use App\Notifications\QuizCreatedNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ManageInstructorCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        // Load relationships in one query
        $course = Course::with(['modules.resources', 'modules.quizzes'])
            ->findOrFail($course->id);

        // Get all enrollments for the instructor's course
        $courseEnrollments = CourseEnrollment::where('course_id', $course->id)->get();

        // Calculate counts for each module
        $course->modules_count = $course->modules->count();
        $course->students_count = $courseEnrollments->count();

        // Calculate resources, quizzes, and enrolled students for each module
        $course->modules->each(function ($module) {
            $module->resources_count = $module->resources->count();
            $module->quiz_count = $module->quizzes->count();
            $module->students_count = CourseEnrollment::where('module_id', $module->id)->count();
        });

        return view('instructor.courses.index', [
            'title' => 'Course List',
            'course' => $course,
            'modules' => $course->modules,
        ]);
    }

    public function create(Module $module)
    {
        // Load the course and quizzes with their attempts in one query to optimize
        $module = $module->load(['course', 'quizzes.attempts']);

        return view('instructor.courses.quiz', [
            'title' => 'Quiz List - ' . $module->title,
            'course' => $module->course,
            'module' => $module
        ]);
    }

    public function edit(Quiz $quiz)
    {
        $quiz = $quiz->load(['course', 'module', 'questions']);
        return view('instructor.courses.edit-quiz', [
            'title' => 'Edit Quiz - ' . $quiz->module->title,
            'quiz' => $quiz,
            'module' => $quiz->module,
            'questions' => $quiz->questions
        ]);
    }

    public function store(Request $request, Course $course, Module $module)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'nullable|integer|min:1|max:180',
            'pass_percentage' => 'required|integer|min:0|max:100',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.options' => 'required|array|min:2|max:4',
            'questions.*.options.*' => 'required|string',
            'questions.*.correct' => 'required|string|in_array:questions.*.options.*',
            'questions.*.explanation' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Check if a quiz already exists for this course and module
        if (Quiz::where('course_id', $course->id)->where('module_id', $module->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'A quiz already exists for this course and module.',
            ], 422);
        }

        // Create the quiz
        $quiz = Quiz::create([
            'course_id' => $course->id,
            'module_id' => $module->id,
            'title' => $request->title,
            'description' => $request->description,
            'question_count' => count($request->questions),
            'pass_percentage' => $request->pass_percentage,
            'time_limit' => $request->time_limit,
        ]);

        // Create questions
        foreach ($request->questions as $questionData) {
            // Prepare options as JSON
            $options = array_map(function ($optionText) use ($questionData) {
                return [
                    'text' => $optionText,
                    'correct' => $optionText === $questionData['correct'],
                    'explanation' => '',
                ];
            }, $questionData['options'], array_keys($questionData['options']));

            QuizQuestion::create([
                'quiz_id' => $quiz->id,
                'question_text' => $questionData['text'],
                'options' => json_encode($options),
                'correct_answer' => $questionData['correct'],
                'explanation' => $questionData['explanation'] ? trim($questionData['explanation']) : 'No explanation provided.',
                'points' => 1,
            ]);
        }

        // Notify enrolled users
        $enrolledUsers = User::whereIn('id', function ($query) use ($course) {
            $query->select('user_id')
                ->from('course_enrollments')
                ->where('course_id', $course->id);
        })->get();

        Notification::send($enrolledUsers, new QuizCreatedNotification($quiz));

        return response()->json([
            'success' => true,
            'message' => 'Quiz created successfully.',
        ]);
    }

    /**
     * @throws Throwable
     */
    public function update(Request $request, Quiz $quiz)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'nullable|integer|min:1|max:180',
            'pass_percentage' => 'required|integer|min:0|max:100',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.options' => 'required|array|min:2|max:4',
            'questions.*.options.*' => 'required|string',
            'questions.*.correct' => 'required|string|in_array:questions.*.options.*',
            'questions.*.explanation' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {

            // Start database transaction
            DB::beginTransaction();

            // Update the quiz
            $quiz->update([
                'title' => $request->title,
                'description' => $request->description,
                'question_count' => count($request->questions),
                'pass_percentage' => $request->pass_percentage,
                'time_limit' => $request->time_limit,
            ]);

            // Delete existing questions
            $quiz->questions()->delete();

            // Create new questions
            foreach ($request->questions as $questionData) {
                // Prepare options as JSON
                $options = array_map(function ($optionText) use ($questionData) {
                    return [
                        'text' => $optionText,
                        'correct' => $optionText === $questionData['correct'],
                        'explanation' => '',
                    ];
                }, $questionData['options'], array_keys($questionData['options']));

                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $questionData['text'],
                    'options' => json_encode($options),
                    'correct_answer' => $questionData['correct'],
                    'explanation' => $questionData['explanation'] ? trim($questionData['explanation']) : 'No explanation provided.',
                    'points' => 1,
                ]);
            }

            // Commit the transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Quiz updated successfully.',
            ]);

        } catch (Exception $e) {
            // Rollback the transaction on error
            DB::rollback();
            Log::error('Failed to update quiz: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the quiz. Please try again.',
            ], 500);
        }
    }

    public function destroy(Quiz $quiz)
    {
        try {

            // Check if the quiz has any attempts
            if ($quiz->attempts()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete quiz because it has associated attempts.'
                ], 403);
            }

            // Delete the quiz
            $quiz->delete();

            return response()->json([
                'success' => true,
                'message' => 'Quiz deleted successfully.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete quiz: ' . $e->getMessage()
            ], 500);
        }
    }
}
