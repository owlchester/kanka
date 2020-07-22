<?php


namespace App\Jobs;


use App\Models\Entity;
use App\Models\Family;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EntityUpdatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    public $entityId;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Entity $entity)
    {
        // Can't save the entity directly into the job because of the child() function not returning a
        // string? Maybe something to do with the to array part of the queue.
        $this->entityId = $entity->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var Entity $entity */
        Log::info('EntityUpdateJob for entity #' . $this->entityId);
        $entity = Entity::find($this->entityId);
        if (empty($entity) || empty($entity->child)) {
            // Entity was deleted
            return;
        }

        // Invalid cache
        cache()->forget($entity->child->tooltipCacheKey());

        if ($entity->type == 'tag') {
            /** @var Entity $child */
//            foreach ($entity->child->allChildren()->get() as $child) {
//                if ($child->child) {
//                    cache()->forget($child->child->tooltipCacheKey());
//                    cache()->forget($child->child->tooltipCacheKey('public'));
//                }
//            }
        } elseif ($entity->type == 'family') {
            /** @var Family $family */
            $family = $entity->child;
            foreach ($family->members as $child) {
                cache()->forget($child->tooltipCacheKey());
                cache()->forget($child->tooltipCacheKey('public'));
            }
        }

        // Whenever an entity is updates, we always want to re-calculate the cached image.
        if (method_exists($entity, 'clearAvatarCache')) {
            $entity->clearAvatarCache();
        }
    }

    public function failure()
    {
        // Sentry will handle this
    }

}
