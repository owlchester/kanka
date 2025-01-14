<?php

namespace App\Policies;

use App\Facades\EntityPermission;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class EntityPolicy
{
    use HandlesAuthorization;

    public function view(?User $user, Entity $entity): bool
    {
        return EntityPermission::hasPermission($entity->entityType->id, CampaignPermission::ACTION_READ, $user, $entity);
    }
    public function update(?User $user, Entity $entity): bool
    {
        return EntityPermission::hasPermission($entity->entityType->id, CampaignPermission::ACTION_EDIT, $user, $entity);
    }


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

    public function move(User $user, Entity $entity): bool
    {
        return $this->update($user, $entity);
    }

    public function inventory(User $user, Entity $entity): bool
    {
        return $this->update($user, $entity);
    }

    public function relation(User $user, Entity $entity): bool
    {
        return $this->update($user, $entity);
    }

    public function permissions(User $user, Entity $entity): bool
    {
        return EntityPermission::hasPermission($entity->entityType->id, CampaignPermission::ACTION_PERMS, $user, $entity);
    }

    public function post(User $user, Entity $entity, string $action = null, ?Post $post = null): bool
    {
        return (
                $this->update($user, $entity) ||
                EntityPermission::hasPermission($entity->entityType->id, CampaignPermission::ACTION_POSTS, $user, $entity) ||
                ($action == 'edit' ? $this->checkPostPermission($user, $post) : false)
            ) ;
    }

    public function delete(User $user, Entity $entity): bool
    {
        return  EntityPermission::hasPermission($entity->entityType->id, CampaignPermission::ACTION_DELETE, $user, $entity);
    }
}
