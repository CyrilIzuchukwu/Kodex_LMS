<?php

use App\Http\Controllers\Payment\FlutterwaveCallbackController;
use App\Http\Controllers\Payment\MonnifyCallbackController;
use App\Http\Controllers\Payment\PaymentStatusController;
use App\Http\Controllers\Payment\PaystackCallbackController;
use App\Http\Controllers\Payment\StripeCallbackController;
use App\Http\Controllers\User\LearningProgress\CertificateController;
use App\Http\Controllers\User\LearningProgress\LearningController;
use App\Http\Controllers\User\LearningProgress\NoteController;
use App\Http\Controllers\User\LearningProgress\QuestionController;
use App\Http\Controllers\User\LearningProgress\QuestionReplyController;
use App\Http\Controllers\User\LearningProgress\QuizController;
use App\Http\Controllers\User\LearningProgress\ResourceController;
use App\Http\Controllers\User\ManageUserProfileController;
use App\Http\Controllers\User\ManageUserReportsController;
use App\Http\Controllers\User\UserCartController;
use App\Http\Controllers\User\UserCourseController;
use App\Http\Controllers\User\UserDashboardController;
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

        // Course Routes
        Route::controller(UserCourseController::class)->group(function () {
            Route::get('/courses', 'index')->name('courses');
        });

        // Learning Management
        Route::prefix('course')
            ->name('course.')
            ->group(function () {

                // Course Details Routes
                Route::controller(UserCourseController::class)->group(function () {
                    Route::get('/details/{slug}', 'courseDetails')->name('details');
                });

                // Learning Routes
                Route::controller(LearningController::class)->group(function () {
                    Route::get('/my-learning', 'myLearning')->name('my.learning');
                    Route::get('/my-purchases', 'myCoursesPurchases')->name('my.purchases');

                    Route::get('/watch/{course}/module/{module}', 'watch')->name('watch');
                });

                // Quiz Routes
                Route::controller(QuizController::class)->group(function () {
                    Route::get('/{course}/module/{module}/quiz', 'courseQuiz')->name('quiz.start');
                    Route::post('/{course}/module/{module}/quiz/submit', 'submitQuiz')->name('quiz.submit');
                });

                // Resource Routes
                Route::controller(ResourceController::class)->group(function () {
                    Route::get('/resource/{resource}/download', 'download')->name('resource.download');
                });

                // Certificate Routes
                Route::controller(CertificateController::class)->group(function () {
                    Route::get('/certificate/{course}/download', 'courseCertificate')->name('certificate.download');
                });

                // Questions Routes
                Route::controller(QuestionController::class)->group(function () {
                    Route::post('/{course}/questions/fetch', 'fetchQuestions')->name('questions.fetch');
                    Route::post('/questions/{course}/store', 'store')->name('questions.store');
                    Route::put('/question/{question}/update', 'update')->name('questions.update');
                    Route::delete('/question/{question}/destroy', 'destroy')->name('questions.destroy');
                });

                // Question Replies Routes
                Route::controller(QuestionReplyController::class)->group(function () {
                    Route::post('/replies/{course}/store', 'store')->name('replies.store');
                    Route::put('/reply/{reply}/update', 'update')->name('replies.update');
                    Route::delete('/reply/{reply}/destroy', 'destroy')->name('replies.destroy');
                });

                // Notes Routes
                Route::controller(NoteController::class)->group(function () {
                    Route::post('/notes/{course}/store', 'store')->name('notes.store');
                    Route::put('/note/{note}/update', 'update')->name('notes.update');
                    Route::delete('/note/{note}/destroy', 'destroy')->name('notes.destroy');
                });
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
                Route::get('/transactions/{transaction}/show', 'showTransaction')->name('transactions.show');
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
