<?php

namespace App\Http\Middleware;

use App\Facades\ApiLog;
use App\Models\Campaign;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApiLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, Response $response)
    {
        if (! $request instanceof JsonResponse) {
            return;
        }
        $startTime = LARAVEL_START;
        $endTime = microtime(true);
        $duration = $endTime - $startTime;

        $campaign = $request->route('campaign');
        $log = ApiLog::request($request)
            ->response($response)
            ->duration($duration);

        if ($campaign !== null && $campaign instanceof Campaign) {
            $log->campaign($campaign);
        }
        $log->log();
    }
}
