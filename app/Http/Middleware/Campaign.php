<?php

namespace App\Http\Middleware;

use App\Facades\CampaignLocalization;
use Closure;
use Exception;
use App\Models\Campaign as CampaignModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use \App\Facades\Identity;

/**
 * Class Campaign
 * @package App\Http\Middleware
 */
class Campaign
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If the campaign has not been passed through the function
        // it tries to get it from the first segment of the url
        $campaignId = $request->segment(3, null);

        if (empty($campaignId)) {
            abort(404);
        }

        $campaign = CampaignLocalization::getCampaign();

        // If we are impersonating someone
        if (auth()->check() && Identity::isImpersonating()) {
            $forcedCampaignID = Identity::getCampaignId();
            if ($campaign->id != $forcedCampaignID) {
                return redirect()->to(app()->getLocale() . '/campaign/' . $forcedCampaignID);
            }
        }

        // Make sure we can view this campaign?
        if ($campaign->isPublic()) {
            session()->put('campaign_id', $campaign->id);
            $this->saveUserLastCampaignId($campaign);
        } elseif (auth()->check()) {
            // Obvious check: are we a member of the campaign?
            if (!$campaign->userIsMember()) {
                abort(403);
            }
            $this->saveUserLastCampaignId($campaign);
        } else {
            // No session and not a public campaign: deny the request
            abort(403);
        }

        return $next($request);
    }

    /**
     * Save the new campaign on the user for further actions
     * @param CampaignModel $campaign
     */
    protected function saveUserLastCampaignId(\App\Models\Campaign $campaign)
    {
        if (!auth()->check()) {
            return;
        }
        auth()->user()->update(['last_campaign_id' => $campaign->id]);
    }
}
