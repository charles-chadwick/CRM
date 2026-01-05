<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\PermissionRegistrar;

class LoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function create() : Response
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request) : RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Clear permission cache to ensure fresh permissions for the new user
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy() : RedirectResponse
    {
        // Clear permission cache before logout to prevent stale permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Auth::guard('web')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    }
}
