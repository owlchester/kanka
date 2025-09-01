<?php

namespace App\Jobs;

use App\Models\QuestElement;
use App\Services\Bragi\FeedService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BragiQuestElementFeedJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public QuestElement $questElement;

    public int $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(QuestElement $questElement)
    {
        $this->questElement = $questElement;
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
                ->feedQuestElement($this->questElement);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function failed(Exception $exception)
    {
        throw $exception;
    }
}
