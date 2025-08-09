<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/signin', function () {
    return view('HTML_MARKUP.auth.login');
});

Route::get('/newAccount', function () {
    return view('HTML_MARKUP.auth.newAccount');
});

Route::get('/newPassword', function () {
    return view('HTML_MARKUP.auth.newPassword');
});

Route::get('/getStarted', function () {
    return view('HTML_MARKUP.auth.getStarted');
});

Route::get('/enterVCode', function () {
    return view('HTML_MARKUP.auth.enterVCode');
});

Route::get('/enterVCode2', function () {
    return view('HTML_MARKUP.auth.enterVCode2');
});

Route::get('/forgotPassword', function () {
    return view('HTML_MARKUP.auth.forgotPassword');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/gab.php';


