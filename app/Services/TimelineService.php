<?php

namespace App\Services;

use App\Http\Requests\ReorderTimeline;
use App\Models\Timeline;
use App\Models\TimelineElement;
use App\Models\TimelineEra;
use Illuminate\Support\Arr;

class TimelineService
{
    protected Timeline $timeline;

    /**
     * @return $this
     */
    public function timeline(Timeline $timeline): self
    {
        $this->timeline = $timeline;

        return $this;
    }

    public function reorderElements(TimelineElement $timelineElement, bool $replace = false)
    {
        // First position. If replacing, start where the current one is gone
        $position = $timelineElement->position;
        if (! $replace) {
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

    public function reorder(ReorderTimeline $request): bool
    {
        $ids = $request->get('timeline_era');
        $elementIds = $request->get('timeline_element');
        if (empty($ids)) {
            return false;
        }

        $position = 1;
        foreach ($ids as $id) {
            /** @var ?TimelineEra $era */
            $era = TimelineEra::find($id);
            if ($era === null || $era->timeline_id !== $this->timeline->id) {
                continue;
            }

            $era->position = $position;
            $era->save();
            $position++;

            // Reorder elements
            $elements = Arr::get($elementIds, $id, []);
            if (empty($elements)) {
                continue;
            }
            $elementPosition = 1;
            // dump($elements);
            foreach ($elements as $elementId) {
                /** @var ?TimelineElement $element */
                $element = TimelineElement::find($elementId);
                if ($element === null || $element->timeline_id !== $this->timeline->id) {
                    continue;
                }

                // Reposition
                // dump("Reposition $element->name (# $element->id) to $elementPosition");
                $element->position = $elementPosition;
                $element->save();

                $elementPosition++;
            }
        }

        // dd('w');

        return true;
    }
}
