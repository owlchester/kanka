<?php

namespace App\Listeners\Posts;

use App\Events\Posts\PostCreated;
use App\Events\Posts\PostDeleted;
use App\Events\Posts\PostRestored;
use App\Events\Posts\PostUpdated;
use App\Jobs\BragiPostFeedJob;
use App\Models\Embedding;
use App\Models\Post;
use App\Services\Entity\PostLoggerService;

class FeedPost
{
    /**
     * Create the event listener.
     */
    public function __construct(protected PostLoggerService $postLoggerService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostCreated|PostUpdated|PostRestored|PostDeleted $event): void
    {
        if (!auth()->user()->can('ask', $event->post->entity->campaign)) {
            return;
        }
        if ($event instanceof PostDeleted || $event instanceof PostUpdated) {
            //Delete Ask Bragi embedding
            $oldEmbed = Embedding::where('parent_type', Post::class )->where('parent_id', $event->post->id)->first();
            if ($oldEmbed) {
                $oldEmbed->delete();
            }
            if ($event instanceof PostDeleted) {
                return;
            }
        }

        BragiPostFeedJob::dispatch($event->post);
    }
}
