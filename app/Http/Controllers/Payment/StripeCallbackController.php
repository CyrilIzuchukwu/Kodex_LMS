<?php

namespace App\Http\Controllers\Payment;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Throwable;

class StripeCallbackController extends BasePaymentController
{
    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Throwable
     */
    public function stripe(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'session_id' => 'required|string'
            ]);

            // Validate and verify the transaction
            Stripe::setApiKey(config('services.stripe.secret'));
            $responseData = Session::retrieve($request->get('session_id'));

            if ($responseData['payment_status'] === 'paid' && $responseData['status'] === 'complete') {

                // Extract transaction details
                $transactionDetails = $this->extractStripeTransactionDetails($responseData);

                // Get updated transaction details
                $payment = $this->getPaymentOrFail($transactionDetails['payment_id']);

                // Redirect to success page with payment_id
                return $this->successfulPaymentResponse($payment, $transactionDetails);
            }

            $payment_id = $request->session()->get('payment.details', []);
            Log::error("Payment failed", ['status' => $responseData['status'], 'tx_ref' => $responseData['payment_intent']]);
            return redirect()
                ->route('user.payment.failed', $payment_id['payment_id'])
                ->with([
                    'error' => 'Payment failed. Please try again.',
                    'tx_ref' => $responseData['payment_intent']
                ]);

        } catch (Exception $exception) {
            $payment_id = $request->session()->get('payment.details', []);
            return redirect()->route('user.payment.failed', $payment_id['payment_id'])
                ->with('error', 'An error occurred: ' . $exception->getMessage());
        }
    }

    /**
     * @param Session $responseData
     * @return array
     */
    private function extractStripeTransactionDetails(Session $responseData): array
    {
        return [
            'reference' => $responseData['payment_intent'],
            'channel' => implode(',', $responseData['payment_method_types']),
            'amount' => $responseData['amount_total'] / 100,
            'payment_id' => $responseData['metadata']['payment_id']
        ];
    }
}
