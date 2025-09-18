<?php

/*
|--------------------------------------------------------------------------
| Instructor Dashboard Routes
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Route;

// Route::get('/instructor/dashboard', function () {
//     echo 'Welcome to kodex user dashboard';
// })->name('instructor.dashboard')->middleware(['auth', 'can:access-instructor-dashboard']);


Route::get('/instructor/dashboard', function () {
    return view('instructor.dashboard');
})->name('instructor.dashboard');


Route::get('admin/module-question', function () {
    return view('instructor.question');
})->name('admin.module.question');
