<?php

namespace App\Observers;

use App\Campaign;
use App\CampaignUser;
use App\Facades\CampaignLocalization;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Models\CampaignSetting;
use App\Services\CampaignService;
use App\Services\ImageService;
use App\Services\StarterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CampaignObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @param Campaign $campaign
     */
    public function saving(Campaign $campaign)
    {
        $campaign->slug = str_slug($campaign->name, '');

        if (empty($campaign->locale)) {
            $campaign->locale = 'en';
        }

        // Purity text
        $campaign->description = $this->purify($campaign->description);

        // Public?
        $previousVisibility = $campaign->getOriginal('visibility');
        $isPublic = request()->get('is_public', null);
        if (!empty($isPublic) && $previousVisibility == Campaign::VISIBILITY_PRIVATE) {
            $campaign->visibility = Campaign::VISIBILITY_PUBLIC;
            // Default to public for now. Later will have REVIEW mode.
        } elseif (empty($isPublic) && $previousVisibility != Campaign::VISIBILITY_PRIVATE) {
            $campaign->visibility = Campaign::VISIBILITY_PRIVATE;
        }
            // Handle image. Let's use a service for this.
        ImageService::handle($campaign, 'campaigns');
    }

    /**
     * @param Campaign $campaign
     */
    public function created(Campaign $campaign)
    {
        $role = new CampaignUser([
            'user_id' => Auth::user()->id,
            'campaign_id' => $campaign->id,
            'role' => 'owner'
        ]);
        $role->save();

        // If it's the user's first campaign, let's help out a bit.
        $first = !Auth::user()->hasCampaigns();
        CampaignLocalization::setCampaign($campaign->id);

        // Make sure we save the last campaign id to avoid infinite loops
        $user = Auth::user();
        $user->last_campaign_id = $campaign->id;
        $user->campaign_role = 'owner';
        $user->save();

        $role = CampaignRole::create([
            'campaign_id' => $campaign->id,
            'name' => 'Owner',
            'is_admin' => true,
        ]);

        $publicRole = CampaignRole::create([
            'campaign_id' => $campaign->id,
            'name' => 'Public',
            'is_public' => true,
        ]);

        CampaignRoleUser::create([
            'campaign_role_id' => $role->id,
            'user_id' => Auth::user()->id
        ]);

        // Settings
        $setting = new CampaignSetting([
            'campaign_id' => $campaign->id
        ]);
        $setting->save();

        if ($first) {
            StarterService::generateBoilerplate($campaign);
        }
    }

    /**
     * @param Campaign $campaign
     */
    public function deleted(Campaign $campaign)
    {
        ImageService::cleanup($campaign);
    }

    /**
     * Deleting the campaign
     *
     * @param Campaign $campaign
     */
    public function deleting(Campaign $campaign)
    {
        foreach ($campaign->members as $member) {
            $member->delete();
        }

        // Delete the campaign setting
        $campaign->setting->delete();
    }
}
