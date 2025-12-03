<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CachedResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (auth()->check()) {
            $response->headers->setCookie(
                cookie('authenticated', '1', 0, '/', null, null, false)
            );
        } else {
            $cookie = cookie('authenticated', '', -1, '/', null, null, false);
            $response->headers->setCookie($cookie);

            $response->headers->set('Cache-Control', 'public, max-age=600, s-maxage=1200');
        }

        return $response;
    }
}
