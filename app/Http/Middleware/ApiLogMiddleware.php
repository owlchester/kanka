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
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $campaign = $request->route('campaign');

        if (is_null($campaign)) {
            ApiLog::log();
            return $next($request);
        }
        ApiLog::campaign($campaign)->log();
        return $next($request);
    }
}
