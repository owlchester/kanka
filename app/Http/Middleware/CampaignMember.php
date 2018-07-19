<?php

namespace App\Http\Middleware;

use App\Models\Campaign;
use App\Facades\CampaignLocalization;
use Closure;

class CampaignMember
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
        $campaignId = CampaignLocalization::getCampaign()->id;
        if (empty($campaignId)) {
            return redirect()->route('campaigns.index');
        }

        // Make sure the campaign exists
        $campaign = Campaign::where('id', $campaignId)->first();
        if (empty($campaign)) {
            return redirect()->route('campaigns.index');
        }

        // Make sure we are in the campaign users
        //if (!$campaign->user()) {
        //    return redirect()->route('campaigns.index');
        //}
        // This is now handled by the CampaignLocalization

        return $next($request);
    }
}
