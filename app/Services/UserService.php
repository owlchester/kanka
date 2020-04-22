<?php

namespace App\Services;

use App\Models\CampaignUser;
use App\User;
use Carbon\Carbon;

class UserService
{
    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticated(User $user)
    {
        // If a user has a last campaign id, we need to make sure the
        if ($user->last_campaign_id) {
            // The user should be part of the last campaign
            $campaign = $user->lastCampaign;

            // No campaign yet
            if (empty($campaign)) {
                return redirect()->route('home');
            }

            $member = CampaignUser::where('campaign_id', $campaign->id)
                ->where('user_id', $user->id)
                ->first();
            if (!$member) {
                // The user is no longer part of the campaign, so let's get ride of it.
                $user->last_campaign_id = null;
                $user->save();
            } else {
                // redirect
                return redirect()->route('home');
            }
        }

        // So we don't have a valid last campaign id, so lets just try and use the first one of the list.
        $campaign = $user->campaigns()->first();

        // We have no campaign
        if (!$campaign) {
            // The user do not have any campaign
            // So we invite him to create a campaign
            return redirect()->route('start');
        } else {
            $user->last_campaign_id = $campaign->id;
            $user->save();
            return redirect()->route('home');
        }
    }
}
