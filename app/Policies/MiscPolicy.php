<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Facades\EntityPermission;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MiscPolicy
{
    use HandlesAuthorization;

    /**
     * @param Entity|MiscModel|null $entity
     */
    protected function checkPermission(int $action, User $user, mixed $entity = null, ?Campaign $campaign = null): bool
    {
        // @phpstan-ignore-next-line
        return EntityPermission::hasPermission($this->entityTypeID(), $action, $user, $entity, $campaign);
    }
}
