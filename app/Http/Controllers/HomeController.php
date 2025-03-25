<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Support\Facades\Session;

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
        // If we have a success message, save it for the redirect (for example when deleting a campaign)
        $with = Session::get('success');

        // Go to the user's last campaign, if any
        $last = auth()->user()->last_campaign_id;
        if (! empty($last)) {
            /** @var ?Campaign $lastCampaign */
            $lastCampaign = Campaign::acl($last)->first();
            if ($lastCampaign) {
                return redirect()->route('dashboard', $last)->with('success', $with);
            }
        }

        // No valid last campaign? Let's redirect to the last campaign the user had
        $campaigns = auth()->user()->campaigns;
        foreach ($campaigns as $campaign) {
            return redirect()->route('dashboard', $campaign)->with('success', $with);
        }

        // No campaign? Ask the user to create one
        return redirect()->route('start')->with('success', $with);
    }
}
