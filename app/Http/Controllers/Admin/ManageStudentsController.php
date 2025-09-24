<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AccountDeletedConfirmation;
use App\Mail\PasswordResetConfirmation;
use App\Mail\UserEmailConfirmation;
use App\Mail\WelcomeEmail;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserProfile;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Jenssegers\Agent\Agent;
use Throwable;

class ManageStudentsController extends Controller
{
    /**
     * Show students' page
     * @return Renderable
     */
    public function index(Request $request)
    {
        $query = User::with('profile')->where('role', '!=', 'admin')
            ->where('role', '!=', 'instructor');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone_number', 'like', "%$search%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $status = $request->status;
            // Handle different status values
            if ($status === 'banned' || $status === 'blocked') {
                $query->where('status', '!=', 'active');
            } else {
                $query->where('status', $status);
            }
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.students.index', [
            'title' => 'Students',
            'users' => $users,
            'search' => $request->search,
            'status' => $request->status,
        ]);
    }

    /**
     * Stores a newly created user
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,gif|max:5120',
            'biography' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proceed with validated data
        $validated = $validator->validated();

        try {

            // Handle profile photo upload
            $profilePhotoPath = null;
            if ($request->hasFile('profile_photo')) {
                $profilePhotoPath = $this->handleImageUpload($request->file('profile_photo'));
                if (!$profilePhotoPath) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Failed to upload profile photo. Please try again.'
                    ], 500);
                }
            }

            // Create the user
            $user = User::create([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Store data for user profile
            $profileData = [
                'phone_number' => $validated['phone'],
                'address' => $validated['address'],
                'profile_photo_path' => $profilePhotoPath,
                'biography' => $validated['biography'],
            ];

            // Create user profile
            UserProfile::updateOrCreate(
                ['user_id' => $user->id],
                $profileData
            );

            // Send email
            if (email_settings()->status ?? config('settings.email_notification')) {
                try {
                    Mail::mailer(email_settings()->provider ?? config('settings.email_provider'))
                        ->to($request->email)
                        ->send(new WelcomeEmail($user));
                } catch (Exception $e) {
                    Log::error('Failed to send welcome email', ['email' => $request->email, 'error' => $e->getMessage()]);
                    return redirect()->back()->with('error', __('Failed to send welcome email. Please try again later.'));
                }
            }

            // Return success response
            return response()->json([
                'success' => true,
                'message' => "Account for $request->full_name has been created successfully.",
                'redirect' => route('admin.students.index')
            ], 201);
        }catch (Exception $exception) {
            // Return general error
            Log::error('Failed to create account: ' . $exception->getMessage());
            return response()->json([
                'status' => false,
                'message' => __('Failed to create account')
            ], 500);
        }
    }

    /**
     * Delete user account.
     * @throws Throwable
     */
    public function destroy(User $student)
    {
        DB::beginTransaction();

        try {

            // Send email
            if (email_settings()->status ?? config('settings.email_notification')) {
                Mail::mailer(email_settings()->provider ?? config('settings.email_provider'))
                    ->to($student->email)
                    ->send(new AccountDeletedConfirmation($student));
            }

            $student->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Account deleted successfully',
                'redirect' => route('admin.students.index')
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Account deletion failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to delete account'], 500);
        }
    }

    public function show(User $student)
    {
        $enrollments = CourseEnrollment::where('user_id', $student->id)->get();

        $enrolled_courses = $enrollments->count();
        $completed_courses = $enrollments->where('status', 'completed')->count();
        $active_courses = $enrollments->where('status', 'running')->count();

        // Base query for enrolled courses
        $query = CourseEnrollment::with([
            'course' => fn($query) => $query->with(['profile.user'])->withCount('modules'),
        ])->where('user_id', $student->id);

        // Paginate results
        $courses = $query->orderBy('title')->latest()->paginate(6)->withQueryString();

        // Certificates
        $certificates_count = Certificate::where('user_id', $student->id)->count();
        $certificates = Certificate::with('course')
            ->where('user_id', $student->id)
            ->latest()->paginate(6)
            ->withQueryString();

        // Fetch transactions for the authenticated user
        $payments = Transaction::where('user_id', $student->id)->paginate(10);

        // Collect all course IDs from cart_items across all transactions
        $courseIds = [];
        foreach ($payments as $payment) {
            $cartItems = json_decode($payment->cart_items, true) ?? [];
            $courseIds = array_merge($courseIds, array_column($cartItems, 'course_id'));
        }
        $courseIds = array_unique($courseIds);

        // Fetch Course models for the collected course IDs
        $courses_purchased = Course::whereIn('id', $courseIds)->with('category')->get();

        return view('admin.students.show', [
            'title' => 'Student Profile',
            'student' => $student,
            'enrolled_courses' => $enrolled_courses,
            'completed_courses' => $completed_courses,
            'active_courses' => $active_courses,
            'courses' => $courses,
            'certificates' => $certificates,
            'certificates_count' => $certificates_count,
            'payments' => $payments,
            'courses_purchased' => $courses_purchased,
        ]);
    }

    public function edit(User $student)
    {
        return view('admin.students.edit', [
            'title' => 'Edit Student Profile',
            'student' => $student,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $student)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'biography' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proceed with validated data
        $validated = $validator->validated();

        try {

            // Update the student's profile
            $student->update([
                'name' => $validated['name'],
            ]);

            // Prepare profile data
            $data = $request->only(
                'phone_number',
                'address',
                'biography'
            );

            UserProfile::updateOrCreate(
                ['user_id' => $student->id],
                $data
            );

            return redirect()->back()->with('success', __('Student\'s personal details have been updated successfully.'));

        } catch (Exception $exception) {
            Log::error('Failed to update profile: ' . $exception->getMessage());
            return redirect()->back()->with('error', __('Failed to update profile'));
        }
    }

    /**
     * Update the user's profile picture.
     *
     * @param Request $request
     * @param User $student
     * @return JsonResponse
     */
    public function updatePicture(Request $request, User $student): JsonResponse
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'profile_image' => [
                'required',
                'image',
                'mimes:png,jpg,jpeg',
                'max:2048',
            ],
        ], [
            'profile_image.required' => 'Please select an image to upload.',
            'profile_image.image' => 'The file must be an image.',
            'profile_image.mimes' => 'The image must be a PNG, JPG, or JPEG file.',
            'profile_image.max' => 'The image must not exceed 2MB in size.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'error'
            ], 422);
        }

        try {

            $storagePath = 'students/';

            // Delete old image if exists
            if ($student->profile?->profile_photo_path) {
                $oldImagePath = str_replace(Storage::disk('public')->url(''), '', $student->profile?->profile_photo_path);
                Storage::disk('public')->delete($oldImagePath);
            }

            // Store new image
            $image = $request->file('profile_image');
            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $fullPath = $storagePath . $filename;

            // Resize and save
            $resizedImage = Image::read($image)->resize(124, 124);
            Storage::disk('public')->put($fullPath, $resizedImage->encode());

            $data = [
                'profile_photo_path' => asset('storage/' . $fullPath),
            ];

            // Update student
            UserProfile::updateOrCreate(
                ['user_id' => $student->id],
                $data
            );

            return response()->json([
                'success' => true,
                'message' => __('Student\'s profile picture successfully uploaded.')
            ]);
        } catch (Exception $e) {
            Log::error("Profile picture update error: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    /**
     * Remove the user's profile picture.
     *
     * @param User $student
     * @return RedirectResponse
     */
    public function removePicture(User $student): RedirectResponse
    {
        // Delete the profile picture if it exists
        if ($student->profile?->profile_photo_path) {
            $oldImagePath = str_replace(Storage::disk('public')->url(''), '', $student->profile?->profile_photo_path);

            try {
                Storage::disk('public')->delete($oldImagePath);
            } catch (Exception) {
                return redirect()->back()
                    ->withErrors(['error' => 'Failed to delete the profile picture. Please try again.']);
            }
        }

        // Set the profile image to null in the database
        $data = [
            'profile_photo_path' => null,
        ];

        // Update student
        UserProfile::updateOrCreate(
            ['user_id' => $student->id],
            $data
        );

        // Redirect back with a success message
        return redirect()->back()
            ->with('success', 'User\'s profile picture removed successfully.');
    }

    /**
     * Send email to user.
     */
    public function sendNotification(Request $request, User $student)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {

            // Send notifications
            if (email_settings()->status ?? config('settings.email_notification')) {
                Mail::mailer(email_settings()->provider ?? config('settings.email_provider'))
                    ->to($student->email)
                    ->send(new UserEmailConfirmation($student, $request->subject, $request->message));
            }

            return response()->json([
                'success' => true,
                'message' => 'Email sent successfully'
            ]);
        } catch (Exception $e) {
            Log::error('Email sending failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to send email'], 500);
        }
    }

    /**
     * Reset user password.
     */
    public function resetPassword(Request $request, User $student)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {

            $student->password = Hash::make($request->password);
            $student->save();

            // Send email
            if (email_settings()->status ?? config('settings.email_notification')) {
                Mail::mailer(email_settings()->provider ?? config('settings.email_provider'))
                    ->to($student->email)
                    ->send(new PasswordResetConfirmation(
                        $student,
                        $request->ip(),
                        $this->getDevice($request->userAgent())
                    ));
            }

            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Password reset successfully']);
            }

            return redirect()->back()->with('success', 'Password reset successfully');
        } catch (Exception $e) {
            Log::error('Password reset failed', ['error' => $e->getMessage()]);

            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to reset password'], 500);
            }

            return redirect()->back()->with('error', 'Failed to reset password');
        }
    }

    /**
     * Block user account.
     */
    public function suspend(User $student)
    {
        try {

            $student->status = 'inactive';
            $student->save();

            return response()->json(['success' => true, 'message' => 'Account blocked successfully']);
        } catch (Exception $e) {
            Log::error('Account blocking failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to block account'], 500);
        }
    }

    /**
     * Unblock user account.
     */
    public function unsuspend(User $student)
    {
        try {
            $student->status = 'active';
            $student->save();

            return response()->json(['success' => true, 'message' => 'Account unblocked successfully']);
        } catch (Exception $e) {
            Log::error('Account unblocking failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to unblock account'], 500);
        }
    }

    /**
     * Handle image upload and return the path
     */
    private function handleImageUpload($file)
    {
        try {

            $storagePath = 'students/';

            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $fullPath = $storagePath . $filename;

            // Resize and save
            $resizedImage = Image::read($file)->resize(124, 124);
            Storage::disk('public')->put($fullPath, $resizedImage->encode());

            // Return a full absolute path
            return asset('storage/' . $fullPath);
        } catch (Exception $e) {
            Log::error('Image upload failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Login as user.
     */
    public function loginAsUser(User $student)
    {
        try {
            Auth::login($student);
            return response()->json([
                'success' => true,
                'redirect' => route('user.dashboard')
            ]);
        } catch (Exception $e) {
            Log::error('Login as student failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to login as student'], 500);
        }
    }

    /**
     * @param $userAgent
     * @return string
     */
    protected function getDevice($userAgent)
    {
        $parser = new Agent();
        $parser->setUserAgent($userAgent);

        $device = $parser->device();
        $platform = $parser->platform();
        $browser = $parser->browser();

        return $device . ' (' . $platform . ') - ' . $browser;
    }
}
