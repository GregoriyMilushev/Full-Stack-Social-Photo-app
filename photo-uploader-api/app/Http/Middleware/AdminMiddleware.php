<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the authenticated user has admin privileges
        if (!$request->user() || !$request->user()->isAdmin()) {
            return response('Unauthorized.', 401);
        }

        // User is an admin, allow access to the route
        return $next($request);
    }
}
