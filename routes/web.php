<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Index');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('companies', CompanyController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('customers', CustomerController::class);
});

// User management routes - Admin only
Route::middleware(['auth', EnsureUserIsAdmin::class])->group(function () {
    Route::resource('users', UserController::class);
});

// Image upload and removal routes
Route::middleware(['auth'])->group(function () {
    Route::post('/image/upload', [ImageController::class, 'upload'])->name('image.upload');
    Route::post('/image/remove', [ImageController::class, 'remove'])->name('image.remove');
});
