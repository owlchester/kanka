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
    }
}
