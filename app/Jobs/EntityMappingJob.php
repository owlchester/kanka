<?php

namespace App\Jobs;

use App\Services\EntityMappingService;
use App\Traits\MentionTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EntityMappingJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use MentionTrait;
    use Queueable;
    use SerializesModels;

    public Model $model;

    public int $modelId;

    public string $class;

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
    public function __construct(Model $model)
    {
        // @phpstan-ignore-next-line
        $this->modelId = $model->id;
        $this->class = get_class($model);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get the model
        $model = $this->class::find($this->modelId);
        if (! $model) {
            return;
        }

        /** @var EntityMappingService $entityMappingService. */
        $entityMappingService = app()->make(EntityMappingService::class);
        $entityMappingService->with($model)->silent()->map();
    }

    public function failure()
    {
        // Sentry will handle this
    }
}
