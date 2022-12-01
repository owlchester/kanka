<?php

namespace App\Observers;

use App\Facades\Mentions;
use App\Models\TimelineEra;

class TimelineEraObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @param TimelineEra $timelineEra
     */
    public function saving(TimelineEra $timelineEra)
    {
        $timelineEra->entry = $this->purify(Mentions::codify($timelineEra->entry));
        $timelineEra->name = $this->purify($timelineEra->name);
        $timelineEra->is_collapsed = (bool) $timelineEra->is_collapsed;
    }

    public function creating(TimelineEra $timelineEra)
    {
        // Give it the last position
        $lastGroup = $timelineEra->timeline->eras()->max('position');
        if ($lastGroup) {
            $timelineEra->position = (int)$lastGroup + 1;
        } else {
            $timelineEra->position = 1;
        }
    }
}
