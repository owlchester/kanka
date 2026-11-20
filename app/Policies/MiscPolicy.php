<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\User;
use App\Services\Permissions\EntityPermission;
use Illuminate\Auth\Access\HandlesAuthorization;

class MiscPolicy
{
    use HandlesAuthorization;

    /**
     * @param  Entity|MiscModel|null  $entity
     */
    protected function checkPermission(int $action, User $user, mixed $entity = null, ?Campaign $campaign = null): bool
    {
        return app(EntityPermission::class)->hasPermission(
            // @phpstan-ignore-next-line
            $this->entityTypeID(),
            $action,
            $entity,
            $user,
            $campaign,
        );
    }
}
