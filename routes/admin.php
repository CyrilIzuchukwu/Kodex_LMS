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
