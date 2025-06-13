<?php

namespace App\Jobs\Discord;

use App\Models\Feature;
use App\Services\Discord\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendNewFeature implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

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
     */
    public function handle(): void
    {
        /** @var Feature|null $feature */
        $feature = Feature::find($this->feature);
        if (empty($feature)) {
            // Feature wasn't found
            Log::warning('Jobs/Discord/SendNewFeature', ['unknown feature', 'feature' => $this->feature]);

            return;
        }

        $webhook = config('discord.webhooks.features');
        if (empty($webhook)) {
            Log::warning('Jobs/Discord/SendNewFeature', ['no webhook defined']);

            return;
        }
        Log::info('Jobs/Discord/SendNewFeature', ['start', 'feature' => $feature->id]);


        /** @var NotificationService $service */
        $service = app()->make(NotificationService::class);
        $messageData = $service
            ->webhook(config('discord.webhooks.features'))
            ->title($feature->name)
            ->content('A new idea has been approved and can be voted on!')
            ->user($feature->user)
            ->description($feature->description)
            ->url(route('roadmap', ['status' => 'ideas', 'idea' => $feature->id]))
            ->send()
            ->json();

        $feature->message_id = $messageData['id'];
        $feature->saveQuietly();
    }
}
