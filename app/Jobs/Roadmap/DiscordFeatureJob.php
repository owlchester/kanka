<?php

namespace App\Jobs\Roadmap;

use App\Models\Feature;
use App\Services\Discord\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DiscordFeatureJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Feature $feature
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
        $isCancellation = ($this->feature->meta['from'] ?? null) === 'cancellation';
        $content = $isCancellation
            ? '❗ Cancellation - A new idea has been submitted and needs approval.'
            : 'A new idea has been submitted and needs approval.';

        $service
            ->webhook($webhook)
            ->title($this->feature->name)
            ->content($content)
            ->user($this->feature->user)
            ->description($this->feature->description)
            ->url('https://admin.kanka.io/features/' . $this->feature->id)
            ->send();
    }
}
