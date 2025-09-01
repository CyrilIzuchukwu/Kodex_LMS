<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AccountDeletedConfirmation;
use App\Mail\PasswordResetConfirmation;
use App\Mail\UserEmailConfirmation;
use App\Mail\WelcomeEmail;
use App\Models\LoginHistory;
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
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Jenssegers\Agent\Agent;
use Throwable;

class ManageInstructorsController extends Controller
{
    /**
     * Show instructors' page
     * @return Renderable
     */
    public function index(Request $request)
    {
        $query = User::with('profile')->where('role', '!=', 'admin')
            ->where('role', '!=', 'user');

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

        return view('admin.instructors.index', [
            'title' => 'Instructors',
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
        // Validate the request
        $validated = $request->validate([
            'full_name_instructor' => 'required|string|max:255',
            'phone_number' => 'required|string',
            'address_instructor' => 'required|string|max:255',
            'course' => 'required|exists:courses,id',
            'email_instructor' => 'required|email|max:255|unique:users,email',
            'password_instructor' => 'required|string|min:8',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,gif|max:5120',
            'biography_instructor' => 'nullable|string|max:1000',
        ]);

        try {

            // Check if the course is already assigned to another instructor
            $existingAssignment = UserProfile::where('course_id', $validated['course'])->first();

            if ($existingAssignment) {
                return response()->json([
                    'status' => false,
                    'message' => 'This course is already assigned to another instructor.',
                ], 422);
            }

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
                'name' => $validated['full_name_instructor'],
                'email' => $validated['email_instructor'],
                'password' => Hash::make($validated['password_instructor']),
                'role' => 'instructor',
            ]);

            // Store data for user profile
            $profileData = [
                'phone_number' => $validated['phone_number'],
                'address' => $validated['address_instructor'],
                'profile_photo_path' => $profilePhotoPath,
                'biography' => $validated['biography_instructor'],
                'course_id' => $validated['course'],
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
                        ->to($request->email_instructor)
                        ->send(new WelcomeEmail($user));
                } catch (Exception $e) {
                    Log::error('Failed to send welcome email', ['email' => $request->email_instructor, 'error' => $e->getMessage()]);
                    return redirect()->back()->with('error', __('Failed to send welcome email. Please try again later.'));
                }
            }

            // Return success response
            return response()->json([
                'success' => true,
                'message' => "Account for $request->full_name_instructor has been created successfully.",
                'redirect' => route('admin.instructors.index')
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

    public function show(User $instructor)
    {
        $loginHistories = LoginHistory::where('user_id', $instructor->id)
            ->orderBy('login_at', 'desc')
            ->paginate(10);

        return view('admin.instructors.show', [
            'title' => 'Instructors Profile',
            'instructor' => $instructor,
            'loginHistories' => $loginHistories
        ]);
    }

    public function edit(User $instructor)
    {
        return view('admin.instructors.edit', [
            'title' => 'Edit Instructor Profile',
            'instructor' => $instructor,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $instructor)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'course' => 'required|exists:courses,id',
            'biography' => 'nullable|string|max:255'
        ]);

        try {

            // Check if the course is already assigned to another instructor
            $existingAssignment = UserProfile::where('course_id', $validated['course'])
                ->where('user_id', '!=', $instructor->id)
                ->first();

            if ($existingAssignment) {
                return redirect()->back()->withErrors(['course' => 'This course is already assigned to another instructor.']);
            }

            // Update the instructor's profile
            $instructor->update([
                'name' => $validated['name'],
            ]);

            // Prepare profile data
            $data = [
                'phone_number' => $validated['phone_number'],
                'address' => $validated['address'],
                'biography' => $validated['biography'],
                'course_id' => $validated['course'],
            ];

            UserProfile::updateOrCreate(
                ['user_id' => $instructor->id],
                $data
            );

            return redirect()->back()->with('success', __('Instructor\'s personal details have been updated successfully.'));

        } catch (Exception $exception) {
            Log::error('Failed to update profile: ' . $exception->getMessage());
            return redirect()->back()->with('error', __('Failed to update profile'));
        }
    }

    /**
     * Update the user's profile picture.
     *
     * @param Request $request
     * @param User $instructor
     * @return JsonResponse
     */
    public function updatePicture(Request $request, User $instructor): JsonResponse
    {
        $request->validate([
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

        try {

            $storagePath = 'instructors/';

            // Delete old image if exists
            if ($instructor->profile->profile_photo_path) {
                $oldImagePath = str_replace(Storage::disk('public')->url(''), '', $instructor->profile->profile_photo_path);
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

            // Update instructor
            UserProfile::updateOrCreate(
                ['user_id' => $instructor->id],
                $data
            );

            return response()->json([
                'success' => true,
                'message' => __('Instructor\'s profile picture successfully uploaded.')
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
     * @param User $instructor
     * @return RedirectResponse
     */
    public function removePicture(User $instructor): RedirectResponse
    {
        // Delete the profile picture if it exists
        if ($instructor->profile->profile_photo_path) {
            $oldImagePath = str_replace(Storage::disk('public')->url(''), '', $instructor->profile->profile_photo_path);

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

        // Update instructor
        UserProfile::updateOrCreate(
            ['user_id' => $instructor->id],
            $data
        );

        // Redirect back with a success message
        return redirect()->back()
            ->with('success', 'User\'s profile picture removed successfully.');
    }

    /**
     * Send email to user.
     */
    public function sendNotification(Request $request, User $instructor)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {

            // Send notifications
            if (email_settings()->status ?? config('settings.email_notification')) {
                Mail::mailer(email_settings()->provider ?? config('settings.email_provider'))
                    ->to($instructor->email)
                    ->send(new UserEmailConfirmation($instructor, $request->subject, $request->message));
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
    public function resetPassword(Request $request, User $instructor)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {

            $instructor->password = Hash::make($request->password);
            $instructor->save();

            // Send email
            if (email_settings()->status ?? config('settings.email_notification')) {
                Mail::mailer(email_settings()->provider ?? config('settings.email_provider'))
                    ->to($instructor->email)
                    ->send(new PasswordResetConfirmation(
                        $instructor,
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
    public function suspend(User $instructor)
    {
        try {

            $instructor->status = 'inactive';
            $instructor->save();

            return response()->json(['success' => true, 'message' => 'Account blocked successfully']);
        } catch (Exception $e) {
            Log::error('Account blocking failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to block account'], 500);
        }
    }

    /**
     * Unblock user account.
     */
    public function unsuspend(User $instructor)
    {
        try {
            $instructor->status = 'active';
            $instructor->save();

            return response()->json(['success' => true, 'message' => 'Account unblocked successfully']);
        } catch (Exception $e) {
            Log::error('Account unblocking failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to unblock account'], 500);
        }
    }

    /**
     * Delete user account.
     * @throws Throwable
     */
    public function destroy(User $instructor)
    {
        DB::beginTransaction();

        try {

            // Send email
            if (email_settings()->status ?? config('settings.email_notification')) {
                Mail::mailer(email_settings()->provider ?? config('settings.email_provider'))
                    ->to($instructor->email)
                    ->send(new AccountDeletedConfirmation($instructor));
            }

            $instructor->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Account deleted successfully',
                'redirect' => route('admin.instructors.index')
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Account deletion failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to delete account'], 500);
        }
    }

    /**
     * Assigns a course to an instructor
     * @throws Throwable
     */
    public function assignCourse(Request $request, User $instructor)
    {
        $validated = $request->validate([
            'course' => 'required|integer|exists:courses,id',
        ]);

        DB::beginTransaction();

        try {

            // Check if the course is already assigned to another instructor
            $existingAssignment = UserProfile::where('course_id', $validated['course'])
                ->where('user_id', '!=', $instructor->id)
                ->first();

            if ($existingAssignment) {
                return response()->json([
                    'status' => false,
                    'message' => 'This course is already assigned to another instructor.',
                ], 422);
            }

            $data = [
                'course_id' => $validated['course'],
            ];

            UserProfile::updateOrCreate(
                ['user_id' => $instructor->id],
                $data
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Course assigned successfully'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Course assignment failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to assign course'], 500);
        }
    }

    /**
     * Login as user.
     */
    public function loginAsUser(User $instructor)
    {
        try {
            Auth::login($instructor);
            return response()->json([
                'success' => true,
                'redirect' => route('instructor.dashboard')
            ]);
        } catch (Exception $e) {
            Log::error('Login as instructor failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to login as instructor'], 500);
        }
    }

    /**
     * Handle image upload and return the path
     */
    private function handleImageUpload($file)
    {
        try {

            $storagePath = 'instructors/';

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
