<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Index');
});


// User management routes - Admin only
Route::middleware(['auth', EnsureUserIsAdmin::class])->group(function () {
    Route::resource('customers', CustomerController::class);
    Route::resource('users', UserController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('contacts', ContactController::class);

});

// Image upload and removal routes
Route::middleware(['auth'])->group(function () {
    Route::post('/image/upload', [ImageController::class, 'upload'])->name('image.upload');
    Route::post('/image/remove', [ImageController::class, 'remove'])->name('image.remove');
});
