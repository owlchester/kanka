<?php

namespace App\Jobs;

use App\Models\Entity;
use App\Models\Webhook;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Exception;

class TestWebhookJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $campaignId;

    public int $action;

    public string $username;

    public Webhook $webhook;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Campaign $campaign, User $user, Webhook $webhook, int $action)
    {
        // Can't save the entity directly into the job because of the child() function not returning a
        // string? Maybe something to do with the to array part of the queue.
        $this->campaignId = $campaign->id;
        $this->username = $user->name;
        $this->webhook = $webhook;
        $this->action = $action;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var Campaign|null $campaign */
        $campaign = Campaign::find($this->campaignId);

        if ($this->webhook->type == 1) {
            $data = Str::replace(
                ['{name}', '{who}', '{url}'],
                ['Thaelia', $this->username, route('locations.index', [$campaign])],
                $this->webhook->message
            );

        } else {
            $data = [
                'event' => [
                    'id' => uniqid(),
                    'type' => $this->webhook->typeKey(),
                    'webhook_id' => $this->webhook->id,
                    'timestamp' => time(),
                ],
                'entity' => '{
                    "data": [
                        {
                            "id": 1,
                            "name": "Thaelia",
                            "entry": "\n<p>Lorem Ipsum.</p>\n",
                            "image": "{path}",
                            "image_full": "{url}",
                            "image_thumb": "{url}",
                            "has_custom_image": false,
                            "is_private": true,
                            "location_id": null,
                            "entity_id": 5,
                            "tags": [],
                            "created_at":  "2019-01-30T00:01:44.000000Z",
                            "created_by": 1,
                            "updated_at":  "2019-08-29T13:48:54.000000Z",
                            "updated_by": 1,
                            "location_id": 4,
                            "type": "Kingdom"
                        }
                    ]
                },'
            ];
        }

        if ($this->webhook->shortUrl() == 'discord') {
            if ($this->webhook->type == 2) {
                $data = json_encode($data);
            }
            $embeds = [
                'title'         => 'Thaelia',
                'description'   => strval($data),
                'color'         => config('discord.color'),
                'url'           => route('locations.index', [$campaign]),
                'author'        => [
                    'name'  => 'Kanka Webhooks',
                ],
            ];

            $data = [
                'embeds' => [
                    $embeds,
                ],
            ];
        }

        try {
            Http::post($this->webhook->url, $data);
        } catch (Exception $e) {
            // Don't do anything with failures
        }
    }

    public function failure()
    {
        // Sentry will handle this
    }
}
