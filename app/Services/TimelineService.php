<?php


namespace App\Services;


use App\Models\Timeline;
use App\Models\TimelineElement;
use App\Models\TimelineEra;
use App\Http\Requests\ReorderTimelineEras;

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

    /**
     * @param array $data
     * @return bool
     */
    public function reorder(ReorderTimelineEras $request): bool
    {
        $ids = $request->get('timeline_era');
        if (empty($ids)) {
            return false;
        }

        $position = 1;
        foreach ($ids as $id) {
            /** @var TimelineEra $link */
            $link = TimelineEra::where('id', $id)->first();
            if (empty($link)) {
                continue;
            }

            $link->position = $position;
            $link->save();
            $position++;
        }

        return true;
    }
}
