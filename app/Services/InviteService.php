<?php

namespace App\Services;

use App\Facades\UserCache;
use App\Models\CampaignUser;
use App\Exceptions\RequireLoginException;
use App\Models\CampaignInvite;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Notifications\Header;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Exception;

class InviteService
{
    /**
     * @var CampaignFollowService
     */
    public $campaignFollowService;

    /**
     * InviteService constructor.
     * @param CampaignFollowService $campaignFollowService
     */
    public function __construct(CampaignFollowService $campaignFollowService)
    {
        $this->campaignFollowService = $campaignFollowService;
    }

    /**
     * @param string $token
     * @return mixed
     * @throws RequireLoginException
     * @throws \Exception
     */
    public function useToken(string $token = null)
    {
        if (empty($token)) {
            throw new \Exception(trans('campaigns.invites.error.invalid_token'));
        }

        $invite = CampaignInvite::where('token', $token)->first();
        if (empty($invite)) {
            throw new Exception(trans('campaigns.invites.error.invalid_token'));
        }

        // Inactive or removed campaign
        if ($invite->is_active == false || empty($invite->campaign)) {
            throw new Exception(trans('campaigns.invites.error.inactive_token'));
        }

        if (Auth::guest()) {
            Session::put('invite_token', $invite->token);
            throw new RequireLoginException(trans('campaigns.invites.error.login'));
        }

        $this->join($invite->token);

        return $invite->campaign;
    }

    /**
     * @param string $token
     * @return bool
     */
    public function join(string $token = null)
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
        } else {
            // User is already part of the campaign, don't go further otherwise one user can spam the join link and
            // use up all the available tokens (validity field).
            return true;
        }

        // Add the user to a role if it's provided by the invite link
        if ($invite->role) {
            $memberRole = CampaignRoleUser::create([
                'campaign_role_id' => $invite->role->id,
                'user_id' => $role->user_id
            ]);
        }

        // Check the type. Links have a number of usage (validity)
        if ($invite->type == 'link') {
            if (!empty($invite->validity)) {
                $invite->validity--;
                if ($invite->validity <= 0) {
                    $invite->is_active = false;
                }
            }
        } else {
            $invite->is_active = false;
        }
        $invite->save();

        // If the user was following the campaign, remove it
        if ($invite->campaign->isFollowing()) {
            $this->campaignFollowService->remove(
                $invite->campaign,
                Auth::user()
            );
        }

        // Notify all admins of the campaign
        foreach ($invite->campaign->admins() as $user) {
            $user->notify(new Header(
                'campaign.join',
                'user',
                'green',
                [
                    'user' => e(Auth::user()->name),
                    'campaign' => e($invite->campaign->name)
                ]
            ));
        }

        // Make sure the user's cache is cleared
        UserCache::clearCampaigns();
        UserCache::clearRoles();

        return $role->campaign;
    }
}
