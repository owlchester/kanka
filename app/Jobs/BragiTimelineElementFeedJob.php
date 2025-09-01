<?php

namespace App\Jobs;

use App\Models\TimelineElement;
use App\Services\Bragi\FeedService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BragiTimelineElementFeedJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public TimelineElement $timelineElement;

    public int $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TimelineElement $timelineElement)
    {
        $this->timelineElement = $timelineElement;
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
                ->feedTimelineElement($this->timelineElement);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function failed(Exception $exception)
    {
        throw $exception;
    }
}
