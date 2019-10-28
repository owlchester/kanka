<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\CampaignUser;
use App\Exceptions\TranslatableException;
use App\Jobs\CampaignExport;
use App\Notifications\Header;
use App\User;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
        Session::put('campaign_id', $campaign->id);
        $user = Auth::user();
        $user->last_campaign_id = $campaign->id;
        $user->campaign_role = $campaign->role();
        $user->save();
    }

    /**
     * @param Campaign $campaign
     */
    public static function generateBoilerplate(Campaign $campaign)
    {
        // Do nothing
    }

    /**
     * Leave a campaign
     * @param Campaign $campaign
     */
    public function leave(Campaign $campaign)
    {
        $member = CampaignUser::where('campaign_id', $campaign->id)
            ->where('user_id', Auth::user()->id)
            ->first();
        if (empty($member)) {
            // Shouldn't be able to leave a campaign he isn't a part of...?
            // Switch to the next available campaign?
            $member = CampaignUser::where('user_id', Auth::user()->id)->first();
            if ($member) {
                // Just switch to the first one available.
                self::switchCampaign($member->campaign_id);
            } else {
                // Need to create a new campaign
                Session::forget('campaign_id');
            }

            throw new Exception(trans('campaigns.leave.error'));
        }
        // Delete user from roles
        foreach ($campaign->roles as $role) {
            foreach ($role->users as $user) {
                if ($user->user_id == Auth::user()->id) {
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
                'user' => e(Auth::user()->name),
                'campaign' => e($campaign->name)
            ]
        );

        self::switchToNext();
    }

    /**
     * Switch to the last campaign the user used
     * @param null $userParam
     */
    public static function switchToLast($userParam = null)
    {
        $user = $userParam?:Auth::user();
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
        $member = CampaignUser::where('user_id', Auth::user()->id)->first();
        if ($member) {
            // Just switch to the first one available.
            self::switchCampaign($member->campaign);
        } else {
            // Need to create a new campaign
            Session::forget('campaign_id');
        }
    }

    /**
     * Determine if the user is still part of the the current campaign
     *
     * @return bool True if the user is still part of the current campaign, false otherwise
     */
    public static function isUserPartOfCurrentCampaign()
    {
        $member = CampaignUser::where('campaign_id', Session::get('campaign_id'))
            ->where('user_id', Auth::user()->id)
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
        foreach ($campaign->admins() as $user) {
            $user->notify(new Header('campaign.' . $key, $icon, $colour, $params));
        }
    }

    /**
     * @param Campaign $campaign
     */
    public function export(Campaign $campaign, User $user, EntityService $service)
    {
        // On prod, only 1 export per "day"
        if (app()->environment('prod') && !empty($campaign->export_date) && $campaign->export_date == date('Y-m-d')) {
            throw new TranslatableException(trans('campaigns.export.errors.limit'));
        }
        $campaign->export_date = date('Y-m-d');
        $campaign->save();

        CampaignExport::dispatch($campaign, $user, $service);
    }
}
