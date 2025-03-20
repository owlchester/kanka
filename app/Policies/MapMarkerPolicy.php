<?php

namespace App\Policies;

use App\Models\MapMarker;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MapMarkerPolicy
{
    use HandlesAuthorization;

    public function update(?User $user, MapMarker $mapMarker)
    {
        return $user && $user->can('update', $mapMarker->map->entity);
    }

    public function delete(?User $user, MapMarker $mapMarker)
    {
        return $user && $user->can('update', $mapMarker->map->entity);
    }
}
