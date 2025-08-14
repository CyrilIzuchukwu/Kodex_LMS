<?php

/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Route;

Route::get('/admin/dashboard', function () {
    // echo 'Welcome admin..!!';
    return view('admin.index');
})->name('admin.dashboard')->middleware(['auth', 'can:access-admin-dashboard']);


Route::get('/admin/students', function () {
    return view('admin.students');
})->name('admin.students')->middleware(['auth', 'can:access-admin-dashboard']);


Route::get('/admin/instructors', function () {
    return view('admin.instructors');
})->name('admin.instructors')->middleware(['auth', 'can:access-admin-dashboard']);
