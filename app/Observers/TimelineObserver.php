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
    public function deleting(MiscModel $timeline)
    {
        /**
         * We need to do this ourselves and not let mysql to it (set null), because the nested wants to delete
         * all descendants when deleting the parent (soft delete)
         */
        foreach ($timeline->timelines as $sub) {
            $sub->timeline_id = null;
            $sub->save();
        }

        // We need to refresh our foreign relations to avoid deleting our children nodes again
        $timeline->refresh();

        if ($timeline->descendants()->count() > 0) {
            foreach ($timeline->descendants as $sub) {
                if (!empty($sub->timeline_id)) {
                    continue;
                }

                // Got a descendant with the parent id null. Let's get them out of the tree
                $sub->{$sub->getLftName()} = null;
                $sub->{$sub->getRgtName()} = null;
                $sub->save();
            }
        }
    }
}
