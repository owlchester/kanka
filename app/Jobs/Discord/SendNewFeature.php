<?php

namespace App\Jobs\Discord;

use App\Models\Feature;
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

        $title = $feature->name;
        $content = 'A new idea has been approved and can be voted on!';

        $response = Http::post(config('discord.webhooks.features') . '?wait=true', [
            'content' => $content,
            'embeds' => [
                [
                    'title' => $title,
                    'description' => strip_tags($feature->description),
                    'color' => config('discord.color'),
                    'url' => route('roadmap', ['status' => 'ideas', 'idea' => $feature->id]),
                    'author' => [
                        'name' => $feature->user->name,
                        'url' => route('users.profile', $feature->created_by),
                        'icon_url' => $feature->user->hasAvatar() ? $feature->user->getAvatarUrl() : null,
                    ],
                ],
            ],
            'wait' => true,
        ]);

        $messageData = $response->json();
        $messageId = $messageData['id'];

        $feature->message_id = $messageData['id'];
        $feature->saveQuietly();
    }
}
