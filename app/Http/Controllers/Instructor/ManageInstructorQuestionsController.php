<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Like;
use App\Models\Question;
use App\Models\QuestionReply;
use App\Notifications\QuestionLikedNotification;
use App\Notifications\QuestionReplyNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ManageInstructorQuestionsController extends Controller
{
    /**
     * @throws Throwable
     */
    public function index(Request $request, Course $course)
    {
        $instructor = Auth::user();

        // Get all enrollments for the instructor's course
        $courseEnrollments = CourseEnrollment::where('course_id', $course->id)->get();

        // Calculate counts for each module
        $course->modules_count = $course->modules->count();
        $course->students_count = $courseEnrollments->count();

        // Load questions with filtering and sorting
        $query = Question::where('course_id', $instructor->profile?->course_id)
            ->with(['user', 'module', 'replies.user', 'likes'])
            ->withCount(['likes as likes_count' => function($query) {
                $query->where('is_like', true);
            }])
            ->withCount(['likes as dislikes_count' => function($query) {
                $query->where('is_like', false);
            }]);

        if ($module_id = $request->query('module_id')) {
            $query->where('module_id', $module_id);
        }

        if ($search = $request->query('search')) {
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

        // Handle AJAX request for a specific question
        if ($request->ajax() && $request->query('question_id')) {
            $question = Question::with([
                'user.profile',
                'module',
                'replies' => function($query) {
                    $query->with('user')
                        ->withCount([
                            'likes as likes_count' => function($q) { $q->where('is_like', true); },
                            'likes as dislikes_count' => function($q) { $q->where('is_like', false); }
                        ]);
                },
                'likes'
            ])
                ->withCount([
                    'likes as likes_count' => function($query) { $query->where('is_like', true); },
                    'likes as dislikes_count' => function($query) { $query->where('is_like', false); }
                ])
                ->findOrFail($request->query('question_id'));

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
                ],
                'replies' => $question->replies->map(function ($reply) {
                    // Add user like status calculation
                    $userLike = $reply->likes->where('user_id', auth()->id())->first();
                    $userLikeStatus = null;
                    if ($userLike) {
                        $userLikeStatus = $userLike->is_like ? 'liked' : 'disliked';
                    }

                    return [
                        'id' => $reply->id,
                        'content' => $reply->content,
                        'user' => [
                            'id' => $reply->user->id,
                            'name' => $reply->user->name,
                            'profile_photo_path' => $reply->user->profile && $reply->user->profile_photo_path ? asset($reply->user->profile?->profile_photo_path) : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($reply->user->name ?? 'N', 0, 1),
                        ],
                        'created_at_diff' => $reply->created_at->diffForHumans(),
                        'is_instructor' => $reply->is_instructor ?? false,
                        'likes_count' => $reply->likes()->where('is_like', true)->count(),
                        'dislikes_count' => $reply->likes()->where('is_like', false)->count(),
                        'user_like_status' => $userLikeStatus,
                    ];
                })->toArray(),
            ]);
        }

        // Handle AJAX request for a question list
        if ($request->ajax()) {
            return response()->json([
                'questions_html' => view('instructor.questions.questions-list', compact('questions'))->render(),
                'pagination_html' => $questions->links()->toHtml(),
                'total' => $questions->total(),
            ]);
        }

        // Load Original Question for non-AJAX requests
        $question = $request->query('question_id')
            ? Question::with([
                'replies' => function($query) {
                    $query->with('user.profile')
                        ->withCount([
                            'likes as likes_count' => function($q) { $q->where('is_like', true); },
                            'likes as dislikes_count' => function($q) { $q->where('is_like', false); }
                        ]);
                },
                'user.profile'
            ])->findOrFail($request->query('question_id'))
            : null;

        if ($question) {
            $question->replies->each(function($reply) {
                $userLike = $reply->likes()->where('user_id', auth()->id())->first();
                $reply->user_like_status = $userLike ? ($userLike->is_like ? 'liked' : 'disliked') : null;
            });
        }

        return view('instructor.questions.index', [
            'title' => 'Questions & Answers',
            'course' => $course,
            'questions' => $questions,
            'question' => $question,
        ]);
    }

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
            'questions_html' => view('instructor.questions.questions-list', compact('questions'))->render(),
            'pagination_html' => $questions->links()->toHtml(),
            'total' => $questions->total(),
        ]);
    }

    public function toggleLike(Request $request): JsonResponse
    {
        // validate request
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

    public function store(Request $request, Course $course)
    {
        $user = Auth::user();

        // validate request
        $validator = Validator::make($request->all(), [
            'question_id' => 'required|exists:questions,id,course_id,' . $course->id,
            'reply' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'error'
            ], 422);
        }

        $reply = QuestionReply::create([
            'question_id' => $request->question_id,
            'user_id' => Auth::id(),
            'content' => $request->reply,
            'is_instructor' => Auth::user()->role === 'instructor',
        ]);

        // Notify the question's author if they are not the one replying
        $question = $reply->question;
        if ($question->user_id != $user->id) {
            Notification::send($question->user, new QuestionReplyNotification($reply));
        }

        return response()->json([
            'reply' => [
                'id' => $reply->id,
                'content' => $reply->content,
                'user' => [
                    'id' => $reply->user->id,
                    'name' => $reply->user->name,
                    'profile_photo_path' => $reply->user->profile && $reply->user->profile_photo_path ? asset($reply->user->profile?->profile_photo_path) : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($reply->user->name ?? 'N', 0, 1),
                ],
                'created_at_diff' => $reply->created_at->diffForHumans(),
                'is_instructor' => $reply->is_instructor ?? false,
            ]
        ]);
    }

    public function update(Request $request, QuestionReply $reply)
    {
        $user = Auth::user();
        if ($reply->user_id != $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // validate request
        $validator = Validator::make($request->all(), [
            'reply' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'error'
            ], 422);
        }

        $reply->update([
            'content' => $request->reply,
        ]);

        return response()->json([
            'reply' => [
                'id' => $reply->id,
                'content' => $reply->content,
                'user' => [
                    'id' => $reply->user->id,
                    'name' => $reply->user->name,
                    'profile_photo_path' => $reply->user->profile && $reply->user->profile_photo_path ? asset($reply->user->profile?->profile_photo_path) : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($reply->user->name ?? 'N', 0, 1),
                ],
                'created_at_diff' => $reply->created_at->diffForHumans(),
                'is_instructor' => $reply->is_instructor ?? false,
            ]
        ]);
    }

    public function destroy(QuestionReply $reply)
    {
        if ($reply->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $reply->delete();
        return response()->json(['message' => 'Question Reply deleted']);
    }
}
