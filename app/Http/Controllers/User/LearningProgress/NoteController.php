<?php

namespace App\Http\Controllers\User\LearningProgress;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function store(Request $request, Course $course)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'module_id' => 'required|exists:modules,id,course_id,' . $course->id,
            'title' => 'nullable|string|max:255',
            'note' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'error'
            ], 422);
        }

        $note = Note::create([
            'course_id' => $course->id,
            'module_id' => $request->module_id,
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->note,
        ]);

        return response()->json([
            'note' => [
                'id' => $note->id,
                'title' => $note->title,
                'content' => $note->content,
                'module' => [
                    'title' => $note->module->title,
                ],
                'created_at_diff' => $note->created_at->diffForHumans()
            ]
        ]);
    }

    public function update(Request $request, Note $note)
    {
        $user = Auth::user();
        if ($note->user_id != $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'note' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'error'
            ], 422);
        }

        $note->update([
            'title' => $request->title,
            'content' => $request->note,
        ]);

        return response()->json([
            'note' => [
                'id' => $note->id,
                'title' => $note->title,
                'content' => $note->content,
                'module' => [
                    'title' => $note->module->title,
                ],
                'created_at_diff' => $note->created_at->diffForHumans()
            ]
        ]);
    }

    public function destroy(Note $note)
    {
        $user = Auth::user();

        if ($note->user_id != $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $note->delete();
        return response()->json(['message' => 'Note deleted']);
    }
}
