<?php


namespace App\Observers;


use App\Facades\Mentions;
use App\Models\TimelineElement;

class TimelineElementObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @param TimelineElement $timelineElement
     */
    public function saving(TimelineElement $timelineElement)
    {
        $timelineElement->name = $this->purify($timelineElement->name);
        $timelineElement->entry = $this->purify(Mentions::codify($timelineElement->entry));

        if (empty($timelineElement->position) || $timelineElement->position < 1) {
            $timelineElement->position = 1;
            /** @var TimelineElement $last */
            $last = $timelineElement->era->elements()->orderByDesc('position')->first();
            if ($last) {
                $timelineElement->position = $last->position+1;
            }
        }
    }
}
