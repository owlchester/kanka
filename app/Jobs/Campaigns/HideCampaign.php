<?php

namespace App\Jobs\Campaigns;

use App\Observers\CampaignObserver;
use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HideCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var int */
    protected $campaign;

    /**queue
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
        $service = app()->make(\App\Services\CampaignService::class);
        $campaign = Campaign::find($this->campaign);
        if (!$campaign) {
            // Campaign wasn't found
            Log::warning('Hide Campaign: unknown #' . $this->campaign . '.');
        }

        Campaign::observe(CampaignObserver::class);

        $service->hide($campaign);

        Log::info('Campaign #' . $this->campaign . ' hidden (job)');
    }
}
