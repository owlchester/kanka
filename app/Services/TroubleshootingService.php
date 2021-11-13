<?php

namespace App\Services;

use App\Exceptions\TranslatableException;
use App\Facades\CampaignCache;
use App\Facades\UserCache;
use App\Models\AdminInvite;
use App\Models\Campaign;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\Notifications\Header;
use App\User;
use Illuminate\Support\Str;

class TroubleshootingService
{
    /** @var Campaign */
    protected $campaign;

    /** @var User */
    protected $user;

    /**
     * @param $campaignID
     * @return $this
     */
    public function campaign($campaignID): self
    {
        $this->campaign = Campaign::findOrFail($campaignID);
        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function user(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return array
     */
    public function campaigns(): array
    {
        $campaigns = [
            '' => __('helpers.troubleshooting.select_campaign')
        ];
        foreach ($this->user->adminCampaigns() as $id => $name) {
            $campaigns[$id] = $name;
        }

        return $campaigns;
    }

    /**
     * @return AdminInvite
     * @throws TranslatableException
     */
    public function generate(): AdminInvite
    {
        // Already has a token?
        $exists = AdminInvite::where('campaign_id', $this->campaign->id)->first();
        if ($exists) {
            throw (new TranslatableException('helpers.user-helper.errors.token_exists'))
                ->setOptions(['campaign' => $this->campaign->name]);
        }
        $token = new AdminInvite();
        $token->created_by = $this->user->id;
        $token->campaign_id = $this->campaign->id;
        $token->token = Str::uuid();
        $token->save();

        return $token;
    }

    /**
     * Add the user to the campaign as an admin
     * @param AdminInvite $invite
     */
    public function join(AdminInvite $invite)
    {
        $campaign = $invite->campaign;

        // Alert campaign admins (before adding ourselves to it)
        $campaign->notifyAdmins(
            new Header(
                'campaign.troubleshooting.joined',
                'user-shield',
                'green',
                [
                    'user' => $this->user->name,
                    'campaign' => $campaign->name,
                    'link' => $campaign->getMiddlewareLink()
                ]
            )
        );


        // Only add ourselves to the campaign if we aren't already
        $member = CampaignUser::campaignUser($campaign->id, $this->user->id)
            ->first();
        if (!$member) {
            // Add self to campaign_users
            CampaignUser::create([
                'user_id' => $this->user->id,
                'campaign_id' => $invite->campaign_id
            ]);
        }

        // Find the admin role
        $adminRole = $invite->campaign->roles->where('is_admin', 1)->first();
        $roleMember = CampaignRoleUser::where('campaign_role_id', $adminRole->id)
            ->where('user_id', $this->user->id)
            ->first();
        if (!$roleMember) {
            CampaignRoleUser::create([
                'campaign_role_id' => $adminRole->id,
                'user_id' => $this->user->id,
            ]);
        }

        // Cache cleanup
        UserCache::clearCampaigns();
        CampaignCache::campaign($campaign)->clearMembers();

        // Cleanup
        $invite->delete();
    }
}
