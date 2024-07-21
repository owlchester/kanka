<?php

namespace App\Observers;

use App\Facades\Mentions;
use App\Models\TimelineElement;
use App\Facades\TimelineElementCache;

class TimelineElementObserver
{
    use PurifiableTrait;
    use ReorderTrait;

    /**
     */
    public function saving(TimelineElement $timelineElement)
    {
        $timelineElement->name = $this->purify($timelineElement->name);
        // When creating a timeline element on the API, we might not have an entry
        if (isset($timelineElement->entry)) {
            $timelineElement->entry = $this->purify(Mentions::codify($timelineElement->entry));
        }

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
        TimelineElementCache::clearSuggestion();
        $this->reorder($timelineElement);
    }

    public function deleted()
    {
        TimelineElementCache::clearSuggestion();
    }
}
