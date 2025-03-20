<?php

namespace App\Jobs\Campaigns;

use App\Models\Campaign;
use App\Services\Campaign\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotifyAdmins implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected int $campaign;

    protected string $key;

    protected string $icon;

    protected string $colour;

    protected array $params;

    public function __construct(
        Campaign $campaign,
        string $key,
        string $icon,
        string $colour,
        array $params
    ) {
        $this->campaign = $campaign->id;
        $this->key = $key;
        $this->icon = $icon;
        $this->colour = $colour;
        $this->params = $params;
    }

    public function handle()
    {
        /** @var NotificationService $service */
        $service = app()->make(NotificationService::class);

        /** @var Campaign|null $campaign */
        $campaign = Campaign::find($this->campaign);
        if (! $campaign) {
            Log::warning('Notify campaign: unknown #' . $this->campaign . '.');
        }

        $service
            ->campaign($campaign)
            ->notify($this->key, $this->icon, $this->colour, $this->params);
    }
}
