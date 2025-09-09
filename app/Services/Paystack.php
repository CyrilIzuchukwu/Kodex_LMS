<?php

namespace App\Services;

use Auth;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Paystack
{
    /**
     * Initializes a transaction with Paystack.
     *
     * @param $payment
     * @return array Response from Paystack.
     * @throws Exception If an error occurs during the request.
     */
    public static function initializeTransaction($payment): array
    {
        self::validateEnvironment();
        self::validateAmount((int)$payment->total);

        // Get authenticated user
        $user = Auth::user();

        try {
            // Prepare API request
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.paystack.secret_key'),
                'Cache-Control' => 'no-cache',
            ])->post('https://api.paystack.co/transaction/initialize', [
                'email' => $user->email,
                'amount' => (int)$payment->total * 100, // Amount in kobo
                'callback_url' => route('user.callback.paystack'),
                'metadata' => [
                    'cancel_action' => route('user.payment.cancelled', $payment->id),
                    'payment_id' => $payment->id
                ]
            ]);

            return self::handleResponse($response);
        } catch (Exception $e) {
            Log::error('Paystack transaction initialization failed: ' . $e->getMessage());
            throw new Exception('Failed to initialize Paystack transaction: ' . $e->getMessage());
        }
    }

    /**
     * Verifies a Paystack transaction.
     *
     * @param string $reference Transaction reference from Paystack.
     * @return array Response from Paystack.
     * @throws Exception If an error occurs during the request.
     */
    public static function verifyTransaction(string $reference): array
    {
        self::validateEnvironment();

        try {
            // Verify transaction with Paystack
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.paystack.secret_key'),
                'Cache-Control' => 'no-cache',
            ])->get("https://api.paystack.co/transaction/verify/$reference");

            return self::handleResponse($response);
        } catch (Exception $e) {
            Log::error('Paystack transaction verification failed: ' . $e->getMessage());
            throw new Exception('Failed to verify Paystack transaction: ' . $e->getMessage());
        }
    }

    /**
     * Validate that required environment variables are set
     *
     * @throws Exception
     */
    protected static function validateEnvironment(): void
    {
        if (empty(config('services.paystack.secret_key'))) {
            throw new Exception('Paystack secret key is not configured.');
        }
    }

    /**
     * Validate that the amount is greater than zero
     *
     * @param int|float $amount
     * @throws Exception
     */
    protected static function validateAmount(int|float $amount): void
    {
        if ($amount <= 0) {
            throw new Exception('Amount must be greater than zero.');
        }
    }

    /**
     * Handle the API response
     *
     * @param Response $response
     * @return array
     * @throws Exception
     */
    protected static function handleResponse(Response $response): array
    {
        if ($response->failed()) {
            $error = $response->json();
            $message = $error['message'] ?? 'Paystack API request failed';
            throw new Exception($message);
        }

        return $response->json();
    }
}
