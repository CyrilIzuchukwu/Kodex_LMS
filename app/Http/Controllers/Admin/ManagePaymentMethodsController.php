<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ManagePaymentMethodsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gateways = Gateway::query()
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.payments-methods.index', [
            'title' => 'Payments Methods',
            'gateways' => $gateways
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gateway $gateway)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old icon if it exists
            if ($gateway->icon && Storage::exists('public/gateways/' . $gateway->icon)) {
                Storage::delete('public/gateways/' . $gateway->icon);
            }

            // Store new image
            $storagePath = 'gateways/';
            $filename = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();
            $fullPath = $storagePath . $filename;

            // Resize and save
            $resizedImage = Image::read($request->file('image'))->resize(124, 124);
            Storage::disk('public')->put($fullPath, $resizedImage->encode());
            $gateway->icon = asset('storage/' . $fullPath);
        }

        // Update gateway details
        $gateway->name = $request->name;
        $gateway->status = $request->status;
        $gateway->save();

        return response()->json([
            'success' => true,
            'message' => 'Payment gateway updated successfully',
            'data' => $gateway,
        ]);
    }
}
