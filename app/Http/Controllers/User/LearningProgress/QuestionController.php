<?php

namespace App\Http\Controllers\User\LearningProgress;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Like;
use App\Models\Question;
use App\Models\QuestionReply;
use App\Notifications\InstructorQuestionNotification;
use App\Notifications\QuestionLikedNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
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
            ->with(['user', 'module', 'replies.user', 'likes'])
            ->withCount(['likes as likes_count' => function($query) {
                $query->where('is_like', true);
            }])
            ->withCount(['likes as dislikes_count' => function($query) {
                $query->where('is_like', false);
            }]);

        if ($module_id = $request->input('module_id')) {
            $query->where('module_id', $module_id);
        }

        if ($search = $request->input('search')) {
            $query->where(fn($q) => $q->where('title', 'like', "%$search%")
                ->orWhere('content', 'like', "%$search%"));
        }

        $sort = $request->sort;
        if ($sort == 'helpful') {
            $query->withCount('replies')
                ->orderByDesc('likes_count')
                ->orderByDesc('replies_count');
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
        $course = $course->load('profile.user');
        // Validate request
        $validator = Validator::make($request->all(), [
            'module_id' => 'required|exists:modules,id,course_id,' . $course->id,
            'title' => 'required|string|max:255',
            'question' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'error'
            ], 422);
        }

        $question = Question::create([
            'course_id' => $course->id,
            'module_id' => $request->module_id,
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->question,
        ]);

        // Notify instructor
        $instructor = $course->profile?->user;
        if ($instructor) {
            Notification::send($instructor, new InstructorQuestionNotification($question));
        }

        return response()->json([
            'question' => [
                'id' => $question->id,
                'title' => $question->title,
                'content' => $question->content,
                'user' => [
                    'id' => $question->user->id,
                    'name' => $question->user->name,
                    'profile_photo_path' => $question->user->profile && $question->user->profile_photo_path
                        ? asset($question->user->profile?->profile_photo_path)
                        : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($question->user->name ?? 'N', 0, 1),
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
        // Auth user
        $user = Auth::user();

        if ($question->user_id != $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'question' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'error'
            ], 422);
        }

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
                    'profile_photo_path' => $question->user->profile && $question->user->profile_photo_path ? asset($question->user->profile?->profile_photo_path) : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($question->user->name ?? 'N', 0, 1),
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
        // Auth user
        $user = Auth::user();

        if ($question->user_id != $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $question->delete();
        return response()->json(['message' => 'Question deleted']);
    }

    public function toggleLike(Request $request): JsonResponse
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:question,reply',
            'id' => 'required|integer',
            'action' => 'required|in:like,dislike'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'error'
            ], 422);
        }

        $modelClass = $request->type === 'question' ? Question::class : QuestionReply::class;
        $item = $modelClass::findOrFail($request->id);

        $user = auth()->user();
        $isLike = $request->action === 'like';

        // Find existing like/dislike
        $existingLike = Like::where([
            'user_id' => $user->id,
            'likeable_type' => get_class($item),
            'likeable_id' => $item->id
        ])->first();

        if ($existingLike) {
            // If clicking the same action, remove the vote
            if ($existingLike->is_like === $isLike) {
                $existingLike->delete();
                $status = 'removed';
            } else {
                // Switch between like and dislike
                $existingLike->update(['is_like' => $isLike]);
                $status = $isLike ? 'liked' : 'disliked';
            }
        } else {
            // Create new like/dislike
            Like::create([
                'user_id' => $user->id,
                'likeable_type' => get_class($item),
                'likeable_id' => $item->id,
                'is_like' => $isLike
            ]);
            $status = $isLike ? 'liked' : 'disliked';
        }

        // Send notification to a question owner
        if ($request->type === 'question' && $status !== 'removed') {
            $question = $item;
            $questionOwner = $question->user;
            if ($questionOwner && $questionOwner->id !== $user->id) {
                Notification::send($questionOwner, new QuestionLikedNotification($question, $isLike, $user->name));
            }
        }

        // Refresh the item to get updated counts
        $item->refresh();

        // Calculate user like status
        $userLike = Like::where([
            'user_id' => auth()->id(),
            'likeable_type' => get_class($item),
            'likeable_id' => $item->id
        ])->first();

        $userLikeStatus = null;
        if ($userLike) {
            $userLikeStatus = $userLike->is_like ? 'liked' : 'disliked';
        }

        // Get fresh counts
        $likesCount = $item->likes()->where('is_like', true)->count();
        $dislikesCount = $item->likes()->where('is_like', false)->count();

        return response()->json([
            'success' => true,
            'status' => $status,
            'likes_count' => $likesCount,
            'dislikes_count' => $dislikesCount,
            'user_status' => $userLikeStatus
        ]);
    }
}
