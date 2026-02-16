<?php

namespace App\Jobs\Discord;

use App\Services\Discord\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ReportJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected string $name;

    protected string $content;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $name, string $content)
    {
        $this->name = $name;
        $this->content = $content;
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
        Log::info('Jobs/Discord/ReportJob', ['start', 'name' => $this->name]);

        /** @var NotificationService $service */
        $service = app()->make(NotificationService::class);
        $messageData = $service
            ->webhook(config('discord.webhooks.admin'))
            ->content('')
            ->description($this->content)
            ->title($this->name)
            ->send()
            ->json();
    }
}
