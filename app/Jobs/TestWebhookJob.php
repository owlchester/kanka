<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\User;
use App\Models\Webhook;
use App\Services\WebhookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TestWebhookJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $campaignId;

    public User $user;

    public Webhook $webhook;

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
    public function __construct(Campaign $campaign, User $user, Webhook $webhook)
    {
        // Can't save the entity directly into the job because of the child() function not returning a
        // string? Maybe something to do with the to array part of the queue.
        $this->campaignId = $campaign->id;
        $this->user = $user;
        $this->webhook = $webhook;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var Campaign|null $campaign */
        $campaign = Campaign::find($this->campaignId);

        /** @var WebhookService $webhookService */
        $webhookService = app()->make(WebhookService::class);
        $webhookService->user($this->user)->campaign($campaign)->test($this->webhook);
    }

    public function failure()
    {
        // Sentry will handle this
    }
}
