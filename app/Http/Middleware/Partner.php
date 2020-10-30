<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Partner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Just want the user to be a partner
        if (!auth()->check() || (!auth()->user()->hasRole('partner') && !auth()->user()->hasRole('admin'))) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
