<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Services\Bragi\FeedService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class BragiFeedJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 1;

    protected $campaignID;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $campaignID)
    {
        $this->campaignID = $campaignID;
        $this->onConnection('heavy');
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

        $now = Carbon::now();
        Log::info('Feeding campaign #' . $this->campaignID);
        try {
            $service
                ->feed($this->campaignID);

            $elapsed = Carbon::now()->diffInMinutes($now);
            Log::info('Fed campaign #' . $this->campaignID . ' in ' . $elapsed . ' minutes.');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function failed(Exception $exception)
    {
        /** @var ?Campaign $campaign */
        $campaign = Campaign::find($this->campaignID);
        if (empty($campaign)) {
            Log::error('No campaign #' . $this->campaignID);

            return;
        }

        Log::error('Saved error for #' . $this->campaignID);

        throw $exception;
    }
}
