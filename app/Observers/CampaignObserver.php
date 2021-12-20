<?php

namespace App\Observers;

use App\Facades\Mentions;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignFollower;
use App\Models\CampaignUser;
use App\Facades\CampaignLocalization;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Models\CampaignSetting;
use App\Models\RpgSystem;
use App\Services\EntityMappingService;
use App\Services\ImageService;
use App\Services\StarterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
     * @var StarterService
     */
    protected $starterService;

    /**
     * CharacterObserver constructor.
     * @param EntityMappingService $entityMappingService
     * @param StarterService $starterService
     */
    public function __construct(EntityMappingService $entityMappingService, StarterService $starterService)
    {
        $this->entityMappingService = $entityMappingService;
        $this->starterService = $starterService;
    }

    /**
     * @param Campaign $campaign
     */
    public function saving(Campaign $campaign)
    {
        if (!$campaign->withObservers) {
            return;
        }

        // Purity text
        $campaign->name = $this->purify($campaign->name);
        $campaign->entry = $this->purify(Mentions::codify($campaign->entry));
        $campaign->excerpt = $this->purify(Mentions::codify($campaign->excerpt));

        $campaign->slug = Str::slug($campaign->name, '');
        $campaign->updated_by = auth()->user()->id;

        if (request()->has('is_public')) {
            $previousVisibility = $campaign->getOriginal('visibility_id');
            $isPublic = request()->get('is_public', null);
            if (!empty($isPublic) && $previousVisibility == Campaign::VISIBILITY_PRIVATE) {
                $campaign->visibility_id = Campaign::VISIBILITY_PUBLIC;
                // Default to public for now. Later will have REVIEW mode.
            } elseif (empty($isPublic) && $previousVisibility != Campaign::VISIBILITY_PRIVATE) {
                $campaign->visibility_id = Campaign::VISIBILITY_PRIVATE;
            }
        }

        // UI settings
        /*$uiSettings = $campaign->ui_settings;
        if (request()->has('tooltip_family')) {
            $uiSettings['tooltip_family'] = (bool) request()->get('tooltip_family');
        }
        if (request()->has('tooltip_image')) {
            $uiSettings['tooltip_image'] = (bool) request()->get('tooltip_image');
        }
        if (request()->has('hide_members')) {
            $uiSettings['hide_members'] = (bool) request()->get('hide_members');
        }
        if (request()->has('hide_history')) {
            $uiSettings['hide_history'] = (bool) request()->get('hide_history');
        }
        $campaign->ui_settings = $uiSettings;*/

        // Handle image. Let's use a service for this.
        ImageService::handle($campaign, 'campaigns');
        ImageService::handle($campaign, 'campaigns', true, 'header_image');
    }

    /**
     * @param Campaign $campaign
     */
    public function creating(Campaign $campaign) {
        $campaign->created_by = auth()->user()->id;
    }

    /**
     * @param Campaign $campaign
     */
    public function created(Campaign $campaign)
    {
        $role = new CampaignUser([
            'user_id' => auth()->user()->id,
            'campaign_id' => $campaign->id,
        ]);
        $role->save();

        // Make sure we save the last campaign id to avoid infinite loops
        $user = auth()->user();
        $user->last_campaign_id = $campaign->id;
        $user->save();

        $role = CampaignRole::create([
            'campaign_id' => $campaign->id,
            'name' => __('campaigns.members.roles.owner'),
            'is_admin' => true,
        ]);

        $publicRole = CampaignRole::create([
            'campaign_id' => $campaign->id,
            'name' => __('campaigns.members.roles.public'),
            'is_public' => true,
        ]);

        $playerRole = CampaignRole::create([
            'campaign_id' => $campaign->id,
            'name' => __('campaigns.members.roles.player'),
        ]);

        CampaignRoleUser::create([
            'campaign_role_id' => $role->id,
            'user_id' => Auth::user()->id
        ]);

        // Settings
        $setting = new CampaignSetting([
            'campaign_id' => $campaign->id,
            'dice_rolls' => 0,
            'conversations' => 0,
        ]);
        $setting->save();

        UserCache::clearCampaigns();
    }

    /**
     * @param Campaign $campaign
     */
    public function saved(Campaign $campaign)
    {
        if (!$campaign->withObservers) {
            return;
        }

        // If the entity note's entry has changed, we need to re-build it's map.
        if ($campaign->isDirty('entry')) {
            $this->entityMappingService->mapCampaign($campaign);
        }

        $this->saveRpgSystems($campaign);

        foreach ($campaign->members()->with('user')->get() as $member) {
            UserCache::user($member->user)->clearCampaigns();
        }

        // Whenever a campaign is changed, clear the cache for followers.
        // This can be for the name, image, public status etc which needs to be reflected
        // in the user's sidebar.
        foreach ($campaign->followers as $follow) {
            UserCache::user($follow)->clearFollows();
        }
    }

    /**
     * @param Campaign $campaign
     */
    public function deleted(Campaign $campaign)
    {
        ImageService::cleanup($campaign);
        UserCache::clearCampaigns();
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

    /**
     * @param Campaign $campaign
     */
    protected function saveRpgSystems(Campaign $campaign): void
    {
        if (!request()->has('rpg_systems')) {
            return;
        }

        $ids = request()->post('rpg_systems', []);

        // Only use tags the user can actually view. This way admins can
        // have tags on entities that the user doesn't know about.
        $existing = [];
        foreach ($campaign->rpgSystems as $system) {
            $existing[] = $system->id;
        }
        $new = [];

        foreach ($ids as $id) {
            if (!empty($existing[$id])) {
                unset($existing[$id]);
            } else {
                $system = RpgSystem::find($id);
                if (empty($system)) {
                    continue;
                }
                $new[] = $system->id;
            }
        }
        $campaign->rpgSystems()->attach($new);

        // Detach the remaining
        if (!empty($existing)) {
            $campaign->rpgSystems()->detach($existing);
        }
    }
}
