<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Guest routes
Route::middleware('guest')
    ->group(function () {
        Route::get('login', [
            AuthenticatedSessionController::class,
            'create'
        ])
            ->name('login');
        Route::post('login', [
            AuthenticatedSessionController::class,
            'store'
        ]);
    });

// Authenticated routes
Route::middleware('auth')
    ->group(function () {
        Route::post('logout', [
            AuthenticatedSessionController::class,
            'destroy'
        ])
            ->name('logout');

        Route::get('/', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');


        Route::resource('companies', CompanyController::class);
    });


