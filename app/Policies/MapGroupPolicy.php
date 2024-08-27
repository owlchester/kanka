<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MapGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class MapGroupPolicy
{
    use HandlesAuthorization;

    public function update(?User $user, MapGroup $mapGroup)
    {
        return $user && $user->can('update', $mapGroup->map);
    }
    public function delete(?User $user, MapGroup $mapGroup)
    {
        return $user && $user->can('update', $mapGroup->map);
    }
}
