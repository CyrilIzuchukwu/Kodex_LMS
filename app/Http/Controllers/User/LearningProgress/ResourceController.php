<?php

namespace App\Http\Controllers\User\LearningProgress;

use App\Http\Controllers\Controller;
use App\Models\ModuleResource;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{
    public function download(ModuleResource $resource)
    {
        $path = $resource->resource_url;

        if (!Storage::exists($path)) {
            abort(404, 'File not found.');
        }

        return Storage::download($path, "Resource-$resource->id.pdf");
    }
}
