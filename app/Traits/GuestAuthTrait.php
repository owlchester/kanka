<?php

namespace App\Traits;

use App\Enums\Permission;
use App\Facades\CampaignLocalization;
use App\Facades\EntityPermission;
use App\Models\CampaignPermission;
use App\Models\Entity;

trait GuestAuthTrait
{
    public function authEntityView(?Entity $entity = null): void
    {
        if (empty($entity)) {
            abort(403);
        }
        if (!$entity->entityType->isSpecial() && $entity->isMissingChild()) {
            abort(403);
        }
        if (auth()->check()) {
            $this->authorize('view', $entity);
        } else {
            $this->authorizeEntityForGuest(Permission::View, $entity);
        }
    }

    /**
     * Secondary Authentication for Guest users
     * @return void
     */
    protected function authorizeEntityForGuest(Permission $permission, ?Entity $entity)
    {
        // If the misc model is null ($entity->child), the user has no valid access
        if ($entity === null) {
            abort(403);
        }

        $campaign = CampaignLocalization::getCampaign();
        $permission = EntityPermission::hasPermission($entity->entityType->id, $permission->value, null, $entity, $campaign);

        // @phpstan-ignore-next-line
        if ($campaign->id != $entity->campaign_id || !$permission) {
            // Raise an error
            abort(403);
        }
    }
}
