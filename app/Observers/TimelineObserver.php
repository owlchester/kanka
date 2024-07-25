<?php

namespace App\Observers;

use App\Models\Entity;
use App\Models\Timeline;
use App\Models\MiscModel;

class TimelineObserver extends MiscObserver
{
    /**
     */
    public function created(MiscModel $timeline)
    {
        parent::created($timeline);

        // Copy eras from timeline
        if (request()->has('copy_eras') && request()->filled('copy_eras')) {
            $copyElements = request()->has('copy_elements') && request()->filled('copy_elements');

            $sourceId = request()->post('copy_source_id');
            /** @var Entity $source */
            $source = Entity::findOrFail($sourceId);
            if ($source->isTimeline()) {
                foreach ($source->timeline->eras as $era) {
                    $newEra = $era->replicate();
                    $newEra->timeline_id = $timeline->id;
                    $newEra->save();

                    if ($copyElements) {
                        foreach ($era->elements as $element) {
                            $newElement = $element->replicate();
                            $newElement->timeline_id = $timeline->id;
                            $newElement->era_id = $newEra->id;
                            $newElement->save();
                        }
                    }
                }
            }
        }
    }
}
