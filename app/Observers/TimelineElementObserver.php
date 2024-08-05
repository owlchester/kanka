<?php

namespace App\Observers;

use App\Models\TimelineElement;

class TimelineElementObserver
{
    use ReorderTrait;

    /**
     */
    public function saving(TimelineElement $timelineElement)
    {

        if (empty($timelineElement->position) || $timelineElement->position < 1) {
            $timelineElement->position = 1;
            /** @var ?TimelineElement $last */
            $last = $timelineElement->era->elements()->orderByDesc('position')->first();
            if ($last) {
                $timelineElement->position = $last->position + 1;
            }
        }

        if (empty($timelineElement->colour)) {
            $timelineElement->colour = '';
        }
    }

    /**
     */
    public function saved(TimelineElement $timelineElement)
    {
        $this->reorder($timelineElement);
    }
}
