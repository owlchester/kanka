<?php

namespace App\Jobs;

use App\Models\Entity;
use App\Services\EntityMappingService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class EntityMentionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var integer
     */
    protected $entityId;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var EntityMappingService
     */
    protected $entityMappingService;

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

        // We need to save the url here because when in the queue, we won't have the campaign id injected
        // in the url anymore to read from.
        $this->url = $entity->url();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('EntityMentionJob for entity #' . $this->entityId);

        $this->entityMappingService = app()->make('App\Services\EntityMappingService');
        $entity = Entity::findOrFail($this->entityId);
        $this->entityMappingService->updateMentions($entity, $this->url);
    }

    public function failure()
    {
        // Sentry will handle this
    }
}
