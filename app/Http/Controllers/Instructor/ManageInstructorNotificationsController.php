<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageInstructorNotificationsController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->notifications();

        if ($request->filter === 'unread') {
            $query->whereNull('read_at');
        } elseif ($request->filter) {
            switch ($request->filter) {
                case 'student':
                    $query->where(function ($q) {
                        $q->whereJsonContains('data->type', 'student_enrollment')
                            ->orWhereJsonContains('data->type', 'quiz_submission')
                            ->orWhereJsonContains('data->type', 'question_asked');
                    });
                    break;
                case 'course':
                    $query->where(function ($q) {
                        $q->whereJsonContains('data->type', 'course_update')
                            ->orWhereJsonContains('data->type', 'course_purchase');
                    });
                    break;
                case 'system':
                    $query->whereJsonContains('data->type', 'system_update');
                    break;
                default:
                    break;
            }
        }

        $notifications = $query->latest()->paginate(5);

        return view('instructor.notifications.index', [
            'title' => 'Notifications',
            'notifications' => $notifications,
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->route('instructor.notifications.index')
            ->with('success', 'All notifications marked as read.');
    }

    /**
     * Mark a single notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Delete all notifications for the authenticated user.
     */
    public function deleteAll()
    {
        Auth::user()->notifications()->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Delete a single notification.
     */
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();

        return response()->json(['success' => true]);
    }
}
