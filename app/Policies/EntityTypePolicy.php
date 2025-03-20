<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Facades\EntityPermission;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\User;

class EntityTypePolicy
{
    public function create(?User $user, EntityType $entityType, Campaign $campaign)
    {
        if (auth()->guest()) {
            return false;
        }

        if (! $entityType->isEnabled()) {
            return false;
        }
        if ($entityType->isSpecial() && ! $campaign->premium()) {
            return false;
        }

        if ($entityType->code === 'bookmark') {
            return auth()->user()->can('create', new Bookmark);
        }

        return EntityPermission::campaign($campaign)->user($user)->entityType($entityType)->can(Permission::Create);
    }

    public function update(User $user, EntityType $entityType, Campaign $campaign)
    {
        return $entityType->campaign_id === $campaign->id;
    }

    public function delete(User $user, EntityType $entityType, Campaign $campaign)
    {
        return $entityType->campaign_id === $campaign->id && $entityType->isSpecial();
    }

    public function deleteEntities(User $user, EntityType $entityType, Campaign $campaign)
    {
        return EntityPermission::campaign($campaign)->user($user)->entityType($entityType)->can(Permission::Delete);
    }

    public function permissions(User $user, EntityType $entityType): bool
    {
        return EntityPermission::entityType($entityType)->user($user)->can(Permission::Permissions);
    }
}
