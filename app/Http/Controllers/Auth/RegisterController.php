<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerificationNotification;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Random\RandomException;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /**
     * Show the application registration form.
     *
     * @return RedirectResponse|Renderable
     */
    public function index(): RedirectResponse|Renderable
    {
        if (!config('settings.register.enabled')) {
            return redirect()->back()->with('error', 'Registration disabled. Please contact the administrator.');
        }

        return view('auth.register', [
            'title' => 'Let\'s Get Started',
            'social_login' => config('settings.social_login.enabled'),
        ]);
    }

    /**
     * Validate the user's email before proceeding to onboard them
     *
     * @param Request $request
     * @return RedirectResponse|Renderable
     * @throws RandomException
     */
    public function register(Request $request): RedirectResponse|Renderable
    {
        if (!config('settings.register.enabled')) {
            return redirect()->back()->with('error', 'Registration disabled. Please contact the administrator.');
        }

        $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email',
        ]);

        // Throttle settings
        $throttleDelay = 60; // 60 seconds

        if (RateLimiter::tooManyAttempts($this->throttleKey($request->email), 1)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request->email));
            return back()->withErrors([
                'email' => __('Please wait a minute before retrying.'),
                'throttle' => $seconds
            ]);
        }

        RateLimiter::hit($this->throttleKey($request->email), $throttleDelay);

        // Generate a token and set expiration (20 minutes from now)
        $token = random_int(1000, 9999);
        $expiration = Carbon::now()->addMinutes(20);

        // Store the validated data in session with expiration
        $request->session()->put('user.details', [
            'email' => $request->email,
            'token' => $token,
            'expires_at' => $expiration
        ]);

        // Send email
        if (email_settings()->status ?? config('settings.email_notification')) {
            try {
                Mail::mailer(email_settings()->provider ?? config('settings.email_provider'))
                    ->to($request->email)
                    ->send(new EmailVerificationNotification($token, $request->email));
            } catch (Exception $e) {
                Log::error('Failed to send OTP email', ['email' => $request->email, 'error' => $e->getMessage()]);
                return redirect()->back()->with('error', __('Failed to send OTP. Please try again later.'));
            }
        }

        return redirect()->route('email.verify')->with('success',  __('An otp code has been sent to your email.'));
    }

    protected function throttleKey(string $email): string
    {
        return 'verify-email|'.$email;
    }
}
