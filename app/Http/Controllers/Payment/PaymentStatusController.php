<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentStatusController extends Controller
{
    /**
     * Show payment success page with a confirmation message
     */
    public function success(Request $request, string $payment)
    {
        return $this->paymentStatusView(
            title: 'Course Payment Successful',
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
            title: 'Course Payment Failed',
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
            title: 'Course Payment Cancelled',
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
            title: 'Course Payment Error',
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
        $payment = Transaction::findOrFail($payment);

        // Get any flashed error message from session
        $errorMessage = $request->session()->get('error', $defaultMessage);

        // Get any additional data from the session
        $txRef = $request->session()->get('tx_ref');

        return view('user.payments.status', [
            'title' => $title,
            'errorMessage' => $errorMessage,
            'txRef' => $txRef,
            'sessionData' => $payment,
            'retry' => $retry,
        ]);
    }
}
