<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->user_role_id === 1) {
            return $next($request);
        }

        // abort(403, 'Unauthorized: Only super admin can enter allowed routes');
        return response()->json(['message' => 'Unauthorized: Only super admin can enter allowed routes.'], 403);
        abort(403, 'Unauthorized: Only super admin can enter allowed routes');
    }
}
