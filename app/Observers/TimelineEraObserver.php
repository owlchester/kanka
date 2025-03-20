<?php

namespace App\Observers;

use App\Models\TimelineEra;

class TimelineEraObserver
{
    public function saving(TimelineEra $timelineEra)
    {
        $timelineEra->is_collapsed = (bool) $timelineEra->is_collapsed;
    }

    public function creating(TimelineEra $timelineEra)
    {
        // Give it the last position
        $lastGroup = $timelineEra->timeline->eras()->max('position');
        if ($lastGroup) {
            $timelineEra->position = (int) $lastGroup + 1;
        } else {
            $timelineEra->position = 1;
        }
    }
}
