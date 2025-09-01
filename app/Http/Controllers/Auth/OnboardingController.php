<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Throwable;

class OnboardingController extends Controller
{
    /**
     * Where to redirect users after registration.
     *
     * @return string
     */
    protected function redirectTo(): string
    {
        if (Gate::allows('access-admin-dashboard')) {
            return route('admin.dashboard');
        }

        if (Gate::allows('access-user-dashboard')) {
            return route('user.dashboard');
        }

        if (Gate::allows('access-instructor-dashboard')) {
            return route('instructor.dashboard');
        }

        Auth::logout();
        return route('login');
    }

    /**
     * Display the onboarding form.
     *
     * @param Request $request
     * @return RedirectResponse|View
     */
    public function index(Request $request)
    {
        if (!$this->hasValidSession($request)) {
            return redirect()
                ->route('register')
                ->with('error', __('Your verification session has expired or is invalid. Please request a new one.'));
        }

        return view('auth.onboarding', [
            'title' => __('Onboarding & Account Creation'),
            'email' => $request->session()->get('user.details.email'),
        ]);
    }

    /**
     * Handle account creation.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws Throwable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', Password::defaults()]
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);

            event(new Registered($user));
            Auth::login($user);

            // Send welcome email if enabled
            if (email_settings()->status ?? config('settings.email_notification')) {
                Mail::mailer(email_settings()->provider ?? config('settings.email_provider'))
                    ->to($user->email)
                    ->queue(new WelcomeEmail($user));
            }

            DB::commit();

            // Clear only onboarding-related session data
            $request->session()->forget('user.details');

            return redirect($this->redirectTo())
                ->with('success', __('Your account has been created successfully.'));
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Account creation failed', [
                'error' => $exception->getMessage(),
                'email' => $request->email,
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Failed to create account. Please try again.'));
        }
    }

    /**
     * Validate the session data for onboarding.
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
        $expiresAt = data_get($sessionDetails, 'expires_at');

        return $expiresAt && Carbon::now()->lessThanOrEqualTo(Carbon::parse($expiresAt));
    }
}
