<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ManageInstructorsController;
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
    });


Route::get('/admin/payments', function () {
    return view('admin.payments');
});
