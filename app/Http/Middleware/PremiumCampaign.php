<?php

namespace App\Http\Middleware;

use App\Facades\Domain;
use App\Models\Campaign;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PremiumCampaign
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $campaign = $request->route('campaign');
        if (! $campaign instanceof Campaign) {
            return $next($request);
        }
        if ($campaign->premium()) {
            return $next($request);
        }

        if ($request->is('api/*') || Domain::isApi()) {
            return response()->json([
                'error' => __('Required premium features to be enabled.'),
            ], 401);
        }
    }
}
