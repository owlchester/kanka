<?php

namespace App\Services;

use App\CampaignUser;
use App\Exceptions\RequireLoginException;
use App\Models\CampaignInvite;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Notifications\Header;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class InviteService
{
    /**
     * @param string $token
     * @return mixed
     * @throws RequireLoginException
     * @throws \Exception
     */
    public static function useToken($token = null)
    {
        if (empty($token)) {
            throw new \Exception(trans('campaigns.invites.error.invalid_token'));
        }

        $invite = CampaignInvite::where('token', $token)->first();
        if (empty($invite)) {
            throw new \Exception(trans('campaigns.invites.error.invalid_token'));
        }

        // Inactive or removed campaign
        if ($invite->is_active == false || empty($invite->campaign)) {
            throw new \Exception(trans('campaigns.invites.error.inactive_token'));
        }

        if (Auth::guest()) {
            Session::put('invite_token', $invite->token);
            throw new RequireLoginException(trans('campaigns.invites.error.login'));
        }


        self::join($invite->token);

        return $invite->campaign;
    }

    /**
     * @param $campaignId
     * @return bool
     */
    public static function join($token = null)
    {
        if (empty($token)) {
            $token = Session::get('invite_token');
        }
        $invite = CampaignInvite::where('token', $token)
            ->first();

        Session::forget('invite_token');

        // Already a member?
        $role = CampaignUser::where('campaign_id', $invite->campaign_id)
            ->where('user_id', Auth::user()->id)
            ->first();

        if (empty($role)) {
            $role = new CampaignUser([
                'user_id' => Auth::user()->id,
                'campaign_id' => $invite->campaign_id,
                'role' => 'viewer'
            ]);
            $role->save();
        }

        // Add the user to a role if it's provided by the invite link
        if ($invite->role) {
            $memberRole = CampaignRoleUser::create([
                'campaign_role_id' => $invite->role->id,
                'user_id' => $role->user_id
            ]);
        }

        $invite->is_active = false;
        $invite->save();

        // Notify all admins of the campaign
        foreach ($invite->campaign->admins() as $user) {
            $user->notify(new Header(
                'campaign.join',
                'user',
                'green',
                ['user' => Auth::user()->name, 'campaign' => $invite->campaign->name]
            ));
        }

        return $role->campaign;
    }
}
