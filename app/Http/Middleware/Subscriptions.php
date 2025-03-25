<?php

namespace App\Http\Middleware;

use Closure;

class Subscriptions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function handle($request, Closure $next)
    {
        if (! config('services.stripe.enabled')) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
