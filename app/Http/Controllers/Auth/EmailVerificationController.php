<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerificationNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EmailVerificationController extends Controller
{
    /**
     * Show the email verification form.
     *
     * @param Request $request
     * @return RedirectResponse|Renderable
     */
    public function verify(Request $request): RedirectResponse|Renderable
    {
        if (!$this->hasValidSession($request)) {
            return redirect()
                ->route('register')
                ->with('error', __('Your verification session has expired or is invalid. Please request a new one.'));
        }

        $sessionDetails = $request->session()->get('user.details', []);

        return view('auth.email.verify', [
            'title' => 'Enter Verification Code',
            'email' => $sessionDetails['email']
        ]);
    }

    /**
     * Handle OTP verification.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        if (!$this->hasValidSession($request)) {
            return redirect()
                ->route('register')
                ->with('error', __('Your verification session has expired or is invalid. Please request a new one.'));
        }

        $sessionDetails = $request->session()->get('user.details', []);

        // validate request
        $validator = Validator::make($request->all(), [
            'otp' => ['required', 'string', 'size:4', 'regex:/^[0-9]+$/'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Type-safe OTP comparison
        if ($request->otp !== (string)$sessionDetails['token']) {
            return back()->withErrors(['otp' => __('Invalid verification code.')]);
        }

        // Redirect to onboarding with a success message
        return redirect()->route('onboarding')->with([
            'success' => __('Your email has been verified successfully.'),
        ]);
    }

    /**
     * Resend OTP to the user's email.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function resend(Request $request)
    {
        try {

            if (!$this->hasValidSession($request)) {
                return response()->json(['error' => __('Your verification session has expired or is invalid.')], 422);
            }

            $sessionDetails = $request->session()->get('user.details', []);
            $email = $sessionDetails['email'];

            // Generate new OTP
            $token = sprintf("%04d", random_int(1000, 9999));
            $expiration = Carbon::now()->addMinutes(30);
            $retryTime = Carbon::now()->addMinutes(5);

            // Update session
            $request->session()->put('user.details', [
                'email' => $email,
                'token' => $token,
                'expires_at' => $expiration
            ]);

            // Send email
            if (email_settings()->status ?? config('settings.email_notification')) {
                try {
                    Mail::mailer(email_settings()->provider ?? config('settings.email_provider'))
                        ->to($email)
                        ->send(new EmailVerificationNotification($token, $email));
                } catch (Exception $e) {
                    Log::error('Failed to send OTP email', ['email' => $email, 'error' => $e->getMessage()]);
                    return response()->json(['error' => __('Failed to send OTP. Please try again later.')], 500);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => __('A new OTP has been sent to your email.'),
                'retryTime' => $retryTime
            ]);
        }catch (Exception $exception){
            Log::error('Failed to resend OTP: ' . $exception->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    /**
     * Check if the session is valid and not expired.
     *
     * @param Request $request
     * @return bool
     */
    protected function hasValidSession(Request $request): bool
    {
        if (!$request->session()->has('user.details')) {
            return false;
        }

        $sessionDetails = $request->session()->get('user.details', []);
        return isset($sessionDetails['expires_at']) && !Carbon::now()->greaterThan(Carbon::parse($sessionDetails['expires_at']));
    }
}
