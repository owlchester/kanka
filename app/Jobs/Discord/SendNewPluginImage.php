<?php

namespace App\Jobs\Discord;

use App\Models\Plugin;
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

    protected int $plugin;
    protected string $url;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $plugin, string $url)
    {
        $this->plugin = $plugin;
        $this->url = $url;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var Plugin|null $plugin */
        $plugin = Plugin::find($this->plugin);
        if (empty($plugin)) {
            // PluginImage wasn't found
            Log::warning('Jobs/Discord/SendNewPluginImage', ['unknown plugin', 'plugin' => $this->plugin]);

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
            ->title('New plugin image')
            ->content('A new plugin image for plugin ' . $plugin->name . ' is awaiting review')
            ->user($plugin->user)
            ->description('')
            ->url($this->url)
            ->send();

    }
}
