<?php

namespace App\Observers;

use App\Models\TimelineElement;

class TimelineElementObserver
{
    use PurifiableTrait;
    use ReorderTrait;

    /**
     */
    public function saving(TimelineElement $timelineElement)
    {

        if (empty($timelineElement->position) || $timelineElement->position < 1) {
            $timelineElement->position = 1;
            /** @var TimelineElement|null $last */
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
