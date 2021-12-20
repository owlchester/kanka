<?php

namespace App\Services;

use App\Facades\UserCache;
use App\Jobs\CampaignAssetExport;
use App\Models\Campaign;
use App\Models\CampaignUser;
use App\Exceptions\TranslatableException;
use App\Jobs\CampaignExport;
use App\Models\UserLog;
use App\Notifications\Header;
use App\User;
use Illuminate\Session\Store;
use Exception;

class CampaignService
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * The user's current Campaign
     * @var Campaign
     */
    protected $campaign = false;

    /**
     * The Campaign model (DI)
     * @var Campaign
     */
    protected $campaignModel;

    /**
     * @var Store
     */
    protected $session;

    /**
     * CampaignService constructor.
     */
    public function __construct(Store $session, Campaign $campaignModel)
    {
        $this->session = $session;
        $this->campaignModel = $campaignModel;
    }

    public function campaign()
    {
        return \App\Facades\CampaignLocalization::getCampaign();
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->campaign->name;
    }

    /**
     * Switch campaigns
     * @param Campaign $campaign
     */
    public static function switchCampaign(Campaign $campaign)
    {
        session()->put('campaign_id', $campaign->id);
        $user = auth()->user();
        $user->last_campaign_id = $campaign->id;
        $user->save();
    }

    /**
     * Leave a campaign
     * @param Campaign $campaign
     * @throws Exception
     */
    public function leave(Campaign $campaign)
    {
        $member = CampaignUser::where('campaign_id', $campaign->id)
            ->where('user_id', auth()->user()->id)
            ->first();
        if (empty($member)) {
            // Shouldn't be able to leave a campaign they aren't a part of...?
            // Switch to the next available campaign?
            $member = CampaignUser::where('user_id', auth()->user()->id)->first();
            if ($member) {
                // Just switch to the first one available.
                self::switchCampaign($member->campaign_id);
            } else {
                // Need to create a new campaign
                session()->forget('campaign_id');
            }

            throw new Exception(__('campaigns.leave.error'));
        }
        // Delete user from roles
        foreach ($campaign->roles as $role) {
            foreach ($role->users as $user) {
                if ($user->user_id == auth()->user()->id) {
                    $user->delete();
                }
            }
        }

        // Delete the member
        $member->delete();

        // Notify admins
        $this->notify(
            $campaign,
            'leave',
            'user',
            'yellow',
            [
                'user' => auth()->user()->name,
                'campaign' => $campaign->name,
                'link' => $campaign->getMiddlewareLink()
            ]
        );

        // Clear cache
        UserCache::clearCampaigns();

        UserLog::create([
            'user_id' => auth()->user()->id,
            'type_id' => UserLog::TYPE_CAMPAIGN_LEAVE
        ]);

        self::switchToNext();
    }

    /**
     * Switch to the last campaign the user used
     * @param User|null $userParam
     */
    public static function switchToLast($userParam = null)
    {
        $user = $userParam ?: auth()->user();
        if (!$user) {
            return;
        }
        $last = $user->lastCampaign;
        if ($last) {
            self::switchCampaign($last);
        }
    }

    /**
     *
     */
    public static function switchToNext()
    {
        // Switch to the next available campaign?
        $member = CampaignUser::where('user_id', auth()->user()->id)->first();
        if ($member) {
            // Just switch to the first one available.
            self::switchCampaign($member->campaign);
        } else {
            // Need to create a new campaign
            session()->forget('campaign_id');
        }
    }

    /**
     * Determine if the user is still part of the the current campaign
     *
     * @return bool True if the user is still part of the current campaign, false otherwise
     */
    public static function isUserPartOfCurrentCampaign()
    {
        $member = CampaignUser::campaignUser(
            session()->get('campaign_id'),
            auth()->user()->id
        )
            ->first();
        return !empty($member);
    }

    /**
     * Shorthand to determine if a campaign has an entity enabled or not
     *
     * @param string $entity
     * @return bool
     */
    public function enabled($entity = '')
    {
        return $this->campaign()->enabled($entity);
    }

    /**
     * Is the user a member?
     * @return bool
     */
    public function member()
    {
        return $this->campaign()->member();
    }

    /**
     * @return mixed
     */
    public function roles()
    {
        return $this->campaign()->roles;
    }

    /**
     * @return mixed
     */
    public function users()
    {
        return $this->campaign()->users;
    }

    /**
     * @param Campaign $campaign
     * @param string $key
     * @param string $icon
     * @param string $colour
     * @param array $params
     */
    public function notify(Campaign $campaign, string $key, string $icon, string $colour, array $params = []): void
    {
        // Notify all admins
        $campaign->notifyAdmins(
            new Header('campaign.' . $key, $icon, $colour, $params)
        );
    }

    /**
     * @param Campaign $campaign
     */
    public function export(Campaign $campaign, User $user, EntityService $service)
    {
        // On prod, only 1 export per "day"
        if (app()->environment('prod') && !empty($campaign->export_date) && $campaign->export_date == date('Y-m-d')) {
            throw new TranslatableException(__('campaigns.export.errors.limit'));
        }
        $campaign->export_date = date('Y-m-d');
        $campaign->withObservers = false;
        $campaign->save();

        CampaignExport::dispatch($campaign, $user);
        CampaignAssetExport::dispatch($campaign, $user);
    }

    /**
     * @param Campaign $campaign
     * @throws Exception
     */
    public function delete(Campaign $campaign)
    {
        UserLog::create([
            'user_id' => auth()->user()->id,
            'type_id' => UserLog::TYPE_CAMPAIGN_DELETE
        ]);

        $campaign->delete();
        CampaignService::switchToNext();
    }
}
