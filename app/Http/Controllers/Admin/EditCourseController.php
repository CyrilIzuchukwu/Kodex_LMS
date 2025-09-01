<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use App\Models\CourseMedia;
use App\Models\CourseOutcome;
use App\Models\Course;
use App\Models\Module;
use App\Models\ModuleResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Throwable;

class EditCourseController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function editDetails(Course $course, Request $request)
    {
        $categories = CourseCategory::select(['id', 'name'])
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        // Get session data if exists
        $sessionDetails = $request->session()->get('course.edit.details', []);

        return view('admin.courses.edit.details', [
            'title' => 'Edit Course Details',
            'categories' => $categories,
            'sessionDetails' => $sessionDetails,
            'course' => $course
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updateDetails(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'category_id' => 'required|exists:course_categories,id',
            'price' => 'required|numeric|min:1',
            'summary' => 'required',
        ]);

        // Store the validated data in session
        $request->session()->put('course.edit.details', [
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'slug' => Str::slug($validated['title']),
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'summary' => $validated['summary'],
        ]);

        return redirect()->route('admin.courses.edit.outcomes', $course->id);
    }

    /**
     * Show the form for editing course outcomes.
     */
    public function editCourseOutcomes(Request $request, Course $course)
    {
        // Check if course details exist in session
        if (!$request->session()->has('course.edit.details')) {
            return redirect()
                ->route('admin.courses.edit.details')
                ->with('error', 'Please edit course details first');
        }

        // Get session data if exists, otherwise fetch from database
        $sessionDetails = $request->session()->get('course.edit.course-outcomes');

        // If no session data, load outcomes from the database
        $outcomes = $sessionDetails
            ? ($sessionDetails['learning_objectives'] ?? [])
            : $course->outcomes->pluck('outcome')->toArray();

        return view('admin.courses.edit.course-outcomes', [
            'title' => 'Edit Course Outcomes',
            'sessionDetails' => ['learning_objectives' => $outcomes],
            'course' => $course
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updateCourseOutcomes(Request $request, Course $course)
    {
        // Check if course details exist in session
        if (!$request->session()->has('course.edit.details')) {
            return redirect()
                ->route('admin.courses.edit.details')
                ->with('error', 'Please edit course details first');
        }

        $validated = $request->validate([
            'learning_objectives' => [
                'required',
                'string',
                'max:2000',
                function ($attribute, $value, $fail) {
                    $objectives = array_filter(array_map('trim', explode(',', $value)));

                    if (count($objectives) < 1) {
                        $fail('At least one learning objective is required.');
                    }

                    if (count($objectives) > 10) {
                        $fail('Maximum 10 learning objectives are allowed.');
                    }

                    foreach ($objectives as $objective) {
                        if (strlen($objective) < 3) {
                            $fail('Each learning objective must be at least 3 characters long.');
                        }
                        if (strlen($objective) > 100) {
                            $fail('Each learning objective must not exceed 100 characters.');
                        }
                    }

                    // Check for duplicates
                    if (count($objectives) !== count(array_unique($objectives))) {
                        $fail('Duplicate learning objectives are not allowed.');
                    }
                }
            ],
        ]);

        // Convert comma-separated string to array
        $objectivesArray = array_filter(array_map('trim', explode(',', $validated['learning_objectives'])));

        // Store the validated data in session
        $request->session()->put('course.edit.course-outcomes', [
            'learning_objectives' => $objectivesArray,
        ]);

        return redirect()->route('admin.courses.edit.photos.videos', $course->id);
    }

    /**
     * Show the form for editing photos and videos.
     */
    public function editPhotosAndVideos(Request $request, Course $course)
    {
        // Validate previous steps
        if (!$request->session()->has('course.edit.details') ||
            !$request->session()->has('course.edit.course-outcomes')) {
            return redirect()
                ->route('admin.courses.edit.details')
                ->with('error', 'Please complete previous steps first');
        }

        // Get session data if exists, otherwise fetch from database
        $sessionDetails = $request->session()->get('course.edit.media');

        // If no session data, load media from the database
        $media = $sessionDetails ?? [
            'course_photo' => $course->media ? [$course->media->image_url] : [],
            'video_url' => $course->video_url
        ];

        return view('admin.courses.edit.photos-videos', [
            'title' => 'Edit Photos & Videos',
            'sessionDetails' => $media,
            'course' => $course
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updatePhotosAndVideos(Request $request, Course $course)
    {
        // Validate previous steps
        if (!$request->session()->has('course.edit.details') ||
            !$request->session()->has('course.edit.course-outcomes')) {
            return redirect()
                ->route('admin.courses.edit.details')
                ->with('error', 'Please complete previous steps first');
        }

        $validated = $request->validate([
            'course_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'remove_photo' => 'nullable|string',
            'video_url' => 'nullable|url',
        ]);

        // Get existing media from session
        $existingMedia = session('course.edit.media', ['course_photo' => []]);

        // Handle file uploads
        $photos = $existingMedia['course_photo'];

        // Remove photo if requested
        if ($request->has('remove_photo')) {
            $photoToRemove = $request->input('remove_photo');
            $photos = array_filter($photos, fn($photo) => $photo !== $photoToRemove);
            // Optionally delete the file from storage
            $path = str_replace(Storage::disk('public')->url(''), '', $photoToRemove);
            Storage::disk('public')->delete($path);
        }

        // Store a new photo if uploaded
        if ($request->hasFile('course_photo')) {
            $photos = []; // Clear existing photos since we're uploading a new one
            $photo = $request->file('course_photo');
            $storedPath = $photo->store('temp/courses', 'public');
            $photos[] = asset('storage/' . $storedPath);
        }

        // Store media data in session
        $request->session()->put('course.edit.media', [
            'course_photo' => $photos,
            'video_url' => $validated['video_url'] ?? null,
        ]);

        return redirect()->route('admin.courses.edit.update.content', $course->id);
    }

    /**
     * Show the form for editing course content.
     */
    public function editCourseContent(Request $request, Course $course)
    {
        // Validate previous steps
        if (!$request->session()->has('course.edit.details') ||
            !$request->session()->has('course.edit.course-outcomes') ||
            !$request->session()->has('course.edit.media')) {
            return redirect()
                ->route('admin.courses.edit.details', $course)
                ->with('error', 'Please complete previous steps first');
        }

        // Load modules from DB into session if not already present
        if (!$request->session()->has('course.edit.content.modules')) {
            $modulesFromDb = $course->modules()->orderBy('order')->get()->map(function ($module) {
                return [
                    'id' => $module->id,
                    'title' => $module->title,
                    'video_url' => $module->video_url,
                    'resources' => $module->resources->pluck('resource_url')->toArray(),
                ];
            })->toArray();

            $request->session()->put('course.edit.content.modules', $modulesFromDb);
        }

        return view('admin.courses.edit.course-content', [
            'title' => 'Edit Course Content',
            'course' => $course,
        ]);
    }

    /**
     * Update the existing course content in storage.
     * @throws Throwable
     */
    public function updateCourseContent(Request $request, Course $course)
    {
        // Validate input
        $request->validate([
            'modules' => 'required|array|min:1',
            'modules.*.id' => 'nullable|exists:modules,id',
            'modules.*.title' => 'required|string|max:255',
            'modules.*.video_url' => 'nullable|url',
            'modules.*.resources.*' => 'nullable|mimes:jpeg,png,pdf,doc,docx|max:5120',
            'modules.*.remove_resources.*' => 'nullable|string',
            'delete_modules.*' => 'nullable|exists:modules,id',
        ], [
            'modules.required' => 'At least one module is required.',
            'modules.*.title.required' => 'Module title is required.',
            'modules.*.video_url.url' => 'Please enter a valid YouTube video URL.',
            'modules.*.resources.*.mimes' => 'Resources must be JPEG, PNG, PDF, DOC, or DOCX files.',
            'modules.*.resources.*.max' => 'Resources must not exceed 5MB.',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Get session data
            $details = $request->session()->get('course.edit.details', []);
            $courseOutcomes = $request->session()->get('course.edit.course-outcomes', []);
            $media = $request->session()->get('course.edit.media', []);

            // Update course details
            $course->update([
                'title' => $details['title'] ?? $course->title,
                'subtitle' => $details['subtitle'] ?? $course->subtitle,
                'slug' => $details['slug'] ?? $course->slug,
                'category_id' => $details['category_id'] ?? $course->category_id,
                'price' => $details['price'] ?? $course->price,
                'summary' => $details['summary'] ?? $course->summary,
                'video_url' => $media['video_url'] ?? $course->video_url,
            ]);

            // Update course outcomes
            $course->outcomes()->delete();
            foreach ($courseOutcomes['learning_objectives'] ?? [] as $outcome) {
                CourseOutcome::create([
                    'course_id' => $course->id,
                    'outcome' => $outcome,
                ]);
            }

            // Process course media (photos)
            $courseImageUrls = $media['course_photo'] ?? [];
            if (!empty($courseImageUrls)) {
                // Remove old media not in the new list
                $course->media()->whereNotIn('image_url', $courseImageUrls)->delete();
                Storage::disk('public')->makeDirectory('courses/images');
                foreach ($courseImageUrls as $url) {
                    $path = parse_url($url, PHP_URL_PATH);
                    $path = str_replace('/storage/', '', $path);

                    if (Storage::disk('public')->exists($path)) {
                        $filename = basename($path);
                        $newPath = 'courses/images/' . $filename;
                        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

                        // Handle image files (JPEG, PNG)
                        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                            try {
                                $image = ImageManager::gd()->read(Storage::disk('public')->get($path));
                                $image->resize(1120, 630);
                                Storage::disk('public')->put($newPath, $image->encode());
                            } catch (Exception $e) {
                                Log::error('Failed to resize course image: ' . $e->getMessage());
                                // Fallback: Move the file without resizing
                                Storage::disk('public')->move($path, $newPath);
                            }
                        } else {
                            // Handle non-image files (shouldn't occur due to validation)
                            Storage::disk('public')->move($path, $newPath);
                        }

                        // Delete temporary file
                        Storage::disk('public')->delete($path);

                        // Save to CourseMedia if not already present
                        CourseMedia::firstOrCreate([
                            'course_id' => $course->id,
                            'image_url' => asset('storage/' . $newPath),
                        ]);
                    }
                }
            }

            // Handle deleted modules
            $deleteModuleIds = $request->input('delete_modules', []);
            if (!empty($deleteModuleIds)) {
                Module::whereIn('id', $deleteModuleIds)->delete();
            }

            // Process modules
            $existingModuleIds = $course->modules()->pluck('id')->toArray();
            $submittedModuleIds = array_filter(array_column($request->input('modules', []), 'id'));
            $modulesToDelete = array_diff($existingModuleIds, $submittedModuleIds);
            if (!empty($modulesToDelete)) {
                Module::whereIn('id', $modulesToDelete)->delete();
            }

            foreach ($request->input('modules', []) as $key => $data) {
                $moduleData = [
                    'title' => $data['title'],
                    'video_url' => $data['video_url'] ?? null,
                    'order' => $key,
                ];

                // Update or create module
                if (isset($data['id']) && $data['id']) {
                    $module = Module::findOrFail($data['id']);
                    $module->update($moduleData);
                } else {
                    $module = Module::create(array_merge($moduleData, ['course_id' => $course->id]));
                }

                $moduleId = $module->id;

                // Handle removed resources
                $removeResources = $request->input("modules.$key.remove_resources", []);
                if (!empty($removeResources)) {
                    ModuleResource::where('module_id', $moduleId)
                        ->whereIn('resource_url', $removeResources)
                        ->delete();
                }

                // Handle new uploads
                if ($request->hasFile("modules.$key.resources")) {
                    Storage::disk('public')->makeDirectory('courses/resources');
                    foreach ($request->file("modules.$key.resources") as $file) {
                        $path = $file->store('temp/courses', 'public');
                        $filename = basename($path);
                        $newPath = 'courses/resources/' . $filename;
                        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

                        // Handle image files (JPEG, PNG)
                        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                            try {
                                $image = ImageManager::gd()->read(Storage::disk('public')->get($path));
                                $image->resize(1920, 1080);
                                Storage::disk('public')->put($newPath, $image->encode());
                            } catch (Exception $e) {
                                Log::error('Failed to resize module resource image: ' . $e->getMessage());
                                // Fallback: Move the file without resizing
                                Storage::disk('public')->move($path, $newPath);
                            }
                        } else {
                            // Handle non-image files (PDF, DOC, DOCX)
                            Storage::disk('public')->move($path, $newPath);
                        }

                        // Delete temporary file
                        Storage::disk('public')->delete($path);

                        // Save to ModuleResource
                        ModuleResource::create([
                            'module_id' => $moduleId,
                            'resource_url' => asset('storage/' . $newPath),
                        ]);
                    }
                }
            }

            // Clear session data
            $request->session()->forget([
                'course.edit.details',
                'course.edit.course-outcomes',
                'course.edit.media',
                'course.edit.content.modules',
            ]);

            // Commit the transaction
            DB::commit();

            // Redirect to the course index with a success message
            return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
        } catch (Exception $e) {
            // Roll back the transaction on error
            DB::rollBack();
            Log::error('Course update failed: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Failed to update course. Please try again.')
                ->withInput();
        }
    }
}
