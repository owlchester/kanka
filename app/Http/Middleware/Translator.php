<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Translator
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     */
    public function handle($request, Closure $next)
    {
        if (! auth()->user()->hasRole('translator')) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
