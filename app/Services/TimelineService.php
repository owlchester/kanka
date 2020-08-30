<?php


namespace App\Services;


use App\Models\Timeline;
use App\Models\TimelineElement;
use App\Models\TimelineEra;

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

    /**
     * @param TimelineEra $era
     * @param array $ids
     */
    public function reorderEra(TimelineEra $era, array $ids)
    {
        if (empty($ids) || !is_array($ids)) {
            return;
        }

        $position = 1;
        foreach ($ids as $id) {
            /** @var TimelineElement $element */
            $element = $era->elements()->where('id', $id)->first();
            if ($element) {
                $element->position = $position;
                $element->save();
                $position += 1;
            }
        }
    }
}
