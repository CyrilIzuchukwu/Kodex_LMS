<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetConfirmation;
use App\Models\UserProfile;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Jenssegers\Agent\Agent;

class ManageSettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings', [
            'title' => 'Settings',
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,gif|max:5120',
        ], [
            'profile_image.image' => 'The file must be an image.',
            'profile_image.mimes' => 'Only JPEG, PNG, or GIF files are allowed.',
            'profile_image.max' => 'The image size must not exceed 5MB.',
        ]);

        try {
            $user = Auth::user();

            // Handle profile photo upload
            $profilePhotoPath = null;
            if ($request->hasFile('profile_image')) {
                $profilePhotoPath = $this->handleImageUpload($request->file('profile_image'), $user);
                if (!$profilePhotoPath) {
                    return redirect()->back()->withErrors(['profile_image' => 'Failed to upload profile photo. Please try again.']);
                }
            }

            // Update the user
            $user->update([
                'name' => $validated['name'],
            ]);

            // Store data for user profile
            $profileData = [];
            if ($profilePhotoPath) {
                $profileData['profile_photo_path'] = $profilePhotoPath;
            }

            // Create or update user profile
            UserProfile::updateOrCreate(
                ['user_id' => $user->id],
                $profileData
            );

            return redirect()->back()->with('success', __('Your personal details have been updated successfully.'));
        } catch (Exception $exception) {
            Log::error('Failed to update profile: ' . $exception->getMessage());
            return redirect()->back()->with('error', __('Failed to update profile'));
        }
    }

    /**
     * Update the user's password.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        // Validate the request data
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ], [
            'current_password.required' => 'Current password is required.',
            'password.required' => 'New password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $user = Auth::user();

        // Verify the current password
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->with('error', __('The current password is incorrect.'))->withInput();
        }

        // Update the user's password
        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);

        // Send email
        if (config('settings.email_notification')) {
            Mail::mailer(config('settings.email_provider'))
                ->to($user->email)
                ->send(new PasswordResetConfirmation(
                    $user,
                    $request->ip(),
                    $this->getDevice($request->userAgent())
                ));
        }

        // Return appropriate response
        return redirect()->back()
            ->with('success', __('Your password has been updated successfully.'));
    }

    /**
     * Handle image upload and return the path
     */
    private function handleImageUpload($file, $user)
    {
        try {
            // Verify the file is a valid image
            if (!getimagesize($file)) {
                throw new Exception('Invalid image file.');
            }

            // Delete old image if exists
            if ($user->profile && $user->profile->profile_photo_path) {
                Storage::disk('public')->delete($user->profile->profile_photo_path);
            }

            $storagePath = 'admin/';
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
