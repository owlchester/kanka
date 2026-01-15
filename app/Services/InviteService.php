<?php

namespace App\Services;

use App\Enums\ReferralEventType;
use App\Events\Campaigns\Members\UserJoined;
use App\Exceptions\RequireLoginException;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignInvite;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\Models\ReferralEvent;
use App\Services\Campaign\FollowService;
use App\Traits\UserAware;
use Exception;
use Illuminate\Support\Facades\Session;

class InviteService
{
    use UserAware;

    public FollowService $campaignFollowService;

    protected CampaignInvite $invite;

    public function __construct(FollowService $campaignFollowService)
    {
        $this->campaignFollowService = $campaignFollowService;
    }

    /**
     * @throws RequireLoginException
     * @throws Exception
     */
    public function useToken(?string $token = null): self
    {
        if (empty($token)) {
            throw new Exception(__('campaigns.invites.error.invalid_token'));
        }

        /** @var ?CampaignInvite $invite */
        $this->invite = CampaignInvite::where('token', $token)->first();
        if (empty($this->invite)) {
            throw new Exception(__('campaigns.invites.error.invalid_token'));
        }

        // Inactive (removed campaigns won't have their token still in the db)
        if (! $this->invite->is_active) {
            throw new Exception(__('campaigns.invites.error.inactive_token'));
        }

        if (! $this->invite->campaign->canHaveMoreMembers()) {
            throw new Exception(__('campaigns/limits.members'));
        }

        if (! isset($this->user)) {
            Session::put('invite_token', $this->invite->token);
            throw new RequireLoginException(__('campaigns.invites.error.join', ['campaign' => '<strong>' . $this->invite->campaign->name . '</strong>']));
        }

        $this->join();

        return $this;
    }

    public function attribute(): self
    {
        $this->user->referred_by = $this->invite->created_by;
        $this->user->save();

        ReferralEvent::create([
            'created_by' => $this->user->id,
            'referred_by' => $this->invite->created_by,
            'type' => ReferralEventType::invite,
        ]);

        return $this;
    }

    public function invite(CampaignInvite $invite): self
    {
        $this->invite = $invite;

        return $this;
    }

    public function campaign(): Campaign
    {
        return $this->invite->campaign;
    }

    public function join(): self
    {
        Session::forget('invite_token');

        // Already a member?
        $role = CampaignUser::campaignUser($this->invite->campaign->id, $this->user->id)
            ->first();

        if (empty($role)) {
            $role = new CampaignUser([
                'user_id' => $this->user->id,
                'campaign_id' => $this->invite->campaign->id,
            ]);
            $role->save();
        } else {
            // User is already part of the campaign, don't go further otherwise one user can spam the join link and
            // use up all the available tokens (validity field).
            UserCache::clear();

            return $this;
        }

        // Add the user to a role if it's provided by the invite link
        if ($this->invite->role) {
            $memberRole = CampaignRoleUser::create([
                'campaign_role_id' => $this->invite->role->id,
                'user_id' => $role->user_id,
            ]);
        }

        // Invitation links can have a set number of usage (validity)
        $this->invalidate();

        // If the user was following the campaign, remove it
        if ($this->invite->campaign->isFollowing()) {
            $this->campaignFollowService
                ->campaign($this->invite->campaign)
                ->user($this->user)
                ->remove();
        }

        UserJoined::dispatch($this->invite->campaign, $this->user, $this->invite);

        return $this;
    }

    protected function invalidate(): void
    {
        if (empty($this->invite->validity)) {
            return;
        }
        $this->invite->validity--;
        if ($this->invite->validity <= 0) {
            $this->invite->is_active = false;
        }
        $this->invite->save();
    }
}
