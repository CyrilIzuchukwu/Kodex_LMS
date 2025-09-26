<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ManageCouponCodesController extends Controller
{
    /**
     * Display a listing of the coupons.
     *
     */
    public function index()
    {
        $coupons = Coupon::latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.coupon-codes.index', [
            'title' => 'Coupon Codes',
            'coupons' => $coupons
        ]);
    }

    /**
     * Store a newly created coupon in storage.
     *
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|min:3|max:20|unique:coupons,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after:valid_from',
            'is_active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $coupon = Coupon::create([
            'code' => Str::upper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'valid_from' => Carbon::parse($request->valid_from),
            'valid_to' => Carbon::parse($request->valid_to),
            'is_active' => $request->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon created successfully',
            'coupon' => $coupon
        ], 201);
    }

    /**
     * Update the specified coupon in storage.
     *
     */
    public function update(Request $request, Coupon $coupon)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|min:3|max:20|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after:valid_from',
            'is_active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $coupon->update([
            'code' => Str::upper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'valid_from' => Carbon::parse($request->valid_from),
            'valid_to' => Carbon::parse($request->valid_to),
            'is_active' => $request->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon updated successfully',
            'coupon' => $coupon
        ]);
    }

    /**
     * Remove the specified coupon from storage.
     *
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return response()->json([
            'success' => true,
            'message' => 'Coupon deleted successfully'
        ]);
    }
}
