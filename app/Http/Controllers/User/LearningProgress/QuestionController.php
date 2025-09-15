<?php

namespace App\Http\Controllers\User\LearningProgress;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class QuestionController extends Controller
{
    /**
     * @throws Throwable
     */
    public function fetchQuestions(Request $request, Course $course)
    {
        sleep(1);
        $query = Question::where('course_id', $course->id)
            ->with(['user', 'module', 'replies.user']);

        if ($module_id = $request->input('module_id')) {
            $query->where('module_id', $module_id);
        }

        if ($search = $request->input('search')) {
            $query->where(fn($q) => $q->where('title', 'like', "%$search%")
                ->orWhere('content', 'like', "%$search%"));
        }

        $sort = $request->input('sort', 'recent');
        if ($sort == 'helpful') {
            $query->withCount('replies')->orderByDesc('replies_count');
        } elseif ($sort == 'unanswered') {
            $query->doesntHave('replies');
        } else {
            $query->orderByDesc('created_at');
        }

        $questions = $query->paginate(2);

        return response()->json([
            'questions_html' => view('user.courses.watch.navigation.questions', compact('questions'))->render(),
            'pagination_html' => $questions->links()->toHtml(),
            'total' => $questions->total(),
        ]);
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id,course_id,' . $course->id,
            'title' => 'required|string|max:255',
            'question' => 'required|string',
        ]);

        $question = Question::create([
            'course_id' => $course->id,
            'module_id' => $request->module_id,
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->question,
        ]);

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
            ]
        ]);
    }

    public function update(Request $request, Question $question)
    {
        if ($question->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'question' => 'required|string',
        ]);

        $question->update([
            'title' => $request->title,
            'content' => $request->question,
        ]);

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
            ]
        ]);
    }

    public function destroy(Question $question)
    {
        if ($question->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $question->delete();
        return response()->json(['message' => 'Question deleted']);
    }
}
