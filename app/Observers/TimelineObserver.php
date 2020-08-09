<?php

namespace App\Observers;

use App\Models\Entity;
use App\Models\Map;
use App\Models\MiscModel;
use Illuminate\Support\Facades\Storage;

class TimelineObserver extends MiscObserver
{
    /**
     * @param MiscModel $timeline
     */
    public function created(MiscModel $timeline)
    {
        parent::created($timeline);

        // Copy eras from timeline
        if (request()->has('copy_eras') && request()->filled('copy_eras')) {
            $sourceId = request()->post('copy_source_id');
            /** @var Entity $source */
            $source = Entity::findOrFail($sourceId);
            if ($source->typeId() == config('entities.ids.timeline')) {

                foreach ($source->timeline->eras as $era) {
                    $newEra = $era->replicate();
                    $newEra->timeline_id = $timeline->id;
                    $newEra->save();
                }
            }
        }
    }
}
