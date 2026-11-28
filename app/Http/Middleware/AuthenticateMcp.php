<?php

namespace App\Http\Middleware;

use App\Models\User;
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

        $user = Auth::guard('api')->user();
        if (! $user instanceof User || (! $user->isWyvern() && ! $user->isElemental() && ! $user->hasRole('admin'))) {
            return response()->json([
                'message' => 'Kanka MCP requires a Wyvern or Elemental subscription. Upgrade at ' . route('settings.subscription'),
            ], 403);
        }

        return $next($request);
    }
}
