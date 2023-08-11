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
//        dump(session()->all());
//        if (session()->has('tracking')) {
//            dd(session()->get('tracking'));
//        }
        if ($request->has('gclid')) {
            session()->put('tracking', $request->get('gclid'));
        }
//        dump(session()->all());
        return $next($request);
    }
}
