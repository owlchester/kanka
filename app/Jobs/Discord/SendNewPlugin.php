<?php

namespace App\Jobs\Discord;

use App\Models\PluginVersion;
use App\Services\Discord\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNewPlugin implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected int $pluginVersion;
    protected string $url;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $pluginVersion, string $url)
    {
        $this->pluginVersion = $pluginVersion;
        $this->url = $url;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var PluginVersion|null $pluginVersion */
        $pluginVersion = PluginVersion::find($this->pluginVersion);
        if (empty($pluginVersion)) {
            // PluginVersion wasn't found
            Log::warning('Jobs/Discord/SendNewPluginVersion', ['unknown pluginVersion', 'pluginVersion' => $this->pluginVersion]);

            return;
        }

        $webhook = config('discord.webhooks.admin');
        if (empty($webhook)) {
            return;
        }

        /** @var NotificationService $service */
        $service = app()->make(NotificationService::class);
        $service
            ->webhook($webhook)
            ->title('New plugin version')
            ->content('A new plugin version is awaiting review')
            ->user($pluginVersion->plugin->user)
            ->description($pluginVersion->entry)
            ->url($this->url)
            ->send();

    }
}
