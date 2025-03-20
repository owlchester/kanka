<?php

namespace App\Jobs\Campaigns;

use App\Models\Campaign;
use App\Services\Campaign\Notifications\HideService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class Hide implements ShouldQueue
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
     *
     * @return void
     */
    public function handle()
    {
        /** @var HideService $service */
        $service = app()->make(HideService::class);
        $campaign = Campaign::find($this->campaign);
        if (! $campaign) {
            // Campaign wasn't found
            Log::warning('Hide Campaign: unknown #' . $this->campaign . '.');
        }
        $service->campaign($campaign)->notify();

        Log::info('Campaign #' . $this->campaign . ' hidden (job)');
    }
}
