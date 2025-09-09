<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Flutterwave
{
    /**
     * Initialize a payment request to Flutterwave.
     *
     * @param $payment
     * @return array
     * @throws Exception
     */
    public static function initializeTransaction($payment): array
    {
        self::validateEnvironment();
        self::validateAmount((int)$payment->total);

        // Get authenticated user
        $user = Auth::user();

        $payload = [
            "tx_ref" => "txn_" . time(),
            "amount" => (int)$payment->total,
            "currency" => "NGN",
            "redirect_url" =>  route('user.callback.flutterwave'),
            "payment_options" => "card, banktransfer, ussd",
            "customer" => [
                "email" => $user->email,
                "phone_number" => $user->profile?->phone_number,
                "name" => $user->name,
            ],
            "customizations" => [
                "title" => config('app.name'),
                "logo" => asset('storage/logo/favicon.png'),
            ],
            "meta" => [
                "payment_id" => $payment->id
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.flutterwave.secret_key'),
                'Content-Type' => 'application/json'
            ])->post('https://api.flutterwave.com/v3/payments', $payload);

            return self::handleResponse($response);
        } catch (Exception $e) {
            Log::error('Flutterwave payment initialization failed: ' . $e->getMessage());
            throw new Exception('Failed to initialize Flutterwave payment: ' . $e->getMessage());
        }
    }

    /**
     * Verify a payment with Flutterwave.
     *
     * @param string $transactionId
     * @return array
     * @throws Exception
     */
    public static function verifyTransaction(string $transactionId): array
    {
        self::validateEnvironment();

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.flutterwave.secret_key'),
                'Cache-Control' => 'no-cache'
            ])->get("https://api.flutterwave.com/v3/transactions/$transactionId/verify");

            return self::handleResponse($response);
        } catch (Exception $e) {
            Log::error('Flutterwave payment verification failed: ' . $e->getMessage());
            throw new Exception('Failed to verify Flutterwave payment: ' . $e->getMessage());
        }
    }

    /**
     * Validate that required environment variables are set.
     *
     * @throws Exception
     */
    protected static function validateEnvironment(): void
    {
        if (empty(config('services.flutterwave.secret_key'))) {
            throw new Exception('Flutterwave secret key is not configured.');
        }
    }

    /**
     * Validate that the amount is greater than zero.
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
     * Handle the HTTP response and check for errors.
     *
     * @param Response $response
     * @return array
     * @throws Exception
     */
    protected static function handleResponse(Response $response): array
    {
        if ($response->failed()) {
            throw new Exception("Flutterwave API error: " . $response->body());
        }

        return $response->json();
    }
}
