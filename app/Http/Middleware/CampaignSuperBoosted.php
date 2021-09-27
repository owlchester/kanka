<?php

namespace App\Http\Middleware;

use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use Closure;

class CampaignSuperBoosted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Make sure we have an id
        $campaign = CampaignLocalization::getCampaign();
        if (empty($campaign)) {
            return redirect()->route('home');
        }

        if (!$campaign->boosted(true)) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => 'This feature is reserved to superboosted campaigns.'
                ]);
            }
            return redirect()->route('dashboard')->withErrors(__('campaigns.errors.superboosted'));
        }

        return $next($request);
    }
}
