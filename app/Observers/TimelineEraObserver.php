<?php

namespace App\Observers;

use App\Jobs\BragiTimelineEraFeedJob;
use App\Models\Embedding;
use App\Models\TimelineEra;

class TimelineEraObserver
{
    public function saving(TimelineEra $timelineEra)
    {
        $timelineEra->is_collapsed = (bool) $timelineEra->is_collapsed;
    }

    public function creating(TimelineEra $timelineEra)
    {
        // Give it the last position
        $lastGroup = $timelineEra->timeline->eras()->max('position');
        if ($lastGroup) {
            $timelineEra->position = (int) $lastGroup + 1;
        } else {
            $timelineEra->position = 1;
        }
    }

    public function saved(TimelineEra $timelineEra)
    {
        if (auth()->user()->can('ask', $timelineEra->timeline->campaign)) {
            BragiTimelineEraFeedJob::dispatch($timelineEra);
        }
    }

    public function deleted(TimelineEra $timelineEra)
    {
        //Delete Ask Bragi embedding
        $oldEmbed = Embedding::where('parent_type', TimelineEra::class )->where('parent_id', $timelineEra->id)->first();
        if ($oldEmbed) {
            $oldEmbed->delete();
        }
    }
}
