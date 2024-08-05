<?php

namespace App\Http\Controllers;

use App\Models\Campaign;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->guest()) {
            return redirect()->route('login');
        }
        return $this->back();
    }

    /**
     * When a user hits /, or logs in, figure out where to take them.
     * Last campaign? Any campaign? Create a new campaign?
     */
    protected function back()
    {
        // Go to the user's last campaign, if any
        $last = auth()->user()->last_campaign_id;
        if (!empty($last)) {
            /** @var ?Campaign $lastCampaign */
            $lastCampaign = Campaign::acl($last)->first();
            if ($lastCampaign) {
                return redirect()->route('dashboard', $last);
            }
        }

        // No valid last campaign? Let's redirect to the last campaign the user had
        $campaigns = auth()->user()->campaigns;
        foreach ($campaigns as $campaign) {
            return redirect()->route('dashboard', $campaign);
        }

        // No campaign? Ask the user to create one
        return redirect()->route('start');
    }
}
