<?php

namespace App\Services;

use App\Models\Transaction;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;

class PaymentHandlerService
{
    /**
     * Process the payment based on the provided data.
     *
     * @param Transaction $payment
     * @return array
     */
    public static function processPayment(Transaction $payment): array
    {
        // Get the selected gateway
        $gateway = $payment->payment_method;

        try {

            // Handle donation based on the selected gateway
            return match ($gateway) {
                'Paystack' => self::processPaystackDonation($payment),
                'Flutterwave' => self::processFlutterwaveDonation($payment),
                "Monnify" => self::processMonnifyDonation($payment),
                "Stripe" => self::processStripeDonation($payment),
                default => [
                    'status' => 'error',
                    'message' => 'Unsupported payment gateway.'
                ],
            };
        } catch (Exception $e) {
            // Log the exception if any error occurs
            Log::error('Payment processing failed: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Handle Paystack donation.
     *
     * @param Transaction $payment
     * @return array
     * @throws Exception
     */
    private static function processPaystackDonation(Transaction $payment): array
    {
        $responseData = Paystack::initializeTransaction(
            $payment
        );

        if ($responseData['status'] === true) {
            return [
                'status' => 'success',
                'authorization_url' => $responseData['data']['authorization_url']
            ];
        }

        return [
            'status' => 'error',
            'message' => $responseData['message']
        ];
    }

    /**
     * Handle Flutterwave donation.
     *
     * @param Transaction $payment
     * @return array
     * @throws Exception
     */
    private static function processFlutterwaveDonation(Transaction $payment): array
    {
        $responseData = Flutterwave::initializeTransaction(
            $payment
        );

        if ($responseData['status'] === 'success') {
            return [
                'status' => 'success',
                'authorization_url' => $responseData['data']['link']
            ];
        }

        return [
            'status' => 'error',
            'message' => $responseData['message']
        ];
    }

    /**
     * Handle Monnify donation.
     *
     * @param Transaction $payment
     * @return array
     * @throws ConnectionException
     */
    private static function processMonnifyDonation(Transaction $payment): array
    {
        $responseData = Monnify::initializeTransaction(
            $payment
        );

        if ($responseData['requestSuccessful'] === true) {
            return [
                'status' => 'success',
                'authorization_url' => $responseData['responseBody']['checkoutUrl']
            ];
        }

        return [
            'status' => 'error',
            'message' => $responseData['message']
        ];
    }

    /**
     * @param $payment
     * @return array
     * @throws ApiErrorException
     */
    private static function processStripeDonation($payment): array
    {
        $responseData = StripePayment::initializeTransaction(
            $payment
        );

        return [
            'status' => 'success',
            'authorization_url' => $responseData
        ];
    }
}
