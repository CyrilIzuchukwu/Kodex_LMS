<?php

use App\Http\Controllers\Admin\AddCourseController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\EditCourseController;
use App\Http\Controllers\Admin\ManageCourseCategoryController;
use App\Http\Controllers\Admin\ManageCourseController;
use App\Http\Controllers\Admin\ManageInstructorsController;
use App\Http\Controllers\Admin\ManageSettingsController;
use App\Http\Controllers\Admin\ManageStudentsController;
use App\Http\Controllers\Admin\ManageProfileController;
use App\Http\Controllers\Admin\ManagePaymentMethodsController;
use App\Http\Controllers\Admin\ManageReportsController;
use App\Http\Controllers\Admin\ManageAnnouncementsController;
use App\Http\Controllers\Admin\ManageEmailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'can:access-admin-dashboard'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

        // Profile Management
        Route::prefix('profile')
            ->name('profile.')
            ->controller(ManageProfileController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/update/profile', 'updateProfile')->name('update.profile');
                Route::post('/reset/password', 'resetPassword')->name('reset.password');
            });

        // Settings Management
        Route::prefix('settings')
            ->name('settings.')
            ->controller(ManageSettingsController::class)
            ->group(function () {
                Route::get('/index', 'index')->name('index');
                Route::patch('/update/site', 'updateSite')->name('update.site');

                Route::get('/seo', 'seo')->name('seo');
                Route::patch('/update/seo', 'updateSeo')->name('update.seo');

                Route::get('/maintenance', 'maintenance')->name('maintenance');
                Route::patch('/update/maintenance', 'updateMaintenance')->name('update.maintenance');

                Route::get('/extensions', 'extensions')->name('extensions');
                Route::patch('/update/extensions', 'updateExtensions')->name('update.extensions');
            });

        // User Management
        Route::prefix('students')
            ->name('students.')
            ->controller(ManageStudentsController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');

                Route::get('/{student}', 'show')->name('show');

                Route::get('/{student}/edit', 'edit')->name('edit');
                Route::patch('/{student}/profile/update', 'update')->name('profile.update');

                Route::post('/{student}/update/picture', 'updatePicture')->name('picture.update');
                Route::post('/{student}/remove/picture', 'removePicture')->name('picture.remove');

                Route::post('/{student}/notify', 'sendNotification')->name('send.notification');
                Route::post('/{student}/reset/password', 'resetPassword')->name('reset.password');

                Route::patch('/{student}/suspend', 'suspend')->name('suspend');
                Route::patch('/{student}/unsuspend', 'unsuspend')->name('unsuspend');

                Route::post('/{student}/login', 'loginAsUser')->name('login');

                Route::delete('/{student}/delete', 'destroy')->name('destroy');
            });

        Route::prefix('instructors')
            ->name('instructors.')
            ->controller(ManageInstructorsController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');

                Route::get('/{instructor}', 'show')->name('show');

                Route::get('/{instructor}/edit', 'edit')->name('edit');
                Route::patch('/{instructor}/profile/update', 'update')->name('profile.update');

                Route::post('/{instructor}/update/picture', 'updatePicture')->name('picture.update');
                Route::post('/{instructor}/remove/picture', 'removePicture')->name('picture.remove');

                Route::post('/{instructor}/notify', 'sendNotification')->name('send.notification');
                Route::post('/{instructor}/reset/password', 'resetPassword')->name('reset.password');

                Route::patch('/{instructor}/suspend', 'suspend')->name('suspend');
                Route::patch('/{instructor}/unsuspend', 'unsuspend')->name('unsuspend');

                Route::post('/{instructor}/assign/course', 'assignCourse')->name('assign.course');
                Route::post('/{instructor}/login', 'loginAsUser')->name('login');

                Route::delete('/{instructor}/delete', 'destroy')->name('destroy');
            });

        // Course Management
        Route::prefix('courses')
            ->name('courses.')
            ->group(function () {
                // Course Listing and Deletion
                Route::get('/', [ManageCourseController::class, 'index'])->name('index');
                Route::delete('/delete/{course}', [ManageCourseController::class, 'destroy'])->name('destroy');

                // Add Course
                Route::prefix('add')
                    ->name('add.')
                    ->controller(AddCourseController::class)
                    ->group(function () {
                        Route::get('details', 'addDetails')->name('details');
                        Route::post('details', 'storeDetails')->name('store.details');
                        Route::get('outcomes', 'addCourseOutcomes')->name('outcomes');
                        Route::post('outcomes', 'storeCourseOutcomes')->name('store.outcomes');
                        Route::get('photos-videos', 'addPhotosAndVideos')->name('photos.videos');
                        Route::post('photos-videos', 'storePhotosAndVideos')->name('store.photos.videos');
                        Route::get('content', 'addCourseContent')->name('content');
                        Route::post('content', 'storeCourseContent')->name('store.content');
                    });

                // Edit Course
                Route::prefix('edit/{course}')
                    ->name('edit.')
                    ->controller(EditCourseController::class)
                    ->group(function () {
                        Route::get('details', 'editDetails')->name('details');
                        Route::put('details', 'updateDetails')->name('update.details');
                        Route::get('outcomes', 'editCourseOutcomes')->name('outcomes');
                        Route::put('outcomes', 'updateCourseOutcomes')->name('update.outcomes');
                        Route::get('photos-videos', 'editPhotosAndVideos')->name('photos.videos');
                        Route::put('photos-videos', 'updatePhotosAndVideos')->name('update.photos.videos');
                        Route::get('content', 'editCourseContent')->name('content');
                        Route::put('content', 'updateCourseContent')->name('update.content');
                    });
            });

        // Course Categories
        Route::prefix('categories')
            ->name('categories.')
            ->controller(ManageCourseCategoryController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{slug}', 'show')->name('show');
                Route::put('/{category}', 'update')->name('update');
                Route::delete('/{category}', 'destroy')->name('destroy');
            });

        // Payment method Management
        Route::prefix('payment-methods')
            ->name('payment-methods.')
            ->controller(ManagePaymentMethodsController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::put('/{gateway}/update', 'update')->name('update');
            });

        // Reports
        Route::prefix('reports')
            ->name('reports.')
            ->controller(ManageReportsController::class)
            ->group(function () {
                Route::get('/transactions', 'transactions')->name('transactions');
                Route::get('/transactions/{transaction}/show', 'showTransaction')->name('transaction.show');

                Route::patch('/transactions/{transaction}/approve', 'approveTransaction')->name('transaction.approve');
                Route::patch('/transactions/{transaction}/cancel', 'cancelTransaction')->name('transaction.cancel');
                Route::patch('/transactions/{transaction}/review', 'reviewTransaction')->name('transaction.review');
                Route::post('/transactions/{transaction}/note', 'noteTransaction')->name('transaction.note');

                Route::get('/logins', 'logins')->name('logins');
            });

        // Announcements
        Route::prefix('announcements')
            ->name('announcements.')
            ->controller(ManageAnnouncementsController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
            });

        // Email Management
        Route::prefix('email')
            ->name('email.')
            ->controller(ManageEmailController::class)
            ->group(function () {
                Route::get('/config', 'config')->name('config');
                Route::patch('/update', 'update')->name('update');
                Route::get('/send', 'test')->name('send');
                Route::post('/send', 'send')->name('send');
            });
    });

