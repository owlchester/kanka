<?php

namespace App\Policies;

use App\Facades\EntityPermission;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\User;

class EntityTypePolicy
{
    public function create(?User $user, EntityType $entityType, Campaign $campaign)
    {
        if (auth()->guest()) {
            return false;
        }

        return EntityPermission::hasPermission($entityType->id, CampaignPermission::ACTION_ADD, $user, null, $campaign);
    }

    public function update(User $user, EntityType $entityType, Campaign $campaign)
    {
        return $entityType->campaign_id === $campaign->id;
    }

    public function delete(User $user, EntityType $entityType, Campaign $campaign)
    {
        return $entityType->campaign_id === $campaign->id && $entityType->isSpecial();
    }

    public function permissions(User $user, EntityType $entityType): bool
    {
        return EntityPermission::hasPermission($entityType->id, CampaignPermission::ACTION_PERMS, $user, null);
    }
}
