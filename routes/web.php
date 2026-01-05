<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyTypeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SaleLeadProgressController;
use App\Http\Controllers\SalesLeadController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Dashboard route
Route::get('/', function () {
    return Inertia::render('Dashboard');
})
    ->middleware('auth')
    ->name('dashboard');


// User management routes - Admin only
Route::middleware([
    'auth',
])
    ->group(function () {

        Route::get('/discussions/{on_type}/{on_id}', [
            DiscussionController::class,
            'create'
        ])
            ->name('discussions.create');
        Route::get('/discussions/{discussion}', [
            DiscussionController::class,
            'show'
        ])
            ->name('discussions.show');
        Route::post('/discussions', [
            DiscussionController::class,
            'store'
        ])
            ->name('discussions.store');
        Route::post('/discussions/{discussion}/reply', [
            DiscussionController::class,
            'reply'
        ])
            ->name('discussions.reply');
        Route::delete('/discussions/{post}', [
            DiscussionController::class,
            'destroyPost'
        ])
            ->name('discussions.posts.destroy');
        Route::resource('customers', CustomerController::class);
        Route::resource('users', UserController::class);
        Route::resource('companies', CompanyController::class);
        Route::resource('company-types', CompanyTypeController::class);
        Route::resource('contacts', ContactController::class);
        Route::resource('sales-leads', SalesLeadController::class);
        Route::resource('sale-lead-progress', SaleLeadProgressController::class);
        Route::get('/activity/database/{on}/{id}', [
            ActivityController::class,
            'database'
        ])
            ->name('activity.database');

        Route::get('/activity/user-access/{user}', [
            ActivityController::class,
            'userAccess'
        ])
            ->name('activity.user-access');


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