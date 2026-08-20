<?php

namespace App\Listeners\Entities;

use App\Enums\WebhookAction;
use App\Events\Entities\EntityCreationCompleted;
use App\Jobs\EntityWebhookJob;
use App\Models\Image;
use App\Services\Maps\TilingTriggerService;

class CompleteEntityCreation
{
    public function handle(EntityCreationCompleted $event): void
    {
        $entity = $event->entity;

        if ($entity->campaign->premium()) {
            EntityWebhookJob::dispatch($entity, auth()->user(), WebhookAction::CREATED->value);
        }

        if (! $entity->isMap() || ! $entity->image_uuid) {
            return;
        }

        $image = Image::find($entity->image_uuid);
        if ($image) {
            app(TilingTriggerService::class)->maybeTrigger($image);
        }
    }
}
