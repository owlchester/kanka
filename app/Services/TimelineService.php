<?php


namespace App\Services;


use App\Models\TimelineElement;

class TimelineService
{
    /**
     * @param TimelineElement $timelineElement
     * @param boolean $replace
     */
    public function reorderElements(TimelineElement $timelineElement, bool $replace = false)
    {
        // First position. If replacing, start where the current one is gone
        $position = $timelineElement->position;
        if (!$replace) {
            $position++;
        }

        // Reorder the position of following elements
        $elements = $timelineElement->era
            ->elements()
            ->where('position', '>=', $timelineElement->position)
            ->where('id', '!=', $timelineElement->id)
            ->orderBy('position')
            ->get();
        foreach ($elements as $element) {
            $element->position = $position;
            $element->save();
            $position++;
        }
    }
}
