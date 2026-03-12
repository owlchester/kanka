<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Subscriptions
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     */
    public function handle($request, Closure $next)
    {
        if (! config('services.stripe.enabled')) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
