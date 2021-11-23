<?php

namespace App\Http\Middleware;

use Closure;

class Tracking
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
        if ($request->has('gclid')) {
            session()->put('tracking', $request->get('gclid'));
        }
        return $next($request);
    }
}
