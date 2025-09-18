<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Route;

class PaymentStatusController extends Controller
{
    /**
     * Show a payment success page with a confirmation message
     */
    public function success(Request $request, string $payment)
    {
        return $this->paymentStatusView(
            title: 'Payment Successful',
            defaultMessage: 'Your payment for the course was successfully processed! You now have access to your course. Check your email for confirmation and access details.',
            request: $request,
            payment: $payment
        );
    }

    /**
     * Show payment failed page with an error message
     */
    public function failed(Request $request, string $payment)
    {
        return $this->paymentStatusView(
            title: 'Payment Failed',
            defaultMessage: 'We couldn\'t process your payment for the course. This might be due to insufficient funds, incorrect card details, or bank restrictions. Please try again with a different payment method or contact your bank for more information.',
            request: $request,
            retry: true,
            payment: $payment
        );
    }

    /**
     * Show payment canceled page with message
     */
    public function cancelled(Request $request, string $payment)
    {
        return $this->paymentStatusView(
            title: 'Payment Cancelled',
            defaultMessage: 'You cancelled the payment process before completing the course purchase. If this was accidental, you can retry the payment from the course checkout page.',
            request: $request,
            retry: true,
            payment: $payment
        );
    }

    /**
     * Show payment error page with message
     */
    public function error(Request $request, string $payment)
    {
        return $this->paymentStatusView(
            title: 'Payment Error',
            defaultMessage: 'We encountered an issue while processing your course payment. Our team has been notified. Please try again later or contact support if the issue persists.',
            request: $request,
            retry: true,
            payment: $payment
        );
    }

    /**
     * Shared view renderer for payment status pages
     */
    protected function paymentStatusView(string $title, string $defaultMessage, Request $request, bool $retry = false, string $payment = null)
    {
        $user_id = Auth::id();
        $payment = Transaction::findOrFail($payment);

        // Get any additional data from the session
        $txRef = $request->session()->get('tx_ref');

        // Decode cart items and fetch the courses
        $cartItems = json_decode($payment->cart_items, true) ?? [];
        $courseIds = array_column($cartItems, 'course_id');
        $courses = Course::whereIn('id', $courseIds)->with('category')->get();

        // Get unique category IDs from the cart courses
        $categoryIds = $courses->pluck('category_id')->unique()->toArray();

        // Fetch related courses from the same categories, excluding the cart courses
        $relatedCourses = Course::with(['category', 'profile.user'])
            ->inRandomOrder()
            ->whereIn('category_id', $categoryIds)
            ->whereNotIn('id', $courseIds)
            ->whereNotIn('id', function ($query) use ($user_id) {
                $query->select('course_id')
                    ->from('course_enrollments')
                    ->where('user_id', $user_id);
            })
            ->orderBy('title', 'ASC')
            ->latest()
            ->limit(2)
            ->get();

        if (Route::is('user.payment.success')){
            return view('user.payments.success', [
                'title' => $title,
                'errorMessage' => $defaultMessage,
                'txRef' => $txRef,
                'payment' => $payment,
                'retry' => $retry,
                'courses' => $courses,
                'relatedCourses' => $relatedCourses,
            ]);
        }

        return view('user.payments.status', [
            'title' => $title,
            'errorMessage' => $defaultMessage,
            'txRef' => $txRef,
            'payment' => $payment,
            'retry' => $retry,
            'courses' => $courses,
            'relatedCourses' => $relatedCourses,
        ]);
    }
}
