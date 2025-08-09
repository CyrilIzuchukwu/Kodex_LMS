<?php

/*
|--------------------------------------------------------------------------
| User Dashboard Routes
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Route;

Route::get('/user/dashboard', function () {
    echo 'Welcome to kodex user dashboard';
})->name('user.dashboard')->middleware(['auth', 'can:access-user-dashboard']);
