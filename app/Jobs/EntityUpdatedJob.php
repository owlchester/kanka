<?php

namespace App\Jobs;

use App\Facades\Avatar;
use App\Models\Entity;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EntityUpdatedJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public Entity $entity;

    public array $dirty;

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
        // Serialize the model directly to the db
        $this->entity = $entity;
        $this->dirty = $entity->getDirty();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('EntityUpdateJob for entity #' . $this->entity->id);

        // Whenever the image is updated, clear the avatar cache
        if ($this->isDirty(['image_uuid', 'image_path'])) {
            Avatar::entity($this->entity)->forget();
        }
    }

    public function failure()
    {
        // Sentry will handle this
    }

    /**
     * Determine if a specific field was changed on the entity when saving
     */
    protected function isDirty(array $keys): bool
    {
        foreach ($this->dirty as $key => $val) {
            if (in_array($key, $keys)) {
                return true;
            }
        }

        return false;
    }
}
