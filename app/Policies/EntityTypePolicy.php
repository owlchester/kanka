<?php

namespace App\Policies;

use App\Facades\EntityPermission;
use App\Models\Campaign;
use App\Models\CampaignPermission;
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
}
