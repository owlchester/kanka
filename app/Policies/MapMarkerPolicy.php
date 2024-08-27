<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MapMarker;
use Illuminate\Auth\Access\HandlesAuthorization;

class MapMarkerPolicy
{
    use HandlesAuthorization;

    public function update(?User $user, MapMarker $mapMarker)
    {
        return $user && $user->can('update', $mapMarker->map);
    }

    public function delete(?User $user, MapMarker $mapMarker)
    {
        return $user && $user->can('update', $mapMarker->map);
    }
}
