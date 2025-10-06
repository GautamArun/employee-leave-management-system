<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if(!Auth::check()){
            return response()->json(['error' => 'Unauthorized', 401]);
        }

        if(Auth::user()->roles != $role) {
            return response()->json(['error' => 'You do not have access, admins only allowed'], 403);
        }

        return $next($request);
    }
}
