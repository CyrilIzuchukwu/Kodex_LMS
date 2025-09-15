<?php

namespace App\Http\Controllers\User\LearningProgress;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\QuestionReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionReplyController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id,course_id,' . $course->id,
            'reply' => 'required|string',
        ]);

        $reply = QuestionReply::create([
            'question_id' => $request->question_id,
            'user_id' => Auth::id(),
            'content' => $request->reply,
            'is_instructor' => Auth::user()->role === 'instructor',
        ]);

        return response()->json([
            'reply' => [
                'id' => $reply->id,
                'content' => $reply->content,
                'user' => [
                    'id' => $reply->user->id,
                    'name' => $reply->user->name,
                    'profile_photo_path' => $reply->user->profile && $reply->user->profile_photo_path ? asset($reply->user->profile->profile_photo_path) : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($reply->user->name ?? 'N', 0, 1),
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

        $request->validate([
            'reply' => 'required|string',
        ]);

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
                    'profile_photo_path' => $reply->user->profile && $reply->user->profile_photo_path ? asset($reply->user->profile->profile_photo_path) : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($reply->user->name ?? 'N', 0, 1),
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
