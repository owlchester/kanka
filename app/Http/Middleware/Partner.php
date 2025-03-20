<?php

namespace App\Http\Middleware;

use Closure;

class Partner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function handle($request, Closure $next)
    {
        // Just want the user to be a partner
        if (! auth()->check() || (! auth()->user()->hasRole('partner') && ! auth()->user()->hasRole('admin'))) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
