<?php

namespace App\Observers\Concerns;

use App\Facades\EntityLogger;
use App\Models\MiscModel;

trait HasMany
{
    protected function saveMany(MiscModel $model, string $relation, array $values, string $classname): void
    {
        $existing = $unique = $recreate = [];
        // Sometimes we have duplicate ids in the db, which we need to clean up
        foreach ($model->$relation as $rel) {
            // If it already exists, we have an issue
            if (!empty($existing[$rel->id])) {
                $recreate[$rel->id] = $rel->id;
                $model->$relation()->detach($rel->id);
                continue;
            }
            $existing[$rel->id] = $rel->id;
            $unique[$rel->id] = $rel->id;
        }

        if (!empty($recreate)) {
            $model->$relation()->attach($recreate);
        }

        $newModels = [];
        $find = new $classname();
        foreach ($values as $id) {
            // Existing race, do nothing
            if (!empty($existing[$id])) {
                unset($existing[$id]);
                continue;
            }
            // If already managed, again, ignore
            if (!empty($unique[$id])) {
                continue;
            }

            $found = $find::find($id);
            if (empty($found)) {
                continue;
            }
            $newModels[] = $found->id;
            EntityLogger::dirty($relation, null);
        }
        $model->$relation()->attach($newModels);

        // Detach the remaining
        if (!empty($existing)) {
            $model->$relation()->detach($existing);
            EntityLogger::dirty($relation, null);
        }
    }
}
