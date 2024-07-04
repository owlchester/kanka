<?php

namespace App\Policies;

use App\Facades\UserCache;
use App\Models\Campaign;
use App\Traits\AdminPolicyTrait;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignTemplatePolicy
{
    use HandlesAuthorization;
    use AdminPolicyTrait;

    public function useTemplates(?User $user, Campaign $campaign): bool
    {
        return $this->isAdmin($user);
    }
}
