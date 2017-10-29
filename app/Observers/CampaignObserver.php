<?php

namespace App\Observers;

use App\Campaign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CampaignObserver
{
    /**
     * @param Campaign $campaign
     */
    public function saving(Campaign $campaign)
    {
        $campaign->slug = str_slug($campaign->name, '');
        $campaign->locale = 'en';

        if (request()->has('image')) {
            $path = request()->file('image')->store('campaigns', 'public');
            if (!empty($path)) {
                $campaign->image = $path;
            }
        }
    }

    /**
     * @param Campaign $campaign
     */
    public function saved(Campaign $campaign)
    {
    }

    /**
     * @param Campaign $campaign
     */
    public function created(Campaign $campaign)
    {
        $campaign->users()->attach(Auth::user()->id);
        Session::put('campaign_id', $campaign->id);
    }
}
