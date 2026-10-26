<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateMcp
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('api')->check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401)->header(
                'WWW-Authenticate',
                'Bearer realm="mcp", resource_metadata="' . route('mcp.oauth.protected-resource.nested', ['path' => $request->path()]) . '"',
            );
        }

        Auth::shouldUse('api');

        return $next($request);
    }
}
