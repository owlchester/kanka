<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Passport\AccessToken;
use Symfony\Component\HttpFoundation\Response;

class RejectMcpTokens
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->user()?->token();

        if ($token instanceof AccessToken && in_array('mcp:use', $token->toArray()['oauth_scopes'] ?? [], true)) {
            return response()->json(['message' => 'MCP credentials cannot access the REST API.'], 403);
        }

        return $next($request);
    }
}
