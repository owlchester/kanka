<?php

namespace App\Observers;

use App\Facades\Mentions;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignBoost;
use App\Models\CampaignUser;
use App\Models\CampaignRole;
use App\Models\Genre;
use App\Models\CampaignRoleUser;
use App\Models\GameSystem;
use App\Models\CampaignSetting;
use App\Models\UserLog;
use App\Notifications\Header;
use App\Services\Campaign\SearchCleanupService;
use App\Facades\Images;
use App\Services\Users\CampaignService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CampaignObserver
{
    use PurifiableTrait;

    protected CampaignService $campaignService;

    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    /**
     *
     */
    public function saving(Campaign $campaign)
    {
        // Purity text
        $attributes = $campaign->getAttributes();
        if (array_key_exists('excerpt', $attributes)) {
            $campaign->excerpt = $this->purify(Mentions::codify($campaign->excerpt));
        }

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
    }

    /**
     */
    public function creating(Campaign $campaign)
    {
        //$campaign->is_featured = false;
        $campaign->entity_visibility = false;
        $campaign->entity_personality_visibility = false;
        $campaign->follower = 0;
    }

    /**
     */
    public function created(Campaign $campaign)
    {
        $role = new CampaignUser([
            'user_id' => auth()->user()->id,
            'campaign_id' => $campaign->id,
        ]);
        $role->save();

        // Make sure we save the last campaign id to avoid infinite loops
        $this->campaignService
            ->user(auth()->user())
            ->campaign($campaign)
            ->set();

        $role = CampaignRole::create([
            'campaign_id' => $campaign->id,
            'name' => __('campaigns.members.roles.owner'),
            'is_admin' => true,
        ]);

        CampaignRole::create([
            'campaign_id' => $campaign->id,
            'name' => __('campaigns.members.roles.public'),
            'is_public' => true,
        ]);

        CampaignRole::create([
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

        $campaign->slug = (string) $campaign->id;
        $campaign->saveQuietly();

        UserCache::clear();

        auth()->user()->log(UserLog::TYPE_CAMPAIGN_NEW);
    }

    /**
     */
    public function saved(Campaign $campaign)
    {
        $this->saveGenres($campaign);
        $this->saveSystems($campaign);
        $campaign->saveQuietly();

        foreach ($campaign->members()->with('user')->get() as $member) {
            UserCache::user($member->user)->clear();
        }

        // Whenever a campaign is changed, clear the cache for followers.
        // This can be for the name, image, public status etc which needs to be reflected
        // in the user's sidebar.
        foreach ($campaign->followers as $follow) {
            UserCache::user($follow)->clear();
        }
    }

    /**
     */
    public function deleted(Campaign $campaign)
    {
        if ($campaign->isForceDeleting()) {
            SearchCleanupService::cleanup($campaign);

            // Cleanup the folder with all the campaign images and files
            $campaignFolder = 'w/' . $campaign->id;
            if (Storage::exists($campaignFolder)) {
                Storage::deleteDirectory($campaignFolder);
            }
        } else {
            UserCache::clear();
        }
    }

    /**
     * Deleting the campaign
     *
     */
    public function deleting(Campaign $campaign)
    {

        if ($campaign->isForceDeleting()) {
            // Technically, only a campaign with a single user can be deleted.
            foreach ($campaign->members as $member) {
                $member->delete();
            }
            // Delete the campaign settings.
            $campaign->setting->delete();
        } else {
            // Delete boosters, so the user can use them on other campaigns.
            CampaignBoost::where('campaign_id', $campaign->id)->delete();
            foreach ($campaign->members as $member) {
                $member->user->notify(new Header(
                    'campaign.deleted',
                    'trash',
                    'yellow',
                    [
                        'campaign' => $campaign->name
                    ]
                ));
            }
        }
    }

    /**
     * Save the sections/categories
     */
    protected function saveGenres(Campaign $campaign)
    {
        if (!request()->has('campaign_genre')) {
            return;
        }

        $ids = request()->post('genres', []);

        $existing = [];
        /** @var Genre $genre */
        foreach ($campaign->genres as $genre) {
            $existing[$genre->id] = $genre->slug;
        }
        $new = [];

        foreach ($ids as $id) {
            if (!empty($existing[$id])) {
                unset($existing[$id]);
            } else {
                $genre = Genre::find($id);
                if (!empty($genre)) {
                    $new[] = $genre->id;
                }
            }
        }
        $campaign->genres()->attach($new);

        // Detatch the remaining
        if (!empty($existing)) {
            $campaign->genres()->detach(array_keys($existing));
        }
    }

    /**
     * Save the game systems
     */
    protected function saveSystems(Campaign $campaign)
    {
        if (!request()->has('systems')) {
            return;
        }

        $ids = request()->post('systems', []);

        $existing = [];
        foreach ($campaign->systems as $system) {
            $existing[$system->id] = $system->name;
        }
        $new = [];

        foreach ($ids as $id) {
            if (!empty($existing[$id])) {
                unset($existing[$id]);
            } else {
                $genre = GameSystem::find($id);
                if (!empty($genre)) {
                    $new[] = $genre->id;
                }
            }
        }
        $campaign->systems()->attach($new);

        // Detatch the remaining
        if (!empty($existing)) {
            $campaign->systems()->detach(array_keys($existing));
        }
    }
}
