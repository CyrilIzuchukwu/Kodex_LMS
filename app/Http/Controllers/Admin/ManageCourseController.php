<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class ManageCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Course::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', '%' . $search . '%');
        }

        $courses = $query->with(['category', 'profile.user'])
            ->withCount(['modules', 'students'])
            ->orderBy('title', 'ASC')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.courses.index', [
            'title' => 'Course List',
            'courses' => $courses,
            'search' => $request->input('search'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $courseName = $course->title;
        $course->delete();

        return response()->json([
            'success' => true,
            'message' => "Course '$courseName' deleted successfully"
        ]);
    }
}
