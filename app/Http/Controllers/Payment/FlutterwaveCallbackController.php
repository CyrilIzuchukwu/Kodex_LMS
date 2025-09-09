<?php

namespace App\Http\Controllers\Payment;

use App\Services\Flutterwave;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FlutterwaveCallbackController extends BasePaymentController
{
    /**
     * Handle Flutterwave payment callback
     * @throws \Throwable
     */
    public function flutterwave(Request $request): RedirectResponse
    {
        try {
            // Validate and verify the transaction
            $postData = $this->validateFlutterwaveRequest($request);

            if ($postData['status'] === 'cancelled') {
                Log::info("Payment cancelled by user", ['tx_ref' => $postData['tx_ref']]);

                $payment_id = $request->session()->get('payment.details', []);
                return redirect()->route('user.payment.cancelled', $payment_id['payment_id']);
            }

            $responseData = Flutterwave::verifyTransaction($postData['transaction_id']);

            // Check if the transaction was successful
            if (!$this->isFlutterwaveTransactionSuccessful($responseData)) {
                return $this->failedFlutterwaveTransactionResponse($responseData);
            }

            // Extract transaction details
            $transactionDetails = $this->extractFlutterwaveTransactionDetails($responseData);

            // Update transaction
            $this->updateTransactionRecord($transactionDetails);

            // Get updated transaction details
            $payment = $this->getPaymentOrFail($transactionDetails['payment_id']);

            // Redirect to success page with payment_id
            return $this->successfulPaymentResponse($payment);

        } catch (Exception $e) {
            Log::error('Flutterwave Callback Error: ' . $e->getMessage());

            $payment_id = $request->session()->get('payment.details', []);
            return redirect()->route('user.payment.failed', $payment_id['payment_id'])
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Validate Flutterwave request.
     */
    protected function validateFlutterwaveRequest(Request $request): array
    {
        return $request->validate([
            'status' => 'required|string|in:successful,completed,failed,cancelled',
            'transaction_id' => 'required_if:status,successful,completed',
            'tx_ref' => 'required|string'
        ]);
    }

    /**
     * Extract relevant details from Flutterwave response.
     */
    private function extractFlutterwaveTransactionDetails(array $responseData): array
    {
        $meta = $responseData['data']['meta'] ?? [];

        return [
            'reference' => $responseData['data']['tx_ref'],
            'channel' => $responseData['data']['payment_type'],
            'amount' => $responseData['data']['amount'],
            'payment_id' => $meta['payment_id'] ?? null
        ];
    }

    /**
     * Check if the Flutterwave transaction is successful.
     */
    protected function isFlutterwaveTransactionSuccessful(array $responseData): bool
    {
        return $responseData['status'] == 'success';
    }

    /**
     * Redirect to failed transaction page (without a donation_id fallback).
     */
    protected function failedFlutterwaveTransactionResponse(array $responseData): RedirectResponse
    {
        $payment_id = $responseData['data']['meta']['payment_id'] ?? null;

        if ($payment_id) {
            return redirect()->route('user.payment.failed', $payment_id)
                ->with('error', $responseData['message']);
        }

        return redirect()->route('user.courses')
            ->with('error', $responseData['message']);
    }
}
