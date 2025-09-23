<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcements;
use App\Models\Course;
use App\Models\User;
use App\Notifications\NewAnnouncement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class ManageAnnouncementsController extends Controller
{
    public function index()
    {
        $announcements = Announcements::latest()->paginate(10);
        return view('admin.announcements.index', [
            'title' => 'Announcements',
            'announcements' => $announcements
        ]);
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.announcements.create', [
            'title' => 'Create Announcements',
            'courses' => $courses
        ]);
    }

    /**
     * Store a newly created announcement in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target' => 'required|in:all,students,instructors,specific_courses',
            'courses' => 'required_if:target,specific_courses|array',
            'courses.*' => 'exists:courses,id',
            'attachment' => 'nullable|file|mimes:jpeg,png,pdf|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proceed with validated data
        $validated = $validator->validated();

        // Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('announcements', 'public');
        }

        // Create the announcement
        $announcement = Announcements::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'target' => $validated['target'],
            'attachment' => $attachmentPath,
            'created_by' => auth()->id(),
        ]);

        // Attach courses if target is specific_courses
        if ($request->target === 'specific_courses') {
            $announcement->courses()->attach($request->courses);
        }

        // Determine recipients and send notifications
        $users = $this->getRecipients($announcement);
        Notification::send($users, new NewAnnouncement($announcement));

        return redirect()->back()->with('success', 'Announcement created successfully.');
    }

    /**
     * Get the recipients for the announcement notification.
     */
    protected function getRecipients(Announcements $announcement)
    {
        if ($announcement->target === 'all') {
            return User::all();
        } elseif ($announcement->target === 'students') {
            return User::where('role', 'user')->get();
        } elseif ($announcement->target === 'instructors') {
            return User::where('role', 'instructor')->get();
        } else {
            // For specific_courses, get users enrolled in the selected courses
            return User::whereIn('id', function ($query) use ($announcement) {
                $query->select('user_id')
                    ->from('course_enrollments')
                    ->whereIn('course_id', $announcement->courses->pluck('id'));
            })->get();
        }
    }


    public function notifications(Request $request)
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

        return view('admin.notifications.index', [
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
        return redirect()->route('admin.notifications.index')
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
