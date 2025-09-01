<?php

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OnboardingController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\Auth\SocialLoginController;
use Illuminate\Support\Facades\Route;

Route::middleware(['redirect.authenticated'])->group(function () {
    // Authentication Routes
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::post('/login', 'login')->name('login.store');
    });

    // Registration Routes
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'index')->name('register');
        Route::post('/register', 'register')->name('register.store');
    });

    // Verification Routes
    Route::controller(EmailVerificationController::class)->group(function () {
        Route::get('/email/verify', 'verify')->name('email.verify');
        Route::get('/email/verify/resend', 'resend')->name('email.verify.resend');
        Route::post('/email/verify/store', 'store')->name('email.verify.store');
    });

    // Onboarding Routes
    Route::controller(OnboardingController::class)->group(function () {
        Route::get('/onboarding', 'index')->name('onboarding');
        Route::post('/onboarding/store', 'store')->name('onboarding.store');
    });

    // Password Reset Routes
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('/password/reset', 'create')->name('password.request');
        Route::post('/password/email', 'store')->name('password.email');
        Route::get('/password/reset/{token}', 'edit')->name('password.reset');
        Route::post('/password/update', 'update')->name('password.update');
    });

    // Social Login
    Route::controller(SocialLoginController::class)->group(function () {
        Route::get('social/{provider}', 'redirectToProvider')->name('social.redirect');
        Route::get('social/callback/{provider}', 'handleProviderCallback')->name('social.callback');
    });
});


/*
|--------------------------------------------------------------------------
| Logout Routes
|--------------------------------------------------------------------------
*/
Route::prefix('logout')
    ->middleware('auth')
    ->controller(SessionController::class)
    ->group(function () {
        Route::post('/', 'destroy')->name('logout');
        Route::post('/current-session/{sessionId}', 'destroySession')->name('logout.current');
        Route::delete('/all-sessions', 'destroyAllSessions')->name('logout.all');
        Route::post('social/{provider}/disconnect', 'invokeAccount')->name('social.disconnect');
    });

