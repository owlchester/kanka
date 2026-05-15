<?php

namespace App\Policies;

use App\Models\CampaignPlugin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignPluginPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can enable the campaignPlugin.
     */
    public function enable(User $user, CampaignPlugin $campaignPlugin): bool
    {
        return $user->can('admin', $campaignPlugin->campaign);
    }
}
