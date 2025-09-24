<?php

/*
|--------------------------------------------------------------------------
| Instructor Dashboard Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Instructor\InstructorDashboardController;
use App\Http\Controllers\Instructor\ManageInstructorCourseController;
use App\Http\Controllers\Instructor\ManageInstructorNotificationsController;
use App\Http\Controllers\Instructor\ManageInstructorProfileController;
use App\Http\Controllers\Instructor\ManageInstructorQuestionsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Instructor Routes
|--------------------------------------------------------------------------
*/
Route::prefix('instructor')
    ->name('instructor.')
    ->middleware(['auth', 'maintenance.mode', 'can:access-instructor-dashboard'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', InstructorDashboardController::class)->name('dashboard');

        // Profile Management
        Route::prefix('profile')
            ->name('profile.')
            ->controller(ManageInstructorProfileController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/update/profile', 'updateProfile')->name('update.profile');
                Route::post('/reset/password', 'resetPassword')->name('reset.password');
                Route::delete('/delete/profile', 'destroy')->name('destroy');
            });

        // Course Management
        Route::prefix('courses')
            ->name('courses.')
            ->controller(ManageInstructorCourseController::class)
            ->group(function () {
                // Course Listing and Deletion
                Route::get('/{course}/manage', 'index')->name('manage');

                Route::get('/module/{module}/quiz/create', 'create')->name('module.quiz.create');
                Route::post('/{course}/module/{module}/quizzes', 'store')->name('quizzes.store');

                Route::get('/quiz/{quiz}/edit', 'edit')->name('module.quiz.edit');
                Route::put('/quiz/{quiz}/update', 'update')->name('module.quiz.update');

                Route::delete('/quiz/{quiz}/delete', 'destroy')->name('module.quiz.delete');
            });

        // Questions & Answers
        Route::prefix('questions')
            ->name('questions.')
            ->controller(ManageInstructorQuestionsController::class)
            ->group(function () {
                Route::get('/{course}/questions', 'index')->name('index');
                Route::post('/{course}/questions/fetch', 'fetchQuestions')->name('fetch');

                Route::post('/replies/{course}/store', 'store')->name('reply.store');
                Route::put('/reply/{reply}/update', 'update')->name('reply.update');
                Route::delete('/reply/{reply}/destroy', 'destroy')->name('reply.destroy');

                Route::post('/like/toggle', 'toggleLike')->name('like.toggle');
            });

        // Notifications
        Route::prefix('notifications')
            ->name('notifications.')
            ->controller(ManageInstructorNotificationsController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/mark-all-read', 'markAllRead')->name('markAllRead');
                Route::delete('/delete-all', 'deleteAll')->name('deleteAll');
                Route::post('/{id}/mark-read', 'markAsRead');
                Route::delete('/{id}/delete', 'destroy');
            });

    });
