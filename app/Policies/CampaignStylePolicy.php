<?php

namespace App\Policies;

use App\Models\CampaignStyle;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignStylePolicy
{
    use HandlesAuthorization;

    public function enable(User $user, CampaignStyle $style): bool
    {
        return $user->can('admin', $style->campaign) && ! $style->is_enabled;
    }

    public function disable(User $user, CampaignStyle $style): bool
    {
        return $user->can('admin', $style->campaign) && $style->is_enabled;
    }
}
