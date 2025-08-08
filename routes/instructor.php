<?php

/*
|--------------------------------------------------------------------------
| Instructor Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::get('/instructor/dashboard', function () {
    echo 'Welcome to kodex user dashboard';
})->name('instructor.dashboard')->middleware(['auth', 'can:access-instructor-dashboard']);
