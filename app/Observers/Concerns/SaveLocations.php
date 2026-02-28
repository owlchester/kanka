<?php

namespace App\Observers\Concerns;

use App\Facades\CampaignLocalization;
use App\Facades\EntityLogger;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Location;
use Stevebauman\Purify\Facades\Purify;

/**
 * We have this as a trait on the LocationsObserver, so that we can also call it from the bulk update service.
 * Mostly because everything is weird and confusing.
 */
trait SaveLocations
{
    protected function saveLocations(Entity $model, array $locations = [])
    {
        $existing = $unique = $recreate = [];
        foreach ($model->locations as $location) {
            // If it already exists, we have an issue
            if (! empty($existing[$location->id])) {
                $recreate[$location->id] = $location->id;
                $model->locations()->detach($location->id);

                continue;
            }
            $existing[$location->id] = $location->id;
            $unique[$location->id] = $location->id;
        }

        if (! empty($recreate)) {
            $model->locations()->attach($recreate);
        }
        if (! $locations) {
            $locations = request()->get('locations', []);
            $detach = true;
        }
        $newLocations = [];
        $canCreate = null;
        foreach ($locations as $id) {
            // Existing location, do nothing
            if (! empty($existing[$id])) {
                unset($existing[$id]);

                continue;
            }
            // If already managed, again, ignore
            if (! empty($unique[$id])) {
                continue;
            }

            if (! is_numeric($id)) {
                $name = mb_trim(Purify::clean($id));
                if (empty($name)) {
                    continue;
                }
                if ($canCreate === null) {
                    $campaign = CampaignLocalization::getCampaign();
                    $entityType = EntityType::find(config('entities.ids.location'));
                    $canCreate = auth()->user()->can('create', [$entityType, $campaign]);
                }
                if (! $canCreate) {
                    continue;
                }
                $location = new Location([
                    'name' => $name,
                    'campaign_id' => $model->campaign_id,
                    'is_private' => false,
                ]);
                $location->saveQuietly();
                $location->createEntity();
                $newLocations[] = $location->id;
                EntityLogger::dirty('locations', null);

                continue;
            }

            $location = Location::find($id);
            if (empty($location)) {
                continue;
            }
            $newLocations[] = $location->id;
            EntityLogger::dirty('locations', null);
        }
        $model->locations()->attach($newLocations);

        // Detach the remaining
        if (! empty($existing) && isset($detach)) {
            $model->locations()->detach($existing);
            EntityLogger::dirty('locations', null);
        }
    }
}
