<?php

namespace App\Http\Controllers\User\LearningProgress;

use App\Http\Controllers\Controller;
use App\Models\ModuleResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    public function download(ModuleResource $resource)
    {
        // Load the module
        $resource = $resource->load('module');

        // Parse the resource URL to extract the path
        $parsedUrl = parse_url($resource->resource_url, PHP_URL_PATH);

        // Remove the leading '/storage/' to get the relative path
        $relativePath = preg_replace('#^/storage/#', '', $parsedUrl);

        // Validate the relative path
        if (empty($relativePath) || $relativePath === $parsedUrl) {
            abort(400, 'Invalid resource URL.');
        }

        // Check if the file exists in the storage disk
        if (!Storage::disk('public')->exists($relativePath)) {
            abort(404, 'File not found.');
        }

        // Get the file extension
        $extension = pathinfo($relativePath, PATHINFO_EXTENSION);

        // Sanitize the module title or use a fallback
        $safeTitle = $resource->module && $resource->module->title
            ? Str::slug($resource->module->title)
            : "resource-$resource->id";

        // Generate a random string for uniqueness
        $randomString = Str::random(8);

        // Use a more descriptive and unique file name
        $fileName = "Resource-$safeTitle-$randomString.$extension";

        // Initiate the download
        return Storage::disk('public')->download($relativePath, $fileName);
    }
}
