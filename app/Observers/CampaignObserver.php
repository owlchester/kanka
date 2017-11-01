<?php

namespace App\Observers;

use App\Campaign;
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
        Session::put('campaign_id', $campaign->id);
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
