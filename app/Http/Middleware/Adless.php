<?php

namespace App\Http\Middleware;

use App\Facades\AdCache;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Adless
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Use this middleware to define routes that won't display ads
        AdCache::adless();
        return $next($request);
    }
}
