<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationMiddlewareBase;

class LocalizeDatetime extends LaravelLocalizationMiddlewareBase
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     */
    public function handle($request, Closure $next)
    {
        // If the URL of the request is in exceptions.
        if ($this->shouldIgnore($request)) {
            return $next($request);
        }
        $locale = app('laravellocalization')->getCurrentLocale();
        Carbon::setLocale($locale);
        Number::useLocale($locale);

        return $next($request);
    }
}
