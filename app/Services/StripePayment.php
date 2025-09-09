<?php

namespace App\Services;

use App\Models\Donation;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

class StripePayment
{
    /**
     * @param $payment
     * @return string|null
     * @throws ApiErrorException
     */
    public static function initializeTransaction($payment): ?string
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        // Get authenticated user
        $user = Auth::user();

        $session = Session::create([
            'payment_method_types' => ['card'],
            'customer_email' => $user->email,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'ngn',
                    'product_data' => [
                        'name' => config('app.name'),
                    ],
                    'unit_amount' => (int)$payment->total * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('user.callback.stripe') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('user.payment.cancelled', $payment->id),
            'metadata' => [
                'payment_id' => $payment->id
            ]
        ]);

        return $session->url;
    }
}
