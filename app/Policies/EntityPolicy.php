<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\Entity;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntityPolicy
{
    use HandlesAuthorization;

    public function attributes(?User $user, Entity $entity): bool
    {
        if ($entity->exists === false) {
            return true;
        }
        return !$entity->is_attributes_private || $user && $user->isAdmin();
    }

    public function privacy(User $user): bool
    {
        return $user->isAdmin();
    }

    public function history(?User $user, Entity $entity, Campaign $campaign): bool
    {
        return ($user && $user->isAdmin()) || !($campaign->boosted() && $campaign->hide_history);
    }
}
