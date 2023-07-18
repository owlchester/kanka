<?php

namespace App\Http\Middleware;

use App\Facades\Api;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Api::isSubdomain()) {
            return response()->json(['This URL isn\'t available in the API']);
        }
        return $next($request);
    }
}
