<?php

namespace App\Observers;

use App\Campaign;
use App\Services\CampaignService;
use App\Services\StarterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CampaignObserver
{
    /**
     * @param Campaign $campaign
     */
    public function saving(Campaign $campaign)
    {
        $campaign->slug = str_slug($campaign->name, '');

        if (empty($campaign->locale)) {
            $campaign->locale = 'en';
        }

        if (request()->has('image')) {
            $path = request()->file('image')->store('campaigns', 'public');
            if (!empty($path)) {
                // Remove old
                $original = $campaign->getOriginal('image');
                if (!empty($original)) {
                    // Delete
                    Storage::disk('public')->delete($original);
                }
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
        $campaign->users()->attach(Auth::user()->id, ['role' => 'owner']);

        // If it's the user's first campaign, let's help out a bit.
        $first = !Session::has('campaign_id');
        Session::put('campaign_id', $campaign->id);

        if ($first) {
            StarterService::generateBoilerplate($campaign);
        }
    }

    /**
     * @param Campaign $campaign
     */
    public function creating(Campaign $campaign)
    {
        $campaign->join_token = $campaign->getToken();
    }

    /**
     * @param Campaign $campaign
     */
    public function deleted(Campaign $campaign)
    {
        if (!empty($campaign->image)) {
            // Delete
            Storage::disk('public')->delete($campaign->image);
        }
    }
}
