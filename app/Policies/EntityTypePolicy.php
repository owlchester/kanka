<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\User;
use App\Services\Permissions\EntityPermission;

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
        if ($entityType->isCustom() && ($entityType->campaign_id !== $campaign->id || ! $campaign->premium())) {
            return false;
        }

        if ($entityType->code === 'bookmark') {
            return auth()->user()->can('create', [Bookmark::class, $campaign]);
        }

        return app(EntityPermission::class)->canEntityType($entityType, Permission::Create, $user, $campaign);
    }

    public function update(User $user, EntityType $entityType, Campaign $campaign)
    {
        return $entityType->campaign_id === $campaign->id;
    }

    public function delete(User $user, EntityType $entityType, Campaign $campaign)
    {
        return $entityType->campaign_id === $campaign->id && $entityType->isCustom();
    }

    public function deleteEntities(User $user, EntityType $entityType, Campaign $campaign)
    {
        return app(EntityPermission::class)->canEntityType($entityType, Permission::Delete, $user, $campaign);
    }

    public function permissions(User $user, EntityType $entityType): bool
    {
        return app(EntityPermission::class)->canEntityType($entityType, Permission::Permissions, $user);
    }
}
