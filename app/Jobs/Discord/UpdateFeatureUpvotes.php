<?php

namespace App\Jobs\Discord;

use Illuminate\Support\Facades\Http;
use App\Models\Feature;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateFeatureUpvotes implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**  */
    protected int $feature;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $feature)
    {
        $this->feature = $feature;
    }

    /**
     * Execute the job.
     *
     */
    public function handle(): void
    {
        /** @var Feature|null $feature */
        $feature = Feature::find($this->feature);
        if (empty($feature) || empty($feature->message_id)) {
            // Feature wasn't found
            Log::warning('Jobs/Discord/UpdateFeatureUpvotes', ['unknown feature or no message_id', 'feature' => $this->feature]);
            return;
        }

        $webhook = config('discord.webhooks.features');
        if (empty($webhook)) {
            Log::warning('Jobs/Discord/UpdateFeatureUpvotes', ['no webhook defined']);
            return;
        }
        Log::info('Jobs/Discord/UpdateFeatureUpvotes', ['start', 'feature' => $feature->id]);

        $content = 'A new idea has been approved and can be voted on! :arrow_up_small: ' . $feature->upvote_count . '.';

        // Construct the message edit URL
        $editUrl = config('discord.webhooks.features') . "/messages/{$feature->message_id}";

        Http::patch($editUrl, [
            'content' => $content,
        ]);

    }
}
