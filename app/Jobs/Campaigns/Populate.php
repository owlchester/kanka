<?php

namespace App\Jobs\Campaigns;

use App\Models\Campaign;
use App\Services\StarterService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Populate implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected int $campaign;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign->id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var Campaign|null $campaign */
        $campaign = Campaign::find($this->campaign);
        if (! $campaign) {
            return;
        }

        /** @var StarterService $service */
        $service = app()->make(StarterService::class);

        $service
            ->campaign($campaign)
            ->bind()
            ->create();
    }
}
