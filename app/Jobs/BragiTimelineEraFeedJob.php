<?php

namespace App\Jobs;

use App\Models\TimelineEra;
use App\Services\Bragi\FeedService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BragiTimelineEraFeedJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public TimelineEra $timelineEra;

    public int $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TimelineEra $timelineEra)
    {
        $this->timelineEra = $timelineEra;
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
                ->feedTimelineEra($this->timelineEra);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function failed(Exception $exception)
    {
        throw $exception;
    }
}
