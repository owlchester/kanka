<?php

namespace App\Services;

use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignUser;
use App\Exceptions\RequireLoginException;
use App\Models\CampaignInvite;
use App\Models\CampaignRoleUser;
use App\Models\UserLog;
use App\Notifications\Header;
use App\Traits\UserAware;
use Illuminate\Support\Facades\Session;
use Exception;

class InviteService
{
    use UserAware;

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
            throw new \Exception(__('campaigns.invites.error.invalid_token'));
        }

        $invite = CampaignInvite::where('token', $token)->first();
        if (empty($invite)) {
            throw new Exception(__('campaigns.invites.error.invalid_token'));
        }

        // Inactive or removed campaign
        if ($invite->is_active == false || empty($invite->campaign)) {
            throw new Exception(__('campaigns.invites.error.inactive_token'));
        }

        if (!$invite->campaign->canHaveMoreMembers()) {
            throw new Exception(__('campaigns/limits.members'));
        }

        if (auth()->guest()) {
            Session::put('invite_token', $invite->token);
            throw new RequireLoginException(__('campaigns.invites.error.login'));
        }

        $this->join($invite->token);

        return $invite->campaign;
    }

    /**
     * @param string|null $token
     * @return bool|Campaign
     */
    public function join(string $token = null)
    {
        if (empty($token)) {
            $token = Session::get('invite_token');
        }
        $invite = CampaignInvite::where('token', $token)
            ->first();

        Session::forget('invite_token');

        $campaign = $invite->campaign;

        // Already a member?
        $role = CampaignUser::campaignUser($campaign->id, $this->user->id)
            ->first();

        if (empty($role)) {
            $role = new CampaignUser([
                'user_id' => $this->user->id,
                'campaign_id' => $campaign->id,
            ]);
            $role->save();
        } else {
            // User is already part of the campaign, don't go further otherwise one user can spam the join link and
            // use up all the available tokens (validity field).
            UserCache::clearCampaigns();
            UserCache::clearRoles();
            return true;
        }

        // Add the user to a role if it's provided by the invite link
        if ($invite->role) {
            $memberRole = CampaignRoleUser::create([
                'campaign_role_id' => $invite->role->id,
                'user_id' => $role->user_id
            ]);
        }

        // Invitation links can have a set number of usage (validity)
        if (!empty($invite->validity)) {
            $invite->validity--;
            if ($invite->validity <= 0) {
                $invite->is_active = false;
            }
        }
        $invite->save();

        // If the user was following the campaign, remove it
        if ($campaign->isFollowing()) {
            $this->campaignFollowService->remove(
                $campaign,
                $this->user
            );
        }

        // Notify all admins of the campaign
        $campaign->notifyAdmins(
            new Header(
                'campaign.join',
                'user',
                'green',
                [
                    'user' => $this->user->name,
                    'campaign' => $campaign->name,
                    'link' => $campaign->getMiddlewareLink()
                ]
            )
        );

        $this->user->log(UserLog::TYPE_CAMPAIGN_JOIN);

        // Make sure the user's cache is cleared
        UserCache::clearCampaigns();
        UserCache::clearRoles();

        return $role->campaign;
    }
}
