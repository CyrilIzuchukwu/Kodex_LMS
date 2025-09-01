<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcements;
use App\Models\Course;
use App\Models\User;
use App\Notifications\NewAnnouncement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target' => 'required|in:all,students,instructors,specific_courses',
            'courses' => 'required_if:target,specific_courses|array',
            'courses.*' => 'exists:courses,id',
            'attachment' => 'nullable|file|mimes:jpeg,png,pdf|max:5120',
        ]);

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
}
