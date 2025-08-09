<?php

/*
|--------------------------------------------------------------------------
| Instructor Dashboard Routes
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Route;

Route::get('/instructor/dashboard', function () {
    echo 'Welcome to kodex user dashboard';
})->name('instructor.dashboard')->middleware(['auth', 'can:access-instructor-dashboard']);
