<?php

namespace App\Http\Middleware;

use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use Closure;

class CampaignOwner
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
        $campaign = Campaign::with('members')->where('id', $campaignId)->first();
        if (empty($campaign)) {
            return redirect()->route('campaigns.index');
        }

        // Make sure we are owner of the campaign
        if (!$campaign->owner()) {
            return redirect()->route('campaigns.index');
        }

        return $next($request);
    }
}
