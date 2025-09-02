<?php

namespace App\Jobs;

use App\Models\Embedding;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class BragiCleanupJob implements ShouldQueue
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
        $now = Carbon::now();
        Log::info('Cleaning up campaign #' . $this->campaignID);
        try {
            Embedding::where('campaign_id', $this->campaignID)->delete();

            $elapsed = Carbon::now()->diffInMinutes($now);
            Log::info('Cleaned up embeds of campaign #' . $this->campaignID . ' in ' . $elapsed . ' minutes.');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function failed(Exception $exception)
    {
        Log::error('Saved error for #' . $this->campaignID);

        throw $exception;
    }
}
