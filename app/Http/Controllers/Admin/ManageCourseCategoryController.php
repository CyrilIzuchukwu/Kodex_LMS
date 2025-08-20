<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Log;

class ManageCourseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CourseCategory::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        $categories = $query->withCount('courses')
            ->orderBy('name', 'ASC')
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('admin.category.index', [
            'title' => 'Course Category List',
            'categories' => $categories,
            'search' => $request->input('search'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'unique:course_categories,name'
            ]
        ]);

        try {

            // Create the category
            CourseCategory::create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'status' => 'active',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully'
            ]);

        } catch (Exception $e) {
            Log::error('Category creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the category. Please try again.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug, Request $request)
    {
        $category = CourseCategory::where('slug', $slug)
            ->firstOrFail();

        $query = $category->courses();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', '%' . $search . '%');
        }

        $courses = $query->orderBy('title', 'ASC')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.category.show', [
            'category' => $category,
            'title' => $category->name,
            'courses' => $courses,
            'search' => $request->input('search'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseCategory $category)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                Rule::unique('course_categories', 'name')->ignore($category->id)
            ]
        ]);

        try {

            // Update the category
            $category->update([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully',
            ]);

        } catch (Exception $e) {
            Log::error('Category update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the category. Please try again.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseCategory $category)
    {
        // Check if a category has associated courses
        if ($category->courses()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete category that has associated courses. Please move or delete the courses first.'
            ], 422);
        }

        $categoryName = $category->name;
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => "Category '$categoryName' deleted successfully"
        ]);
    }
}
