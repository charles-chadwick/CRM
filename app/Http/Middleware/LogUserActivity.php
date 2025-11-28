<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Facades\Activity;

class LogUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            activity()
                ->causedBy(Auth::user())
                ->withProperties([
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ])
                ->log('page_visited');
        }

        return $next($request);
    }
}