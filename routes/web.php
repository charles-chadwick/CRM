<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyTypeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Dashboard');
})
    ->name('dashboard');


// User management routes - Admin only
Route::middleware([
    'auth',
    EnsureUserIsAdmin::class
])
    ->group(function () {

        Route::post('/discussions', [DiscussionController::class, 'store'])->name('discussions.store');
        Route::post('/discussions/{discussion}/reply', [DiscussionController::class, 'reply'])->name('discussions.reply');
        Route::delete('/discussion-posts/{post}', [DiscussionController::class, 'destroyPost'])->name('discussions.posts.destroy');
        Route::resource('customers', CustomerController::class);
        Route::resource('users', UserController::class);
        Route::resource('companies', CompanyController::class);
        Route::resource('company-types', CompanyTypeController::class);
        Route::resource('contacts', ContactController::class);
        Route::get('/activity/{on}/{id}', [
            ActivityController::class,
            'index'
        ])
            ->name('activity.index');

        Route::post('/image/upload', [
            ImageController::class,
            'upload'
        ])
            ->name('image.upload');
        Route::post('/image/remove', [
            ImageController::class,
            'remove'
        ])
            ->name('image.remove');

    });