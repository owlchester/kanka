<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MapLayer;
use Illuminate\Auth\Access\HandlesAuthorization;

class MapLayerPolicy
{
    use HandlesAuthorization;

    public function update(?User $user, MapLayer $mapLayer)
    {
        return $user && $user->can('update', $mapLayer->map);
    }
    public function delete(?User $user, MapLayer $mapLayer)
    {
        return $user && $user->can('update', $mapLayer->map);
    }
}
