<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Gateway;
use App\Models\Transaction;
use App\Services\PaymentHandlerService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UserCartController extends Controller
{
    /**
     * Show cart page
     */
    public function index()
    {
        $user_id = Auth::id();
        $cartItems = CartItem::with(['course.profile.user', 'course.media'])
            ->where('user_id', $user_id)
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->course->price;
        });

        // Apply the discount from session if present
        $discount = session('discount', 0);
        $applied_coupon = session('applied_coupon', '');

        $charges = $subtotal * config('settings.vat_rate', 0.075); // Calculate 7.5% of subtotal
        $total = $subtotal + $charges - $discount;

        $gateways = Gateway::where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();

        return view('user.cart.index', [
            'title' => 'Your Cart',
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'charges' => $charges,
            'total' => $total,
            'gateways' => $gateways,
            'discount' => $discount,
            'applied_coupon' => $applied_coupon,
        ]);
    }

    /**
     * Add Items to cart
     *
     * @param Course $course
     * @return JsonResponse
     */
    public function add(Course $course): JsonResponse
    {
        sleep(1);

        $user_id = Auth::id();
        $cartItem = CartItem::where('user_id', $user_id)
            ->where('course_id', $course->id)
            ->first();

        if ($cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'This course is already in your cart.',
            ], 422);
        }

        $enrolled = CourseEnrollment::where('user_id', $user_id)
            ->where('course_id', $course->id)
            ->first();

        if ($enrolled) {
            return response()->json([
                'success' => false,
                'message' => 'You are already enrolled in this course.',
            ], 422);
        }

        CartItem::create([
            'user_id' => $user_id,
            'course_id' => $course->id,
        ]);

        $cartCount = CartItem::where('user_id', $user_id)->count();

        return response()->json([
            'success' => true,
            'message' => 'Course added to cart',
            'cartCount' => $cartCount,
        ]);
    }

    /**
     * Apply coupons and discounts
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function applyCoupon(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'coupon' => 'required|string|exists:coupons,code',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'error'
            ], 422);
        }

        // Fetch the coupon
        $coupon = Coupon::where('code', $request->coupon)
            ->where('valid_from', '<=', now())
            ->where('valid_to', '>=', now())
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            return response()->json(['message' => 'Invalid or expired coupon.'], 400);
        }

        // Get current cart items
        $cartItems = Auth::user()->cartItems;
        $subtotal = $cartItems->sum(function ($item) {
            return $item->course->price;
        });

        // Apply discount
        $discount = 0;
        if ($coupon->type === 'percentage') {
            $discount = $subtotal * ($coupon->value / 100);
        } elseif ($coupon->type === 'fixed') {
            $discount = $coupon->value;
        }

        // Ensure discount doesn't exceed subtotal
        $discount = min($discount, $subtotal);

        $charges = $subtotal * config('settings.vat_rate', 0.075); // 7.5% VAT
        $total = $subtotal + $charges - $discount;

        // Store the applied coupon in session
        session()->put('applied_coupon', $coupon->code);
        session()->put('discount', $discount);

        return response()->json([
            'subtotal' => $subtotal,
            'charges' => $charges,
            'discount' => $discount,
            'total' => $total,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function checkout(Request $request)
    {
        DB::beginTransaction();

        try {

            // Initialize $cartItems as an empty collection
            $cartItems = collect();

            // Check authentication
            if (!Auth::check()) {
                DB::rollBack();
                return redirect()->back()->with('error', 'You must be logged in to checkout.');
            }

            // Validate payment methods from cache
            $paymentMethods = cache()->remember('payment_gateways', now()->addHours(), function () {
                return DB::table('gateways')->pluck('name')->toArray();
            });

            // Validate input
            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric|min:1',
                'coupon' => [
                    'nullable',
                    'string',
                    function ($attribute, $value, $fail) {
                        $coupon = Coupon::where('code', $value)
                            ->where('valid_from', '<=', now())
                            ->where('valid_to', '>=', now())
                            ->where('is_active', true)
                            ->first();
                        if (!$coupon) {
                            $fail('The coupon is invalid or expired.');
                        }
                    },
                ],
                'payment_method' => 'required|string|in:' . implode(',', $paymentMethods),
                'terms' => 'required|accepted',
            ], [
                'payment_method.required' => 'Please select your preferred payment method.',
                'terms.required' => 'Please agree to the terms and conditions.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            // Proceed with validated data
            $validated = $validator->validated();

            // Get cart items
            $cartItems = Auth::user()->cartItems;
            if ($cartItems->isEmpty()) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Your cart is empty.');
            }

            // Calculate totals
            $subtotal = $cartItems->sum(function ($item) {
                return $item->course->price;
            });
            $vatRate = config('settings.vat_rate', 0.075);
            $charges = $subtotal * $vatRate;

            // Apply discount
            $discount = 0;
            $coupon = $validated['coupon'] ? Coupon::where('code', $validated['coupon'])->first() : null;
            if ($coupon) {
                if ($coupon->type === 'percentage') {
                    $discount = $subtotal * ($coupon->value / 100);
                } elseif ($coupon->type === 'fixed') {
                    $discount = $coupon->value;
                } else {
                    throw new Exception('Invalid coupon type: ' . $coupon->type);
                }
                $discount = min($discount, $subtotal);
            }

            $total = $subtotal + $charges - $discount;
            if ($total < 0) {
                throw new Exception('Total amount cannot be negative.');
            }

            // Validate amount
            if ((int)$validated['amount'] != (int)$total) {
                throw new Exception('The provided amount does not match the calculated total.');
            }

            // Prepare data for transaction
            $cartData = $cartItems->map(function ($item) {
                return [
                    'course_id' => $item->course->id,
                    'price' => $item->course->price,
                ];
            });
            $data = [
                'user_id' => Auth::id(),
                'cart_items' => json_encode($cartData),
                'subtotal' => $subtotal,
                'charges' => $charges,
                'discount' => $discount,
                'total' => $total,
                'amount' => $validated['amount'],
                'coupon' => $validated['coupon'] ?? null,
                'payment_method' => $validated['payment_method'],
            ];

            // Create transaction
            $payment = Transaction::create($data);

            // Store payment_id in session
            $request->session()->put('payment.details', [
                'payment_id' => $payment->id
            ]);

            // Process payment
            try {
                $result = (new PaymentHandlerService())->processPayment($payment);
                if (empty($result['authorization_url'])) {
                    throw new Exception('Payment processing failed: No authorization URL returned.');
                }
            } catch (Exception $e) {
                throw new Exception('Payment processing failed: ' . $e->getMessage());
            }

            DB::commit();
            return redirect()->away($result['authorization_url']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Payment Failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id() ?? 'guest',
                'payment_id' => $payment->id ?? null,
                'cart_items' => $cartItems->toArray() ?? [],
            ]);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * @throws Throwable
     */
    public function remove(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:cart_items,id',
        ]);

        DB::beginTransaction();

        try {

            $user_id = Auth::id();
            $cartItem = CartItem::where('user_id', $user_id)->findOrFail($request->cart_id);
            $cartItem->delete();

            // Clear session after successful item removal to avoid price conflicts
            session()->forget(['applied_coupon', 'discount']);

            DB::commit();

            return redirect()->route('user.cart')->with('success', 'Course removed from cart');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Cart item removal failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', __('Cart item removal failed'));
        }
    }

    public function count(): JsonResponse
    {
        $user_id = Auth::id();
        $cartCount = CartItem::where('user_id', $user_id)->count();

        return response()->json([
            'success' => true,
            'cartCount' => $cartCount,
        ]);
    }
}
