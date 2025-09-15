<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Monnify
{
    /**
     * Get Monnify Authentication Token
     *
     * @return string
     * @throws Exception
     */
    protected static function getAuthToken(): string
    {
        self::validateEnvironment();

        $apiKey = config('services.monnify.api_key');
        $secretKey = config('services.monnify.secret_key');
        $authString = base64_encode("$apiKey:$secretKey");

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $authString,
            'Content-Type' => 'application/json',
        ])->post('https://sandbox.monnify.com/api/v1/auth/login');

        $data = self::handleResponse($response);

        if (!($data['requestSuccessful'] ?? false)) {
            throw new Exception('Failed to authenticate with Monnify: ' . ($data['responseMessage'] ?? 'No message'));
        }

        return $data['responseBody']['accessToken'] ?? throw new Exception('Access token missing in Monnify response.');
    }

    /**
     * Initialize a Monnify transaction.
     *
     * @param $payment
     * @return array
     * @throws ConnectionException
     * @throws Exception
     */
    public static function initializeTransaction($payment): array
    {
        self::validateEnvironment();
        self::validateAmount((int)$payment->total);

        // Get authenticated user
        $user = Auth::user();

        $accessToken = self::getAuthToken();

        $payload = [
            'amount' => (int)$payment->total,
            'customerName' => $user->name,
            'customerEmail' => $user->email,
            'paymentReference' => uniqid('MONNIFY_', true),
            'paymentDescription' => config('app.name'),
            'currencyCode' => 'NGN',
            'contractCode' => config('services.monnify.contract_code'),
            'redirectUrl' => route('user.callback.monnify'),
            'metaData' => [
                'payment_id' => $payment->id
            ]
        ];

        $response = Http::withToken($accessToken)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post('https://sandbox.monnify.com/api/v1/merchant/transactions/init-transaction', $payload);

        return self::handleResponse($response);
    }

    /**
     * Verify Monnify transaction
     *
     * @param string $transactionReference
     * @return array
     * @throws Exception
     */
    public static function verifyTransaction(string $transactionReference): array
    {
        $accessToken = self::getAuthToken();

        $url = 'https://sandbox.monnify.com/api/v1/merchant/transactions/query?paymentReference=' . urlencode($transactionReference);

        $response = Http::withToken($accessToken)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->get($url);

        return self::handleResponse($response);
    }

    /**
     * Validate required environment variables
     *
     * @throws Exception
     */
    protected static function validateEnvironment(): void
    {
        if (!config('services.monnify.api_key') || !config('services.monnify.secret_key') || !config('services.monnify.contract_code')) {
            throw new Exception('Monnify environment variables are not properly configured.');
        }
    }

    /**
     * Validate that amount is greater than zero
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
     * Handle API response
     *
     * @param Response $response
     * @return array
     * @throws Exception
     */
    protected static function handleResponse(Response $response): array
    {
        if ($response->failed()) {
            Log::error('Monnify API Error', ['body' => $response->body()]);
            throw new Exception('Monnify API error: ' . $response->body());
        }

        return $response->json();
    }
}
