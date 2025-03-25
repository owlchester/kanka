<?php

namespace App\Http\Middleware;

use Closure;

class Translator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function handle($request, Closure $next)
    {
        if (! auth()->user()->hasRole('translator')) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
