<?php

/*
|--------------------------------------------------------------------------
| User Dashboard Routes
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Route;


Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->name('user.dashboard');


Route::get('/user/course-details', function () {
    return view('user.course-details');
})->name('user.course-details');


Route::get('/user/carts', function () {
    return view('user.carts');
})->name('user.carts');