<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEnrollment;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function __invoke()
    {
        $user_id = Auth::id();
        $courses = Course::with(['category', 'profile.user'])
            ->whereNotIn('id', function ($query) use ($user_id) {
                $query->select('course_id')
                    ->from('course_enrollments')
                    ->where('user_id', $user_id);
            })
            ->orderBy('title', 'ASC')
            ->inRandomOrder()
            ->latest()
            ->limit(4)
            ->get();

        // My learning Courses (accessed within the last 48 hours)
        $myLearning = CourseEnrollment::with([
            'course' => function ($query) {
                $query->with(['profile.user', 'category', 'media'])
                    ->select('courses.*')
                    ->withCount('modules');
            }
        ])->where('user_id', $user_id)
            ->whereNotNull('last_accessed')
            ->where('last_accessed', '>=', now()->subHours(48))
            ->orderByDesc('last_accessed')
            ->orderByRaw("CASE WHEN status = 'running' THEN 1 WHEN status = 'completed' THEN 2 ELSE 3 END")
            ->latest()
            ->paginate(3);

        return view('user.dashboard', [
            'title' => 'Dashboard',
            'courses' => $courses,
            'myLearning' => $myLearning,
        ]);
    }
}
