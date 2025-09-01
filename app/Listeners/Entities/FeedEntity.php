<?php

namespace App\Listeners\Entities;

use App\Events\Entities\EntityRestored;
use App\Jobs\BragiEntityFeedJob;
use App\Jobs\BragiPostFeedJob;
use App\Jobs\BragiQuestElementFeedJob;
use App\Jobs\BragiTimelineElementFeedJob;
use App\Jobs\BragiTimelineEraFeedJob;
use App\Models\Quest;
use App\Models\Timeline;

class FeedEntity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EntityRestored $event): void
    {
        if ($event->user->can('ask', $event->entity->campaign)) {
            BragiEntityFeedJob::dispatch($event->entity);

            //Handle Embeds
            $posts = $event->entity->posts;
            foreach ($posts as $post) {
                BragiPostFeedJob::dispatch($post);
            }

            if ($event->entity->isTimeline()) {
                $child = Timeline::withTrashed()->with('eras', 'elements')->where('id', $event->entity->entity_id)->first();
                if ($child) {
                    foreach ($child->elements as $element) {
                        BragiTimelineElementFeedJob::dispatch($element);
                    }

                    foreach ($child->eras as $era) {
                        BragiTimelineEraFeedJob::dispatch($era);
                    }
                }
            } elseif ($event->entity->isQuest()) {
                 
                $child = Quest::withTrashed()->with('elements')->where('id', $event->entity->entity_id)->first();
                if ($child) {
                    foreach ($child->elements as $element) {
                        BragiTimelineElementFeedJob::dispatch($element);
                    }
                }   
            }     
        }
    }
}
