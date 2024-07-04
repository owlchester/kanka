<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Traits\AdminPolicyTrait;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignTemplatePolicy
{
    use AdminPolicyTrait;
    use HandlesAuthorization;

    public function useTemplates(?User $user, Campaign $campaign): bool
    {
        return $this->isAdmin($user);
    }
}
