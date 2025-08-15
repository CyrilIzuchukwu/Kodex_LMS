<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AccountDeletedConfirmation;
use App\Mail\WelcomeEmail;
use App\Models\User;
use App\Models\UserProfile;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Throwable;

class ManageStudentsControllers extends Controller
{
    /**
     * Show students page
     * @return Renderable
     */
    public function index(Request $request)
    {
        $query = User::with('profile')->where('role', '!=', 'admin');

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
        // Validate the request
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,gif|max:5120',
            'biography' => 'nullable|string|max:1000',
        ]);

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
            if (config('settings.email_notification')) {
                try {
                    Mail::mailer(config('settings.email_provider'))
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
                'redirect' => route('admin.students')
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
            if (config('settings.email_notification')) {
                Mail::mailer(config('settings.email_provider'))
                    ->to($student->email)
                    ->send(new AccountDeletedConfirmation($student));
            }

            $student->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Account deleted successfully',
                'redirect' => route('admin.students')
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Account deletion failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to delete account'], 500);
        }
    }

    /**
     * Handle image upload and return the path
     */
    private function handleImageUpload($file)
    {
        try {

            $storagePath = 'students/';

            // Store new image
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $fullPath = $storagePath . $filename;

            // Resize and save
            $resizedImage = Image::read($file)->resize(1024, 1024);
            Storage::disk('public')->put($fullPath, $resizedImage->encode());

            // Store in the profile directory within storage/app/public
            return Storage::disk('public')->url($fullPath);
        } catch (Exception $e) {
            Log::error('Image upload failed: ' . $e->getMessage());
            return null;
        }
    }
}
