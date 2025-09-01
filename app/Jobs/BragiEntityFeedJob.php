<?php

namespace App\Jobs;

use App\Models\Entity;
use App\Services\Bragi\FeedService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BragiEntityFeedJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public Entity $entity;

    public int $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var FeedService $service */
        $service = app()->make(FeedService::class);

        try {
            $service
                ->feedEntity($this->entity);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function failed(Exception $exception)
    {
        Log::error('Saved error for #' . $this->entity->id);

        throw $exception;
    }
}
