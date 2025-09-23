<?php

// storage link
Route::get('/link-storage', function () {
    Artisan::call('storage:link');
    return 'Storage linked successfully';
});

// Redirect to auth
Route::get('/', function () {
    Auth::logout();
    return redirect()->route('login');
});

// Production Routes
require __DIR__.'/auth.php';
require __DIR__ .'/admin.php';
require __DIR__ . '/user.php';
require __DIR__ .'/instructor.php';

