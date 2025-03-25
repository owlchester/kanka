<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationMiddlewareBase;

class LocalizeDatetime extends LaravelLocalizationMiddlewareBase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function handle($request, Closure $next)
    {
        // If the URL of the request is in exceptions.
        if ($this->shouldIgnore($request)) {
            return $next($request);
        }
        Carbon::setLocale(app('laravellocalization')->getCurrentLocale());

        return $next($request);
    }
}
