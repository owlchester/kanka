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
     * @param $request
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
        if (Auth::check() && Identity::isImpersonating()) {
            $forcedCampaignID = Identity::getCampaignId();
            if ($campaign->id != $forcedCampaignID) {
                return redirect()->to(app()->getLocale() . '/campaign/' . $forcedCampaignID);
            }
        }

        // Make sure we can view this campaign?
        if ($campaign->visibility == \App\Models\Campaign::VISIBILITY_PUBLIC) {
            Session::put('campaign_id', $campaign->id);
            $this->saveUserLastCampaignId($campaign);
            return $next($request);
        } elseif (Auth::check()) {
            // Obvious check: are we a member of the campaign?
            if (!$campaign->userIsMember()) {
                // Let's check if it's in Review mode, then we need to be an admin or moderator
                if ($campaign->visibility != \App\Models\Campaign::VISIBILITY_REVIEW
                    && !(Auth::user()->hasRole('moderator') || Auth::user()->hasRole('admin'))) {
                    abort(403);
                }
            } else {
                $this->saveUserLastCampaignId($campaign);
            }
        } else {
            // No session, nada.
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
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->last_campaign_id != $campaign->id) {
                $user->last_campaign_id = $campaign->id;
                $user->save();
            }
        }
    }
}
