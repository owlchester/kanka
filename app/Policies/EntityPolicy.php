<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Facades\EntityPermission;
use App\Models\Entity;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class EntityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the entity's attributes.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Entity  $entity
     * @return mixed
     */
    public function attributes(?User $user, Entity $entity)
    {
        if ($entity->exists === false) {
            return true;
        }
        return $entity->is_attributes_private ? ($user && $user->isAdmin()) : true;
    }

    /**
     * @param User $user
     * @param Entity $entity
     * @return bool
     */
    public function privacy(User $user, Entity $entity)
    {
        return $user->isAdmin();
    }

    /**
     * @param User|null $user
     * @param Entity $entity
     * @return bool
     */
    public function history(?User $user, Entity $entity, Campaign $campaign)
    {
        return ($user && $user->isAdmin()) || !($campaign->boosted() && $campaign->hide_history);
    }
}
