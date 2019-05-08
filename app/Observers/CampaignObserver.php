<?php

namespace App\Observers;

use App\Models\Campaign;
use App\Models\CampaignUser;
use App\Facades\CampaignLocalization;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Models\CampaignSetting;
use App\Services\EntityMappingService;
use App\Services\ImageService;
use App\Services\StarterService;
use Illuminate\Support\Facades\Auth;

class CampaignObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * Service used to build the map of the entity
     * @var EntityMappingService
     */
    protected $entityMappingService;

    /**
     * CharacterObserver constructor.
     * @param EntityMappingService $entityMappingService
     */
    public function __construct(EntityMappingService $entityMappingService)
    {
        $this->entityMappingService = $entityMappingService;
    }

    /**
     * @param Campaign $campaign
     */
    public function saving(Campaign $campaign)
    {
        // Purity text
        $campaign->name = $this->purify($campaign->name);
        $campaign->entry = $this->purify($campaign->entry);
        $campaign->excerpt = $this->purify($campaign->excerpt);

        $campaign->slug = str_slug($campaign->name, '');

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
        ImageService::handle($campaign, 'campaigns', true, 'header_image');
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
            'name' => trans('campaigns.members.roles.owner'),
            'is_admin' => true,
        ]);

        $publicRole = CampaignRole::create([
            'campaign_id' => $campaign->id,
            'name' => trans('campaigns.members.roles.public'),
            'is_public' => true,
        ]);

        $playerRole = CampaignRole::create([
            'campaign_id' => $campaign->id,
            'name' => trans('campaigns.members.roles.player'),
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

    public function saved(Campaign $campaign)
    {
        // If the entity note's entry has changed, we need to re-build it's map.
        if ($campaign->isDirty('entry')) {
            $this->entityMappingService->mapCampaign($campaign);
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

        ImageService::cleanup($campaign, 'header_image');
    }
}
