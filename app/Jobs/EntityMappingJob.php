<?php

namespace App\Jobs;

use App\Models\Entity;
use App\Models\Campaign;
use App\Models\Post;
use App\Models\QuestElement;
use App\Models\TimelineElement;
use App\Services\EntityMappingService;
use App\Traits\MentionTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;

class EntityMappingJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use MentionTrait;

    public Model|Post|Entity|QuestElement|TimelineElement|Campaign $model;

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
    public function __construct(Model|Post|Entity|QuestElement|TimelineElement|Campaign $model)
    {
        $this->modelId = $model->id;
        $this->class =  get_class($model);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Get the model
        $model = $this->class::where('id', $this->modelId)->first();

        /** @var EntityMappingService $service */
        $entityMappingService = app()->make(EntityMappingService::class);
        $entityMappingService->with($model)->silent()->map();
    }

    public function failure()
    {
        // Sentry will handle this
    }
}
