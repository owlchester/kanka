<?php

namespace App\Services;

use App\Exceptions\TranslatableException;
use App\Models\AdminInvite;
use App\Models\Campaign;
use App\Models\User;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Str;

class TroubleshootingService
{
    use CampaignAware;
    use UserAware;

    /**
     * Generate a list of campaigns the user is an admin of
     */
    public function campaigns(): array
    {
        $campaigns = [
            '' => __('assistance.placeholders.campaign'),
        ];
        foreach ($this->adminCampaigns() as $id => $name) {
            $campaigns[$id] = $name;
        }

        return $campaigns;
    }

    /**
     * Generate a unique token for the kanka team to join a campaign
     *
     * @throws TranslatableException
     */
    public function generate(): AdminInvite
    {
        // Already has a token?
        $exists = AdminInvite::check($this->campaign->id)->first();
        if ($exists) {
            throw (new TranslatableException('helpers.troubleshooting.errors.token_exists'))
                ->setOptions(['campaign' => $this->campaign->name]);
        }
        $token = new AdminInvite;
        $token->created_by = $this->user->id;
        $token->campaign_id = $this->campaign->id;
        $token->token = Str::uuid();
        $token->save();

        return $token;
    }

    protected function adminCampaigns(): array
    {
        $campaigns = [];

        return $this
            ->user
            ->campaignRoles()
            ->where('campaign_roles.is_admin', 1)
            ->leftJoin('campaigns', 'campaigns.id', '=', 'campaign_roles.campaign_id')
            ->has('campaign')
            ->pluck('campaigns.name', 'campaigns.id')
            ->toArray();
    }
}
