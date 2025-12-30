<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogActivity
{
    public function handle(Request $request, Closure $next) : Response
    {
        if (auth()->check()) {
            $route = $request->route();
            $routeName = $route ? $route->getName() : 'unknown';
            $method = $request->method();
            $url = $request->fullUrl();

            activity()
                ->causedBy(auth()->user())
                ->useLog('User Accessed')
                ->withProperties([
                    'route'      => $routeName,
                    'method'     => $method,
                    'url'        => $url,
                    'ip'         => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ])
                ->log("{$routeName}");
        }

        return $next($request);
    }
}
