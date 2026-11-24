<?php

namespace App\Observers;

use App\Enums\WebhookAction;
use App\Events\Entities\EntityCreationCompleted;
use App\Events\Entities\EntityRestored;
use App\Events\Maps\Updated as MapUpdated;
use App\Facades\Images;
use App\Jobs\EntityWebhookJob;
use App\Models\Entity;
use App\Models\Image;
use App\Models\Map;
use App\Services\Maps\TilingTriggerService;

class EntityObserver
{
    public function created(Entity $entity)
    {
        if (! $entity->hasChild() || $entity->entity_id !== null) {
            EntityCreationCompleted::dispatch($entity, auth()->user());
        }
    }

    protected function maybeTriggerTiling(Entity $entity): void
    {
        if (! $entity->image_uuid) {
            return;
        }

        $image = Image::find($entity->image_uuid);
        if ($image) {
            app(TilingTriggerService::class)->maybeTrigger($image);
        }
    }

    public function updating(Entity $entity): void
    {
        if ($entity->isDirty('image_uuid') && $entity->isMap() && $entity->child instanceof Map) {
            $map = $entity->child;
            $map->height = null;
            $map->width = null;
            $map->saveQuietly();

            $this->maybeTriggerTiling($entity);
        }

        if ($entity->isDirty('image_uuid') && ! empty($entity->image_path)) {
            Images::model($entity)->field('image')->cleanup();
        }
    }

    /**
     * Queue a few jobs whenever an entity gets updated
     */
    public function updated(Entity $entity)
    {
        // Being assigned an entity shouldn't trigger any side effects
        if ($entity->wasChanged('entity_id') && $entity->getOriginal('entity_id') === null) {
            return;
        }

        if ($entity->isMap() && $entity->wasChanged('name') && $entity->child instanceof Map) {
            $map = $entity->child;
            $map->setRelation('entity', $entity);
            MapUpdated::dispatch($map);
        }

        if ($entity->campaign->premium() && auth()->check()) {
            EntityWebhookJob::dispatch($entity, auth()->user(), WebhookAction::EDITED->value)->afterCommit();
        }
    }

    public function deleted(Entity $entity)
    {
        // When an entity is soft-deleted, we just want some webhooks to trigger,
        // not actually delete the entity and its image.
        if (! $entity->isForceDeleting()) {
            if ($entity->campaign->premium() && auth()->check()) {
                EntityWebhookJob::dispatch($entity, auth()->user(), WebhookAction::DELETED->value)->afterCommit();
            }

            return;
        }

        // Todo: Why is this not handled by the database?
        $entity->permissions()->delete();
        $entity->widgets()->delete();
    }

    public function forceDeleted(Entity $entity): void
    {
        Images::cleanupEntity($entity);
    }

    public function restored(Entity $entity)
    {
        EntityRestored::dispatch($entity, auth()->user());
    }
}
