<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Throwable;

class UserCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws Throwable
     */
    public function index(Request $request)
    {
        $user_id = Auth::id();
        $query = Course::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $category = $request->input('category');
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('name', $category)
                    ->where('status', 'active');
            });
        }

        // Price filter
        if ($request->filled('price')) {
            $price = $request->input('price');
            if ($price === 'low_to_high') {
                $query->orderBy('price');
            } elseif ($price === 'high_to_low') {
                $query->orderBy('price', 'desc');
            }
        } else {
            $query->orderBy('title');
        }

        // Fetch courses the user hasn't enrolled in
        $courses = $query->with(['category', 'profile.user'])
            ->withCount(['modules'])
            ->whereNotIn('id', function ($query) use ($user_id) {
                $query->select('course_id')
                    ->from('course_enrollments')
                    ->where('user_id', $user_id);
            })
            ->latest()
            ->paginate(8)
            ->withQueryString();

        // Fetch categories
        $categories = CourseCategory::select(['id', 'name'])
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        // Handle AJAX request
        if ($request->ajax()) {
            $html = $courses->count() ? view('user.courses.course-items', ['courses' => $courses])->render() : '';
            $pagination = $courses->count() ? $courses->links('vendor.pagination.tailwind')->render() : '';

            return Response::json([
                'html' => $html,
                'pagination' => $pagination,
            ]);
        }

        // Return view for non-AJAX request
        return view('user.courses.index', [
            'title' => 'Course List',
            'courses' => $courses,
            'search' => $request->input('search', ''),
            'categories' => $categories,
            'selectedCategory' => $request->input('category', ''),
            'selectedPrice' => $request->input('price', ''),
        ]);
    }

    public function courseDetails (string $slug)
    {
        $user_id = Auth::id();

        $course = Course::where('slug', $slug)
            ->withCount(['modules'])
            ->firstOrFail();

        $course_outcomes = $course->outcomes;
        $course_modules = $course->modules;

        $relatedCourses = Course::with(['category', 'profile.user'])
            ->where('category_id', $course->category->id)
            ->where('id', '!=', $course->id)
            ->whereNotIn('id', function ($query) use ($user_id) {
                $query->select('course_id')
                    ->from('course_enrollments')
                    ->where('user_id', $user_id);
            })
            ->orderBy('title', 'ASC')
            ->latest()
            ->limit(3)
            ->get();

        return view('user.courses.course-details', [
            'title' => 'Course Details',
            'course' => $course,
            'course_outcomes' => $course_outcomes,
            'course_modules' => $course_modules,
            'relatedCourses' => $relatedCourses,
        ]);
    }
}
