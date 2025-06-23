<?php

namespace App\Services;

use App\Events\Campaigns\Members\UserJoined;
use App\Exceptions\RequireLoginException;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignInvite;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\Services\Campaign\FollowService;
use App\Traits\UserAware;
use Exception;
use Illuminate\Support\Facades\Session;

class InviteService
{
    use UserAware;

    public FollowService $campaignFollowService;

    public function __construct(FollowService $campaignFollowService)
    {
        $this->campaignFollowService = $campaignFollowService;
    }

    /**
     * @throws RequireLoginException
     * @throws Exception
     */
    public function useToken(?string $token = null)
    {
        if (empty($token)) {
            throw new Exception(__('campaigns.invites.error.invalid_token'));
        }

        /** @var ?CampaignInvite $invite */
        $invite = CampaignInvite::where('token', $token)->first();
        if (empty($invite)) {
            throw new Exception(__('campaigns.invites.error.invalid_token'));
        }

        // Inactive (removed campaigns won't have their token still in the db)
        if (! $invite->is_active) {
            throw new Exception(__('campaigns.invites.error.inactive_token'));
        }

        if (! $invite->campaign->canHaveMoreMembers()) {
            throw new Exception(__('campaigns/limits.members'));
        }

        if (! isset($this->user)) {
            Session::put('invite_token', $invite->token);
            throw new RequireLoginException(__('campaigns.invites.error.join', ['campaign' => '<strong>' . $invite->campaign->name . '</strong>']));
        }

        $this->join($invite->token);

        return $invite->campaign;
    }

    /**
     * @return bool|Campaign
     */
    public function join(?string $token = null)
    {
        if (empty($token)) {
            $token = Session::get('invite_token');
        }
        /** @var CampaignInvite $invite */
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
            UserCache::clear();

            return true;
        }

        // Add the user to a role if it's provided by the invite link
        if ($invite->role) {
            $memberRole = CampaignRoleUser::create([
                'campaign_role_id' => $invite->role->id,
                'user_id' => $role->user_id,
            ]);
        }

        // Invitation links can have a set number of usage (validity)
        if (! empty($invite->validity)) {
            $invite->validity--;
            if ($invite->validity <= 0) {
                $invite->is_active = false;
            }
        }
        $invite->save();

        // If the user was following the campaign, remove it
        if ($campaign->isFollowing()) {
            $this->campaignFollowService
                ->campaign($campaign)
                ->user($this->user)
                ->remove();
        }

        UserJoined::dispatch($campaign, $this->user, $invite);

        return $role->campaign;
    }
}
