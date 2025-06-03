<?php

namespace App\Policies;

use App\Models\CampaignStyle;
use App\Models\User;
use App\Traits\AdminPolicyTrait;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignStylePolicy
{
    use AdminPolicyTrait;
    use HandlesAuthorization;

    public function enable(User $user, CampaignStyle $style): bool
    {
        return $user->isAdmin() && ! $style->is_enabled;
    }

    public function disable(User $user, CampaignStyle $style): bool
    {
        return $user->isAdmin() && $style->is_enabled;
    }
}
