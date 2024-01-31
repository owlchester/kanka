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

class SendNewFeature implements ShouldQueue
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
    public function __construct(Feature $feature)
    {
        $this->feature = $feature->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var Feature|null $feature */
        $feature = Feature::find($this->feature);
        if (empty($feature)) {
            // Feature wasn't found
            Log::warning('Jobs/Discord/SendNewFeature', ['unknown feature', 'feature' => $this->feature]);
            return;
        }
        Log::info('Jobs/Discord/SendNewFeature', ['start', 'feature' => $feature->id]);

        $title = 'New feature request: "' . $feature->name . '" open for votes';
        $content = 'New feature up for voting!';
        $image = '';

        if ($feature->image) {
            $image = $feature->image->imageUrl();
        }

        return Http::post(config('discord.webhook'), [
            'content' => $content,
            'embeds' => [
                [
                    'title' => $title,
                    'description' => $feature->description,
                    'color' => config('discord.color'),
                    'url'   => route('roadmap.feature.show', $this->feature),
                    'thumbnail' => [
                        'url' => $image,
                    ],
                    'author' => [
                        'name'  => $feature->user->name,
                        'url'   => route('profiles.show', $feature->created_by),
                        'icon'  => $feature->user->avatar(),
                    ]
                ]
            ],
        ]);

    }
}
