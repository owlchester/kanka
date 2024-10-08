<?php

namespace App\Policies;

use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntityPolicy
{
    use HandlesAuthorization;

    public function attributes(?User $user, Entity $entity): bool
    {
        if ($entity->exists === false) {
            return true;
        }
        return !$entity->is_attributes_private || $user && UserCache::user($user)->admin();
    }

    public function viewAttributes(?User $user, Entity $entity, Campaign $campaign): bool
    {
        if (!$campaign->enabled('entity_attributes')) {
            return false;
        }

        if (!$entity->is_attributes_private) {
            return true;
        }
        return $user && UserCache::user($user)->admin();
    }

    public function privacy(User $user): bool
    {
        return UserCache::user($user)->admin();
    }

    public function history(?User $user, Entity $entity, Campaign $campaign): bool
    {
        return ($user && UserCache::user($user)->admin()) || !($campaign->boosted() && $campaign->hide_history);
    }
}
