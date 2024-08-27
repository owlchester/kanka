<?php

namespace App\Policies;

use App\Models\CampaignBoost;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignBoostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     */
    public function destroy(User $user, CampaignBoost $campaignBoost): bool
    {
        return $campaignBoost->user_id === $user->id;
    }
}
