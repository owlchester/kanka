<?php

namespace App\Services\Entity\Relations;

use App\Facades\Domain;
use App\Facades\EntityLogger;
use App\Models\Entity;
use App\Models\Location;
use App\Models\MiscModel;
use App\Services\Entity\Relations\Concerns\SupportsPatchMode;
use App\Traits\CreatesEntityFromName;

class LocationRelationsService implements RelationsServiceInterface
{
    use CreatesEntityFromName;
    use SupportsPatchMode;

    public function save(MiscModel $model, array $data): void
    {
        $hasLocations = array_key_exists('locations', $data);
        $hasSaveLocations = array_key_exists('save_locations', $data);

        if (! $hasLocations && ! $hasSaveLocations) {
            return;
        }

        if (Domain::isApi() && ! $hasLocations) {
            return;
        }

        $this->syncLocations($model->entity, (array) ($data['locations'] ?? []), true);
    }

    /**
     * Add-only location attach — used by BulkService which passes an explicit ID array
     * and never wants to detach existing locations.
     */
    public function attach(Entity $entity, array $locationIds): void
    {
        $this->syncLocations($entity, $locationIds, false);
    }

    /** Sync entity locations, optionally detaching removed ones */
    protected function syncLocations(Entity $entity, array $locations, bool $detach): void
    {
        $existing = $unique = $recreate = [];
        foreach ($entity->locations as $location) {
            if (! empty($existing[$location->id])) {
                $recreate[$location->id] = $location->id;
                $entity->locations()->detach($location->id);

                continue;
            }
            $existing[$location->id] = $location->id;
            $unique[$location->id] = $location->id;
        }

        if (! empty($recreate)) {
            $entity->locations()->attach($recreate, ['created_by' => auth()->user()?->id]);
        }

        $newLocations = [];
        $newNames = [];
        foreach ($locations as $id) {
            if (! empty($existing[$id])) {
                unset($existing[$id]);

                continue;
            }
            if (! empty($unique[$id])) {
                continue;
            }
            if (! is_numeric($id)) {
                $newNames[] = $id;

                continue;
            }
            $location = Location::find($id);
            if (empty($location)) {
                continue;
            }
            $newLocations[] = $location->id;
            EntityLogger::dirty('locations', null);
        }

        foreach ($this->resolveNewModels($newNames, Location::class, config('entities.ids.location')) as $newId) {
            $newLocations[] = $newId;
            EntityLogger::dirty('locations', null);
        }

        $entity->locations()->attach($newLocations, ['created_by' => auth()->user()?->id]);

        if ($detach && ! empty($existing)) {
            $entity->locations()->detach($existing);
            EntityLogger::dirty('locations', null);
        }
    }
}
