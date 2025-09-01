<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CourseCreated;
use App\Models\CourseCategory;
use App\Models\CourseMedia;
use App\Models\CourseOutcome;
use App\Models\Course;
use App\Models\Module;
use App\Models\ModuleResource;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Throwable;

class AddCourseController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function addDetails(Request $request)
    {
        $categories = CourseCategory::select(['id', 'name'])
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        // Get session data if exists
        $sessionDetails = $request->session()->get('course.add.details', []);

        return view('admin.courses.create.details', [
            'title' => 'Add Course Details',
            'categories' => $categories,
            'sessionDetails' => $sessionDetails,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeDetails(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'category_id' => 'required|exists:course_categories,id',
            'price' => 'required|numeric|min:1',
            'summary' => 'required',
        ]);

        // Store the validated data in session
        $request->session()->put('course.add.details', [
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'slug' => Str::slug($validated['title']),
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'summary' => $validated['summary'],
        ]);

        return redirect()->route('admin.courses.add.outcomes');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addCourseOutcomes(Request $request)
    {
        // Check if course details exist in session
        if (!$request->session()->has('course.add.details')) {
            return redirect()
                ->route('admin.courses.add.details')
                ->with('error', 'Please add course details first');
        }

        // Get session data if exists
        $sessionDetails = $request->session()->get('course.add.course-outcomes', []);

        return view('admin.courses.create.course-outcomes', [
            'title' => 'Add Course Outcomes',
            'sessionDetails' => $sessionDetails,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeCourseOutcomes(Request $request)
    {
        // Check if course details exist in session
        if (!$request->session()->has('course.add.details')) {
            return redirect()
                ->route('admin.courses.add.details')
                ->with('error', 'Please add course details first');
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
        $request->session()->put('course.add.course-outcomes', [
            'learning_objectives' => $objectivesArray,
        ]);

        return redirect()->route('admin.courses.add.photos.videos');
    }

    /**
     * Show the form for editing course outcomes.
     */
    public function addPhotosAndVideos(Request $request)
    {
        // Validate previous steps
        if (!$request->session()->has('course.add.details') ||
            !$request->session()->has('course.add.course-outcomes')) {
            return redirect()
                ->route('admin.courses.add.details')
                ->with('error', 'Please complete previous steps first');
        }

        // Get session data if exists
        $sessionDetails = $request->session()->get('course.add.media', []);

        return view('admin.courses.create.photos-videos', [
            'title' => 'Add Photos & Videos',
            'sessionDetails' => $sessionDetails,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storePhotosAndVideos(Request $request)
    {
        // Validate previous steps
        if (!$request->session()->has('course.add.details') ||
            !$request->session()->has('course.add.course-outcomes')) {
            return redirect()
                ->route('admin.courses.add.details')
                ->with('error', 'Please complete previous steps first');
        }

        $validated = $request->validate([
            'course_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'remove_photo' => 'nullable|string',
            'video_url' => 'nullable|url',
        ]);

        // Get existing media from session
        $existingMedia = session('course.add.media', ['course_photo' => []]);

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
        $request->session()->put('course.add.media', [
            'course_photo' => $photos,
            'video_url' => $validated['video_url'] ?? null,
        ]);

        return redirect()->route('admin.courses.add.content');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addCourseContent(Request $request)
    {
        // Validate previous steps
        if (!$request->session()->has('course.add.details') ||
            !$request->session()->has('course.add.course-outcomes') ||
            !$request->session()->has('course.add.media')) {
            return redirect()
                ->route('admin.courses.add.details')
                ->with('error', 'Please complete previous steps first');
        }

        return view('admin.courses.create.course-content', [
            'title' => 'Add Course Content'
        ]);
    }

    /**
     * Store a newly created course content in storage.
     * @throws Throwable
     */
    public function storeCourseContent(Request $request)
    {
        // Validate input
        $request->validate([
            'modules' => 'required|array|min:1',
            'modules.*.title' => 'required|string|max:255',
            'modules.*.video_url' => 'nullable|url',
            'modules.*.resources.*' => 'nullable|mimes:jpeg,png,pdf,doc,docx|max:5120',
            'modules.*.remove_resources.*' => 'nullable|string',
        ], [
            'modules.required' => 'At least one module is required.',
            'modules.*.title.required' => 'Module title is required.',
            'modules.*.video_url.url' => 'Please enter a valid YouTube video URL.',
            'modules.*.resources.*.mimes' => 'Resources must be JPEG, PNG, PDF, DOC, or DOCX files.',
            'modules.*.resources.*.max' => 'Resources must not exceed 5MB.',
        ]);

        $modules = [];
        $existingModules = session('course.add.content.modules', []);

        // Process modules
        foreach ($request->input('modules', []) as $key => $data) {
            $module = $existingModules[$key - 1] ?? [
                'title' => '',
                'video_url' => '',
                'resources' => [],
            ];

            $module['title'] = $data['title'] ?? $module['title'];
            $module['video_url'] = $data['video_url'] ?? $module['video_url'];

            // Handle removes
            $removeResources = $request->input("modules.$key.remove_resources", []);
            $module['resources'] = array_values(array_diff($module['resources'] ?? [], $removeResources));

            // Handle new uploads
            if ($request->hasFile("modules.$key.resources")) {
                foreach ($request->file("modules.$key.resources") as $file) {
                    $path = $file->store('temp/courses', 'public');
                    $module['resources'][] = Storage::url($path);
                }
            }

            // Only include modules with title or resources
            if (!empty($module['title']) || !empty($module['resources'])) {
                $modules[] = $module;
            }
        }

        // Validate at least one resource per module
        foreach ($modules as $index => $module) {
            if (empty($module['resources'])) {
                return back()->withErrors([
                    "modules." . ($index + 1) . ".resources" => "At least one resource is required for each module."
                ])->withInput();
            }
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Get session data
            $details = $request->session()->get('course.add.details', []);
            $courseOutcomes = $request->session()->get('course.add.course-outcomes', []);
            $media = $request->session()->get('course.add.media', []);

            // Create the course
            $course = Course::create([
                'title' => $details['title'] ?? 'Untitled Course',
                'subtitle' => $details['subtitle'] ?? '',
                'slug' => $details['slug'] ?? Str::slug($details['title'] ?? 'untitled-course'),
                'category_id' => $details['category_id'] ?? null,
                'price' => $details['price'] ?? 0,
                'summary' => $details['summary'] ?? '',
                'video_url' => $media['video_url'] ?? null,
                'user_id' => Auth::id(),
                'status' => 'draft',
            ]);

            // Store course outcomes
            foreach ($courseOutcomes['learning_objectives'] ?? [] as $outcome) {
                CourseOutcome::create([
                    'course_id' => $course->id,
                    'outcome' => $outcome,
                ]);
            }

            // Process and move course photos
            Storage::disk('public')->makeDirectory('courses/images');
            $courseImageUrls = $media['course_photo'] ?? [];
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
                            $image = Image::read(Storage::disk('public')->get($path));
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

                    // Save to CourseMedia
                    CourseMedia::create([
                        'course_id' => $course->id,
                        'image_url' => asset('storage/' . $newPath)
                    ]);
                }
            }

            // Process and move module resources
            Storage::disk('public')->makeDirectory('courses/resources');
            foreach ($modules as $moduleData) {
                $module = Module::create([
                    'course_id' => $course->id,
                    'title' => $moduleData['title'],
                    'video_url' => $moduleData['video_url'] ?? null,
                ]);

                foreach ($moduleData['resources'] as $resourceUrl) {
                    $path = parse_url($resourceUrl, PHP_URL_PATH);
                    $path = str_replace('/storage/', '', $path);

                    if (Storage::disk('public')->exists($path)) {
                        $filename = basename($path);
                        $newPath = 'courses/resources/' . $filename;
                        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

                        // Handle image files (JPEG, PNG)
                        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                            try {
                                $image = Image::read(Storage::disk('public')->get($path));
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
                            'module_id' => $module->id,
                            'resource_url' => asset('storage/' . $newPath)
                        ]);
                    }
                }
            }

            // Clear session data
            $request->session()->forget([
                'course.add.details',
                'course.add.course-outcomes',
                'course.add.media',
                'course.add.content.modules',
            ]);

            // Commit the transaction
            DB::commit();

            // Send email notification if enabled
            if (email_settings()->status ?? config('settings.email_notification')) {
                Mail::mailer(email_settings()->provider ?? config('settings.email_provider'))
                    ->to(Auth::user()->email)
                    ->send(new CourseCreated(Auth::user(), $course));
            }

            // Redirect to the course index with a success message
            return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
        } catch (Exception $e) {
            // Roll back the transaction on error
            DB::rollBack();
            Log::error('Course creation failed: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Failed to create course. Please try again.')
                ->withInput();
        }
    }
}
