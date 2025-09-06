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

Route::get('/user/my-learning', function () {
    return view('user.my-learning');
})->name('user.my-learning');



Route::get('/user/course-watch', function () {
    return view('user.course-watch');
})->name('user.course-watch');

Route::get('/user/courses', function () {
    return view('user.courses');
})->name('user.courses');


// route to course that belong to a particular category
Route::get('/user/more-course', function () {
    return view('user.more-courses');
})->name('user.more-courses');


Route::get('/user/course-details', function () {
    return view('user.course-details');
})->name('user.course-details');


Route::get('/user/carts', function () {
    return view('user.carts');
})->name('user.carts');


Route::get('/user/settings', function () {
    return view('user.settings');
})->name('user.settings');


Route::get('/user/carts', function () {
    return view('user.carts');
})->name('user.carts');
