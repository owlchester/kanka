<?php

namespace App\Jobs;

use App\Http\Resources\EntityResource;
use App\Models\Entity;
use App\Models\Webhook;
use App\Models\Campaign;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Facades\Avatar;

class EntityWebhookJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var int
     */
    public $campaignId;

    /**
     * @var int
     */
    public $action;
 
    /**
     * @var string
     */
    public $username;

    /**
     * @var Entity
     */
    public $entity;

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
    public function __construct(Entity $entity, Campaign $campaign, User $user, int $action)
    {
        // Can't save the entity directly into the job because of the child() function not returning a
        // string? Maybe something to do with the to array part of the queue.
        $this->campaignId = $campaign->id;
        $this->username = $user->name;
        $this->action = $action;
        $this->entity = $entity;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('EntityWebhookJob for entity #' . $this->entity->id);

        $webhooks = Webhook::where('campaign_id', $this->campaignId)->where('action', $this->action)->where('status', 1)->get();

        foreach ($webhooks as $webhook) {
            if ($webhook->tags()->count() > 0) {
                $tags = $webhook->tags()->pluck('tags.id')->all();

                if (!$this->entity->tags()->whereIn('tags.id', $tags)->first()) {
                    continue;
                }
            }

            if ($webhook->type == 1) {
                $data = Str::replace(
                    ['{name}', '{who}', '{url}'],
                    [$this->entity->name, $this->username, route('entities.show', [$this->campaignId, $this->entity])],
                    $webhook->message
                 );

            } else {
                $data = [
                    'event' => [
                        'id' => uniqid(),
                        'type' => $webhook->typeKey(),
                        'webhook_id' => $webhook->id,
                        'timestamp' => time(),
                    ],
                    'entity' => new EntityResource($this->entity),
                ];
            }

            if ($webhook->shortUrl() == 'discord') {
                if ($webhook->type == 2) {
                    $data = json_encode($data);
                }
                $embeds = [
                    'title'         => $this->entity->name,
                    'description'   => strval($data),
                    'color'         => config('discord.color'),
                    'url'           => route('entities.show', [$this->campaignId, $this->entity]),
                    'author'        => [
                        'name'  => 'Kanka Webhooks',
                    ],
                ];

                if ($this->entity->hasImage(true)) {
                    $embeds['thumbnail'] = [
                        'url' => Avatar::entity($this->entity)->size(120)->thumbnail(),
                    ];
                }

                $data = [
                    'embeds' => [
                        $embeds,
                    ],
                ];
            }
            Http::post($webhook->url, $data);
        }
    }

    public function failure()
    {
        // Sentry will handle this
    }
}
