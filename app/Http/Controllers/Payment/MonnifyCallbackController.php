<?php

namespace App\Http\Controllers\Payment;

use App\Services\Monnify;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class MonnifyCallbackController extends BasePaymentController
{
    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     * @throws Throwable
     */
    public function monnify(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'paymentReference' => 'required|string'
            ]);

            // Validate and verify the transaction
            $responseData = Monnify::verifyTransaction($request->input('paymentReference'));

            if ($responseData['responseBody']['paymentStatus'] === "PAID") {

                // Extract transaction details
                $transactionDetails = $this->extractMonnifyTransactionDetails($responseData);

                // Get updated transaction details
                $payment = $this->getPaymentOrFail($transactionDetails['payment_id']);

                // Redirect to success page with payment_id
                return $this->successfulPaymentResponse($payment, $transactionDetails);
            }

            $payment_id = $request->session()->get('payment.details', []);
            if ($responseData['responseBody']['paymentStatus'] == 'PENDING') {
                Log::info("Payment cancelled by user", ['tx_ref' => $request->input('paymentReference')]);
                return redirect()
                    ->route('user.payment.failed', $payment_id['payment_id'])
                    ->with('tx_ref', $request->input('paymentReference'));
            }

            Log::error("Payment failed", ['status' => $responseData['responseBody']['paymentStatus'], 'tx_ref' => $request->input('paymentReference')]);
            return redirect()
                ->route('user.payment.failed', $payment_id['payment_id'])
                ->with([
                    'error' => 'Payment failed. Please try again.',
                    'tx_ref' => $request->input('paymentReference')
                ]);
        }catch (Exception $exception) {
            $payment_id = $request->session()->get('payment.details', []);
            return redirect()->route('user.payment.failed', $payment_id['payment_id'])
                ->with('error', 'An error occurred: ' . $exception->getMessage());
        }
    }

    /**
     * @param array $responseData
     * @return array
     */
    private function extractMonnifyTransactionDetails(array $responseData): array
    {
        return [
            'reference' => $responseData['responseBody']['paymentReference'],
            'channel' => $responseData['responseBody']['paymentMethod'],
            'amount' => $responseData['responseBody']['amount'],
            'payment_id' => $responseData['responseBody']['metaData']['payment_id']
        ];
    }
}
