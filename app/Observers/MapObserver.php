<?php

namespace App\Observers;

use App\Models\Entity;
use App\Models\Map;
use App\Models\MiscModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class MapObserver extends MiscObserver
{
    /**
     * @param Map $map
     */
    public function saving(MiscModel $map)
    {
        // When saving a map that has an image but no height, force the height and width attribute to null
        // to be handled in the ImageHandler. It uses getAttributes on the model but these aren't present
        // for some reason.
        if (empty($map->height)) {
            $map->height = 0;
            $map->width = 0;
        }
        parent::saving($map);

        $map->grid = (int) $map->grid;
    }

    /**
     * @param Map $model
     */
    public function deleting(MiscModel $model)
    {
        /**
         * We need to do this ourselves and not let mysql to it (set null), because the plugin wants to delete
         * all descendants when deleting the parent, which is stupid.
         * @var Map $sub
         */
        foreach ($model->maps as $sub) {
            $sub->map_id = null;
            $sub->save();
        }

        // We need to refresh our foreign relations to avoid deleting our children nodes again
        $model->refresh();
    }

    /**
     * When an element is created, check for the copy option
     * @param MiscModel $model
     */
    public function created(MiscModel $model)
    {
        parent::created($model);

        // Copy eras from timeline
        if (request()->has('copy_elements') && request()->filled('copy_elements')) {
            $sourceId = request()->post('copy_source_id');

            /** @var Entity $source */
            $source = Entity::findOrFail($sourceId);
            if ($source->typeId() == config('entities.ids.map')) {

                $groups = [];
                foreach ($source->map->layers as $sub) {
                    $newSub = $sub->replicate();
                    $newSub->savingObserver = false;
                    $newSub->map_id = $model->id;

                    if (!empty($sub->image) && Storage::exists($sub->image)) {
                        $uniqid = uniqid();
                        $newPath = str_replace('.', $uniqid . '.', $sub->image);
                        $newSub->image = $newPath;
                        if (!Storage::exists($newPath)) {
                            Storage::copy($sub->image, $newPath);
                        }
                    }
                    $newSub->save();
                }
                foreach ($source->map->groups as $sub) {
                    $newSub = $sub->replicate();
                    $newSub->savingObserver = false;
                    $newSub->map_id = $model->id;
                    $newSub->save();
                    $groups[$sub->id] = $newSub->id;
                }
                foreach ($source->map->markers as $sub) {
                    $newSub = $sub->replicate();
                    $newSub->savingObserver = false;
                    $newSub->map_id = $model->id;
                    $newSub->group_id = !empty($newSub->group_id) && isset($groups[$newSub->group_id]) ? $groups[$newSub->group_id] : null;
                    $newSub->save();
                }
            }
        }
    }
}
