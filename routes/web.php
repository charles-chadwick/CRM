<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Index');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('companies', CompanyController::class);
});

// User management routes - Admin only
Route::middleware(['auth', \App\Http\Middleware\EnsureUserIsAdmin::class])->group(function () {
    Route::resource('users', UserController::class);
});
