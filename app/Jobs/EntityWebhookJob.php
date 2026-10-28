<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\Entity;
use App\Models\User;
use App\Services\WebhookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EntityWebhookJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public Campaign $campaign;

    public Entity $entity;

    public int $action;

    public User $user;

    public int $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Entity $entity, User $user, int $action)
    {
        $this->campaign = $entity->campaign;
        $this->user = $user;
        $this->action = $action;
        $this->entity = $entity;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('EntityWebhookJob for entity #' . $this->entity->id);
        if (! $this->campaign->premium()) {
            return;
        }

        /** @var WebhookService $webhookService */
        $webhookService = app()->make(WebhookService::class);
        $webhookService->campaign($this->campaign)->user($this->user)->entity($this->entity)->process($this->action);

    }

    public function failure()
    {
        // Sentry will handle this
    }
}
