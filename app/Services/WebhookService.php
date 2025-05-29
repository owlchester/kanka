<?php

namespace App\Services;

use App\Facades\Avatar;
use App\Facades\CampaignLocalization;
use App\Http\Resources\EntityResource;
use App\Models\Webhook;
use App\Traits\UserAware;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

use Exception;

class WebhookService
{
    use UserAware;
    use CampaignAware;
    use EntityAware;

    /**
     */
    public function process(int $action)
    {
        
       // Todo: move all of this to a service so it can be tested
        $webhooks = Webhook::active($this->campaign->id, $action)->with('tags')->get();
        $entityTags = $this->entity->tags()->pluck('tags.id')->all();
        foreach ($webhooks as $webhook) {
            if ($this->isInvalid($webhook, $entityTags)) {
                continue;
            }

            if ($webhook->type == 1) {
                $data = Str::replace(
                    ['{name}', '{who}', '{url}'],
                    [$this->entity->name, $this->user->name, route('entities.show', [$this->campaign->id, $this->entity])],
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

    /**
     */
    public function test(Webhook $webhook)
    {

        if ($webhook->type == 1) {
            $data = Str::replace(
                ['{name}', '{who}', '{url}'],
                ['Thaelia', $this->user->name, route('locations.index', [$this->campaign])],
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
                },',
            ];
        }

        if ($webhook->shortUrl() == 'discord') {
            if ($webhook->type == 2) {
                $data = json_encode($data);
            }
            $embeds = [
                'title' => 'Thaelia',
                'description' => strval($data),
                'color' => config('discord.color'),
                'url' => route('locations.index', [$this->campaign]),
                'author' => [
                    'name' => 'Kanka Webhooks',
                ],
            ];

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
