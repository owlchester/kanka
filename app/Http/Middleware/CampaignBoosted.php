<?php

namespace App\Http\Middleware;

use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use Closure;

class CampaignBoosted
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
            return redirect()->route('campaigns.index');
        }

        if (!$campaign->boosted()) {
            return redirect()->route('dashboard')->withErrors(__('crud.errors.boosted'));
        }

        return $next($request);
    }
}
