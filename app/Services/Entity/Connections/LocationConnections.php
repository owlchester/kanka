<?php

namespace App\Services\Entity\Connections;

use App\Models\Entity;
use App\Models\Location;
use App\Models\MiscModel;
use Illuminate\Support\Collection;

class LocationConnections
{
    /**
     * @param  class-string<MiscModel>  $model
     * @param  list<string>  $with
     * @return Collection<int, Entity>
     */
    public function entities(Location $location, string $model, array $with = []): Collection
    {
        return $model::query()
            ->where('campaign_id', $location->campaign_id)
            ->whereHas('entity', fn ($entities) => $entities->whereHas(
                'entityLocations',
                fn ($locations) => $locations->where('location_id', $location->id),
            ))
            ->with(['entity' => fn ($entities) => $entities->with($with)])
            ->get()
            ->pluck('entity')
            ->filter(fn (?Entity $entity) => $entity !== null)
            ->values();
    }
}
