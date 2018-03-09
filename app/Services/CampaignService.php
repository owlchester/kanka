<?php

namespace App\Services;

use App\Campaign;
use App\CampaignUser;
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
     * @var Campaign
     */
    protected $campaign;

    /**
     * CampaignService constructor.
     */
    public function __construct()
    {
        $this->id = Session::get('campaign_id');
        $this->campaign = Campaign::where('id', $this->id)->first();
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

    }

    /**
     * Leave a campaign
     * @param Campaign $campaign
     */
    public static function leave(Campaign $campaign)
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


        self::switchToNext();
    }

    /**
     * Switch to the last campaign the user used
     */
    public static function switchToLast()
    {
        $last = Auth::user()->campaign;
        if ($last) {
            self::switchCampaign(Auth::user()->campaign);
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
     * Shorthand to determine if a campaign has an entity enabled or not
     *
     * @param string $entity
     * @return bool
     */
    public function enabled($entity = '')
    {
        return $this->campaign->enabled($entity);
    }

    /**
     * Is the user a member?
     * @return bool
     */
    public function member()
    {
        return $this->campaign->member();
    }

    /**
     * @return mixed
     */
    public function roles()
    {
        return $this->campaign->roles;
    }

    /**
     * @return mixed
     */
    public function users()
    {
        return $this->campaign->users;
    }
}
