<?php

namespace App\Jobs;

use App\Models\Entity;
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

        // Whenever an entity is updated, we always want to re-calculate the cached image.
        if (method_exists($entity, 'clearAvatarCache')) {
            $entity->clearAvatarCache();
        }
    }

    public function failure()
    {
        // Sentry will handle this
    }
}
