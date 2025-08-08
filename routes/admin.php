<?php

/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/dashboard', function () {
    echo 'Welcome admin..!!';
})->name('admin.dashboard')->middleware(['auth', 'can:access-admin-dashboard']);
