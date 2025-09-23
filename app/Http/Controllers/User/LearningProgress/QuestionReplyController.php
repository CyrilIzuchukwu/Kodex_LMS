<?php

namespace App\Http\Controllers\User\LearningProgress;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\QuestionReply;
use App\Notifications\QuestionReplyNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class QuestionReplyController extends Controller
{
    public function store(Request $request, Course $course)
    {
        // Validate request
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
        if ($question->user_id !== Auth::id()) {
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
        if ($reply->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate request
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
