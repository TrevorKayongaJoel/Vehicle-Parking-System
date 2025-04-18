<?php

namespace App\Http\Middleware;



use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!$request->user() || $request->user()->role !== $role) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
// This middleware checks if the authenticated user has the specified role.
// If not, it aborts the request with a 403 Unauthorized response.