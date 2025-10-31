<?php

namespace App\Traits;

use App\Enums\Permission;
use App\Facades\EntityPermission;
use App\Models\Entity;

trait GuestAuthTrait
{
    public function authEntityView(?Entity $entity = null): void
    {
        if (empty($entity)) {
            if (request()->has('_debug_perm')) {
                dd('cccc');
            }
            abort(403);
        }
        if ($entity->entityType->isStandard() && $entity->isMissingChild()) {
            if (request()->has('_debug_perm')) {
                dd('bb');
            }
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
     *
     * @return void
     */
    protected function authorizeEntityForGuest(Permission $permission, ?Entity $entity)
    {
        // If the misc model is null ($entity->child), the user has no valid access
        if ($entity === null) {
            if (request()->has('_debug_perm')) {
                dd('a');
            }
            abort(403);
        }

        // @phpstan-ignore-next-line
        $permission = EntityPermission::entity($entity)->campaign($this->campaign)->can($permission);

        // @phpstan-ignore-next-line
        if ($this->campaign->id != $entity->campaign_id || ! $permission) {
            // Raise an error
            if (request()->has('_debug_perm')) {
                dump($permission);
                dd('b');
            }
            abort(403);
        }
    }
}
