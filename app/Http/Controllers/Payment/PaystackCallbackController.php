<?php

namespace App\Http\Controllers\Payment;

use App\Services\Paystack;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class PaystackCallbackController extends BasePaymentController
{
    /**
     * Handle Paystack payment callback.
     * @throws Throwable
     */
    public function paystack(Request $request): RedirectResponse
    {
        try {
            // Validate and verify the transaction
            $postData = $this->validatePaystackRequest($request);
            $responseData = Paystack::verifyTransaction($postData['reference']);

            // Check if the transaction was successful
            if (!$this->isTransactionSuccessful($responseData)) {
                return $this->failedTransactionResponse($responseData);
            }

            // Extract transaction details
            $transactionDetails = $this->extractPaystackTransactionDetails($responseData);

            // Get updated transaction details
            $payment = $this->getPaymentOrFail($transactionDetails['payment_id']);

            // Redirect to success page with payment_id
            return $this->successfulPaymentResponse($payment, $transactionDetails);

        } catch (Exception $e) {
            Log::error('Paystack Callback Error: ' . $e->getMessage());

            $payment_id = $request->session()->get('payment.details', []);
            return redirect()->route('user.payment.failed', $payment_id['payment_id'])
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Validate Paystack request.
     */
    protected function validatePaystackRequest(Request $request): array
    {
        return $request->validate([
            'trxref' => 'required|string',
            'reference' => 'required|string',
        ]);
    }

    /**
     * Extract relevant details from Paystack response.
     */
    private function extractPaystackTransactionDetails(array $responseData): array
    {
        $metadata = $responseData['data']['metadata'] ?? [];

        return [
            'reference' => $responseData['data']['reference'],
            'channel' => $responseData['data']['channel'],
            'amount' => $responseData['data']['amount'] / 100,
            'payment_id' => $metadata['payment_id'] ?? null
        ];
    }

    /**
     * Check if the Paystack transaction is successful.
     */
    protected function isTransactionSuccessful(array $responseData): bool
    {
        return $responseData['status'] == 1 && $responseData['data']['status'] === 'success';
    }

    /**
     * Redirect to failed transaction page (without a payment_id fallback).
     */
    protected function failedTransactionResponse(array $responseData): RedirectResponse
    {
        $payment_id = $responseData['data']['metadata']['payment_id'] ?? null;

        if ($payment_id) {
            return redirect()->route('user.payment.failed', $payment_id)
                ->with('error', $responseData['message']);
        }

        return redirect()->route('user.courses')
            ->with('error', $responseData['message']);
    }
}
