<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Staff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && in_array($user->user_role_id, [1, 2]) && $user->is_suspended === false) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized: Only admin and super admin can enter allowed routes.'], 403);
        abort(403, 'Unauthorized: Only admin and super admin can enter allowed routes');
    }
}
