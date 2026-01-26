<?php

namespace App\Jobs\Spotlight;

use App\Models\SpotlightContent;
use App\Services\Discord\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DiscordSpotlightJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public SpotlightContent $spotlightContent
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $webhook = config('discord.webhooks.admin');
        if (empty($webhook)) {
            return;
        }

        /** @var NotificationService $service */
        $service = app()->make(NotificationService::class);
        $service
            ->webhook($webhook)
            ->title('Spotlight application for ' . $this->spotlightContent->campaign->name)
            ->content('A campaign applied for a spotlight.')
            ->user($this->spotlightContent->creator)
            ->description(Str::limit(Arr::get($this->spotlightContent->content_json, 'time'), 250))
            ->url('https://admin.kanka.io/spotlight-contents/' . $this->spotlightContent->id)
            ->send();
    }
}
