<?php

namespace App\Http\Middleware;

use App\Facades\CampaignLocalization;
use App\Facades\Identity;
use Closure;
use Illuminate\Http\Request;

class CampaignIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $campaign = CampaignLocalization::getCampaign();

        // If we are impersonating someone, force them to a single campaign
        if (auth()->check() && Identity::isImpersonating()) {
            $forcedCampaignID = Identity::getCampaignId();
            if ($campaign->id != $forcedCampaignID) {
                return redirect()->route('dashboard', $forcedCampaignID);
            }
        }

        if ($campaign->isPublic()) {
            $this->saveCampaign($campaign);
            return $next($request);
        }

        // If the user isn't a member of the campaign, show them a permission denied error
        if (auth()->guest() || !$campaign->userIsMember()) {
            // todo: Save the url for a redirect after login in?
            session()->put('campaign_id', $campaign->id);
            return abort(403);
        }

        $this->saveCampaign($campaign);
        return $next($request);
    }

    /**
     * Update the user's last seen campaign, so that when going back to the homepage, they load this campaign directly
     * @param \App\Models\Campaign $campaign
     * @return void
     */
    protected function saveCampaign(\App\Models\Campaign $campaign): void
    {
        if (auth()->guest()) {
            return;
        }
        auth()->user()->updateQuietly(['last_campaign_id' => $campaign->id]);
    }
}
