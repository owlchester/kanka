<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\Map;
use App\Models\User;

class MapPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.map');
    }

    public function addGroup(User $user, Map $map, Campaign $campaign): bool
    {
        $max = config('limits.campaigns.maps.groups.standard');
        if ($campaign->boosted()) {
            $max = config('limits.campaigns.maps.groups.premium');
        }

        return $map->groups->count() < $max;
    }

    public function addLayer(User $user, Map $map, Campaign $campaign): bool
    {
        $max = config('limits.campaigns.maps.layers.standard');
        if ($campaign->boosted()) {
            $max = config('limits.campaigns.maps.layers.premium');
        }

        return $map->layers->count() < $max;
    }
}
