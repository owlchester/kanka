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
}
