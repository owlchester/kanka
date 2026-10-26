<?php

namespace App\Http\Middleware;

use App\Services\Mcp\ToolUsageLogger;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordMcpToolUsage
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        foreach ($request->attributes->get('mcp_tool_usage', []) as $tool) {
            if (is_string($tool)) {
                app(ToolUsageLogger::class)->record($tool);
            }
        }
    }
}
