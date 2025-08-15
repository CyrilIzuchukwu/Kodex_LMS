<?php

/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ManageInstructorsControllers;
use App\Http\Controllers\Admin\ManageStudentsControllers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::controller(AdminDashboardController::class)
        ->middleware(['auth', 'can:access-admin-dashboard'])
        ->group(function () {
            // Dashboard home
            Route::get('/dashboard', 'index')->name('dashboard');

            // User management
            Route::controller(ManageStudentsControllers::class)->group(function () {
                Route::get('/students', 'index')->name('students');

                Route::post('/students/store', 'store')->name('students.store');

                Route::get('/students/{student}/show', 'show')->name('students.show');

                Route::get('/students/{student}/edit', 'edit')->name('students.edit');
                Route::put('/students/{student}', 'update')->name('students.update');

                Route::delete('/students/{student}', 'destroy')->name('students.destroy');
            });

            // Instructors management
            Route::controller(ManageInstructorsControllers::class)->group(function () {
                Route::get('/instructors', 'index')->name('instructors');
            });
        });
});
