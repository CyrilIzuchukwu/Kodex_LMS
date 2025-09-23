<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExtensionsSetting;
use App\Models\MaintenanceMode;
use App\Models\SeoSetting;
use App\Models\Settings;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Throwable;

class ManageSettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.site', [
            'title' => 'Site Settings',
        ]);
    }

    /**
     * Update the site settings in storage.
     *
     */
    public function updateSite(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'site_name' => ['required', 'string', 'max:255'],
            'site_email' => ['nullable', 'email', 'max:255'],
            'site_phone' => ['nullable', 'string', 'max:255'],
            'site_address' => ['nullable', 'string', 'max:255'],
            'site_fb' => ['nullable', 'url', 'max:255'],
            'site_instagram' => ['nullable', 'url', 'max:255'],
            'site_linkedin' => ['nullable', 'url', 'max:255'],
            'site_youtube' => ['nullable', 'url', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proceed with validated data
        $validated = $validator->validated();

        try {

            // Retrieve the current site settings
            $settings = Settings::firstOrNew();

            // Update the site settings
            $settings->fill([
                'site_name' => $validated['site_name'],
                'site_email' => $validated['site_email'],
                'site_phone' => $validated['site_phone'],
                'site_address' => $validated['site_address'],
                'site_fb' => $validated['site_fb'],
                'site_instagram' => $validated['site_instagram'],
                'site_linkedin' => $validated['site_linkedin'],
                'site_youtube' => $validated['site_youtube'],
            ])->save();

            return redirect()->back()->with('success', 'Site Settings Updated Successfully');
        } catch (Exception $e) {
            Log::error('Error updating site settings: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating site settings');
        }
    }

    public function seo()
    {
        return view('admin.settings.seo', [
            'title' => 'SEO',
        ]);
    }

    /**
     * Update SEO settings.
     *
     * @throws Throwable
     */
    public function updateSeo(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'meta_title' => 'required|string|max:60',
            'meta_description' => 'required|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'seo_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'og_title' => 'nullable|string|max:95',
            'og_description' => 'nullable|string|max:200',
            'robots' => 'nullable|string',
            'twitter_card' => 'nullable|string|in:summary,summary_large_image',
            'remove_seo_image' => 'nullable|in:1,true',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proceed with validated data
        $validated = $validator->validated();

        try {

            DB::beginTransaction();

            // Handle image deletion
            if ($request->filled('remove_seo_image')) {
                $this->deleteSeoImage();
                $validated['seo_image'] = null;
            }

            // Handle new image upload
            if ($request->hasFile('seo_image')) {
                // Delete old image if it exists
                $this->deleteSeoImage();

                // Resize and store new image
                $image = $request->file('seo_image');
                $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $path = 'seo_images/' . $filename;

                // Initialize Intervention Image with GD driver
                $manager = new ImageManager(new Driver());
                $img = $manager->read($image)->resize(1920, 1080);

                // Store the resized image
                Storage::disk('public')->put($path, $img->encode());

                // Store relative path
                $validated['seo_image'] = asset('storage/' . $path);
            } else {
                // Prevent overwriting seo_image with null if no new image is uploaded
                unset($validated['seo_image']);
            }

            // Update or create SEO settings
            SeoSetting::updateOrCreate(
                ['id' => seo_settings()->id ?? null],
                $validated
            );

            DB::commit();
            return redirect()->back()->with('success', 'SEO settings updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('SEO update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update SEO settings. Please try again.');
        }
    }

    public function maintenance()
    {
        return view('admin.settings.maintenance', [
            'title' => 'Site Maintenance',
        ]);
    }

    public function updateMaintenance(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'maintenance_mode' => 'boolean',
            'maintenance_message' => 'nullable|string|max:500',
            'maintenance_end' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proceed with validated data
        $validated = $validator->validated();

        $validated['maintenance_mode'] = $request->maintenance_mode  ?? 0;

        $maintenance_mode = MaintenanceMode::firstOrCreate([]);
        $maintenance_mode->update($validated);

        return redirect()->back()->with('success', 'Maintenance mode settings updated successfully.');
    }

    public function extensions ()
    {
        return view('admin.settings.extensions', [
            'title' => 'Extensions',
        ]);
    }

    public function updateExtensions(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'google_tag'        => 'nullable|string|max:255',
            'smartsupp_key'     => 'nullable|string|max:255',
            'zoho_salesiq'      => 'nullable|string',
            'whatsapp_number'   => 'nullable|string|max:20',
            'telegram_username' => 'nullable|string|max:50',
            'intercom_app_id'   => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proceed with validated data
        $data = $validator->validated();

        $settings = ExtensionsSetting::first();
        if ($settings) {
            $settings->update($data);
        } else {
            ExtensionsSetting::create($data);
        }

        return back()->with('success', 'Extensions settings updated successfully.');
    }

    /**
     * Delete the existing SEO image if it exists.
     */
    protected function deleteSeoImage()
    {
        $oldImage = seo_settings()->seo_image ?? '';
        if ($oldImage) {
            // Handle both full URL and relative path cases
            $relativePath = str_replace(config('app.url') . Storage::url(''), '', $oldImage);
            $relativePath = ltrim($relativePath, '/');
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }
    }
}
