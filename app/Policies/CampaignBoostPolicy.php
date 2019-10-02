<?php

namespace App\Policies;

use App\Models\CampaignBoost;
use App\User;
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
        //
    }

    /**
     * @param User $user
     * @param CampaignBoost $campaignBoost
     * @return bool
     */
    public function destroy(User $user, CampaignBoost $campaignBoost): bool
    {
        return $campaignBoost->user_id === $user->id;
    }
}
