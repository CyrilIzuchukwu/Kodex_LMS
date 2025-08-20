<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ManageCourseCategoryController;
use App\Http\Controllers\Admin\ManageCourseController;
use App\Http\Controllers\Admin\ManageInstructorsController;
use App\Http\Controllers\Admin\ManagePaymentsController;
use App\Http\Controllers\Admin\ManageSettingsController;
use App\Http\Controllers\Admin\ManageStudentsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'can:access-admin-dashboard'])
    ->group(function () {

        // Dashboard home
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

        // Student management routes
        Route::controller(ManageStudentsController::class)
            ->prefix('/students')
            ->name('students.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{student}', 'show')->name('show');
                Route::get('/{student}/edit', 'edit')->name('edit');
                Route::put('/{student}', 'update')->name('update');
                Route::delete('/{student}', 'destroy')->name('destroy');
            });

        // Instructor management routes
        Route::controller(ManageInstructorsController::class)
            ->prefix('/instructors')
            ->name('instructors.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
            });


        // Payment management routes
        Route::controller(ManagePaymentsController::class)
            ->prefix('/payments')
            ->name('payments.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
            });

        // Settings management routes
        Route::controller(ManageSettingsController::class)
            ->prefix('/settings')
            ->name('settings.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
            });

        // Course category management routes
        Route::controller(ManageCourseCategoryController::class)
            ->prefix('/categories')
            ->name('categories.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{slug}', 'show')->name('show');
                Route::put('/{category}', 'update')->name('update');
                Route::delete('/{category}', 'destroy')->name('destroy');
            });

        // Courses management routes
        Route::controller(ManageCourseController::class)
            ->prefix('/courses')
            ->name('courses.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{slug}', 'show')->name('show');
                Route::put('/{category}', 'update')->name('update');
                Route::delete('/{category}', 'destroy')->name('destroy');
            });
    });
