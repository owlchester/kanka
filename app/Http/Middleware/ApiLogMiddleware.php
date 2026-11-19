<?php

namespace App\Http\Middleware;

use App\Facades\ApiLog;
use App\Models\Campaign;
use App\Models\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiLogMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        if (! config('logging.enabled') || ! $response instanceof JsonResponse) {
            ApiLog::reset();

            return;
        }

        $startTime = defined('LARAVEL_START') ? LARAVEL_START : microtime(true);
        $duration = round(max(0.0, microtime(true) - $startTime), 3);

        $log = ApiLog::request($request)
            ->response($response)
            ->duration($duration);

        $user = $request->user() ?? auth()->user();
        if ($user instanceof User) {
            $log->user($user);
        }

        $campaign = $request->route('campaign');
        if ($campaign instanceof Campaign) {
            $log->campaign($campaign);
        }

        $log->log();
    }
}
