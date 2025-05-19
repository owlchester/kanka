<?php

namespace App\Jobs;

use App\Facades\Avatar;
use App\Facades\CampaignLocalization;
use App\Http\Resources\EntityResource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\User;
use App\Models\Webhook;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EntityWebhookJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public Campaign $campaign;

    public Entity $entity;

    public int $action;

    public string $username;

    public int $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Entity $entity, User $user, int $action)
    {
        // Can't save the entity directly into the job because of the child() function not returning a
        // string? Maybe something to do with the to array part of the queue.
        $this->campaign = $entity->campaign;
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
        if (! $this->campaign->premium()) {
            return;
        }

        // Todo: move all of this to a service so it can be tested
        $webhooks = Webhook::active($this->campaign->id, $this->action)->with('tags')->get();
        $entityTags = $this->entity->tags()->pluck('tags.id')->all();
        foreach ($webhooks as $webhook) {
            if ($this->isInvalid($webhook, $entityTags)) {
                continue;
            }

            if ($webhook->type == 1) {
                $data = Str::replace(
                    ['{name}', '{who}', '{url}'],
                    [$this->entity->name, $this->username, route('entities.show', [$this->campaign->id, $this->entity])],
                    $webhook->message
                );
            } else {
                CampaignLocalization::forceCampaign($this->entity->campaign);
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
                    'title' => $this->entity->name,
                    'description' => strval($data),
                    'color' => config('discord.color'),
                    'url' => route('entities.show', [$this->campaign->id, $this->entity]),
                    'author' => [
                        'name' => 'Kanka Webhooks',
                    ],
                ];

                if ($this->entity->hasImage(true)) {
                    $embeds['thumbnail'] = [
                        'url' => Avatar::entity($this->entity)->size(192)->thumbnail(),
                    ];
                }

                $data = [
                    'embeds' => [
                        $embeds,
                    ],
                ];
            }

            try {
                Http::post($webhook->url, $data);
            } catch (Exception $e) {
                // Don't do anything with failures
            }
        }
    }

    public function failure()
    {
        // Sentry will handle this
    }

    protected function isInvalid(Webhook $webhook, array $entityTags): bool
    {
        // Check if the entity is private or the webhook supports private entities.
        if ($this->entity->is_private && $webhook->skipPrivate()) {
            return true;
        }

        // Check that entity has at least one of the tags the webhook has.
        if ($webhook->tags()->count() === 0) {
            return false;
        }
        $tags = $webhook->tags()->pluck('tags.id')->all();

        return (bool) (empty(array_intersect($entityTags, $tags)));
    }
}
