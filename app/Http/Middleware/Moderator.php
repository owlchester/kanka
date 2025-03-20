<?php

namespace App\Http\Middleware;

use Closure;

class Moderator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function handle($request, Closure $next)
    {
        // Just want the user to be a moderator
        if (! auth()->check() || (! auth()->user()->hasRole('moderator') && ! auth()->user()->hasRole('admin'))) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
