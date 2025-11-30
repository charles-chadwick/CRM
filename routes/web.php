<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
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

        Route::prefix('customers')->group(function () {
           Route::get('/{company}', [CustomerController::class, 'index'])->name('customers.index');
           Route::get('/{company}/profile', [CustomerController::class, 'profile'])->name('customers.profile');
           Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
        });


    });


