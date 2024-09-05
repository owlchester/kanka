<?php

namespace App\Http\Middleware;

use App\Facades\ApiLog;
use Closure;

class ApiLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next)
    {
        $campaign = $request->route('campaign');

        if (null === $campaign) {
            ApiLog::request($request)->log();
            return $next($request);
        }
        ApiLog::request($request)->campaign($campaign)->log();
        return $next($request);
    }
}
