<?php

namespace App\Policies;

use App\Facades\CampaignLocalization;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Facades\EntityPermission;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

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
