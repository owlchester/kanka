<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ReplicationSwitcher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If the user is a guest and not on the login or register routes
        if (Auth::guest() && !$request->is('login', 'register', 'auth.*', 'password*', 'settings/security/*')) {
            DB::setDefaultConnection('replica');
        }
        return $next($request);
    }
}
