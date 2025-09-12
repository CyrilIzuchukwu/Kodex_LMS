<?php

use App\Http\Controllers\Payment\FlutterwaveCallbackController;
use App\Http\Controllers\Payment\MonnifyCallbackController;
use App\Http\Controllers\Payment\PaymentStatusController;
use App\Http\Controllers\Payment\PaystackCallbackController;
use App\Http\Controllers\Payment\StripeCallbackController;
use App\Http\Controllers\User\ManageUserProfileController;
use App\Http\Controllers\User\ManageUserReportsController;
use App\Http\Controllers\User\UserCartController;
use App\Http\Controllers\User\UserCourseController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserLearningController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::prefix('user')
    ->name('user.')
    ->middleware(['auth', 'can:access-user-dashboard'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', UserDashboardController::class)->name('dashboard');

        // Profile Management
        Route::prefix('profile')
            ->name('profile.')
            ->controller(ManageUserProfileController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/update/profile', 'updateProfile')->name('update.profile');
                Route::post('/reset/password', 'resetPassword')->name('reset.password');
                Route::delete('/delete/profile', 'destroy')->name('destroy');
            });

        // Learning Routes
        Route::controller(UserLearningController::class)->group(function () {
            Route::get('/my-learning', 'myLearning')->name('my.learning');
            Route::get('/my-purchases', 'myCoursesPurchases')->name('my.purchases');
            Route::get('/course/watch/{slug}/module/{module}', 'courseWatch')->name('course.watch');
            Route::get('/course/{slug}/module/{module}/quiz', 'courseQuiz')->name('course.quiz.start');
            Route::post('/course/{slug}/module/{module}/quiz/submit', 'submitQuiz')->name('course.quiz.submit');
            Route::get('/course/certificate/{slug}/download', 'courseCertificate')->name('course.certificate.download');
        });

        // Course Routes
        Route::controller(UserCourseController::class)->group(function () {
            Route::get('/courses', 'index')->name('courses');
            Route::get('/more-course', 'moreCourses')->name('more.courses');
            Route::get('/course/{slug}', 'courseDetails')->name('course.details');
        });

        // Cart Routes
        Route::controller(UserCartController::class)->group(function () {
            Route::get('/cart', 'index')->name('cart');

            Route::post('/cart/add/{course}', 'add')->name('cart.add');
            Route::get('/cart/count', 'count')->name('cart.count');

            Route::post('/cart/apply/coupon', 'applyCoupon')->name('cart.apply.coupon');
            Route::post('/cart/checkout', 'checkout')->name('cart.checkout');

            Route::delete('/cart/remove', 'remove')->name('cart.remove');
        });

        // Reports
        Route::prefix('reports')
            ->name('reports.')
            ->controller(ManageUserReportsController::class)
            ->group(function () {
                Route::get('/transactions', 'transactions')->name('transactions');
                Route::get('/logins', 'logins')->name('logins');
            });

        // Payment Callback Routes
        Route::prefix('callback')->name('callback.')->group(function () {
            Route::get('/paystack', [PaystackCallbackController::class, 'paystack'])->name('paystack');
            Route::get('/flutterwave', [FlutterwaveCallbackController::class, 'flutterwave'])->name('flutterwave');
            Route::get('/monnify', [MonnifyCallbackController::class, 'monnify'])->name('monnify');
            Route::get('/stripe', [StripeCallbackController::class, 'stripe'])->name('stripe');
        });

        // Payment Error Routes
        Route::prefix('payment')->name('payment.')->group(function () {
            Route::get('/success/{payment}', [PaymentStatusController::class, 'success'])->name('success');
            Route::get('/failed/{payment}', [PaymentStatusController::class, 'failed'])->name('failed');
            Route::get('/cancelled/{payment}', [PaymentStatusController::class, 'cancelled'])->name('cancelled');
            Route::get('/error/{payment}', [PaymentStatusController::class, 'error'])->name('error');
        });
    });
