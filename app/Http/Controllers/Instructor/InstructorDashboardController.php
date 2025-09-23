<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\CourseEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $instructor = Auth::user();
        $course_id = $instructor->profile?->course_id;

        // Get all enrollments for the instructor
        $courses = CourseEnrollment::where('course_id', $course_id);

        // Calculate metrics using separate queries to avoid query builder state issues
        $total_students = $courses->count();
        $active_courses = CourseEnrollment::where('course_id', $course_id)
            ->where('status', 'running')
            ->count();
        $completed_courses = CourseEnrollment::where('course_id', $course_id)
            ->where('status', 'completed')
            ->count();

        // Calculate completion rate (avoid division by zero)
        $completion_rate = $total_students > 0
            ? round(($completed_courses / $total_students) * 100, 2)
            : 0;

        // Eager load relationships and paginate
        $students = CourseEnrollment::where('course_id', $course_id)
            ->with(['user.profile', 'course'])
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return view('instructor.dashboard', [
            'title' => 'Dashboard',
            'instructor' => $instructor,
            'students' => $students,
            'active_courses' => $active_courses,
            'total_students' => $total_students,
            'completion_rate' => $completion_rate
        ]);
    }
}
