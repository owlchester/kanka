<?php

namespace App\Observers;

use App\Enums\Permission;
use App\Enums\WebhookAction;
use App\Events\Entities\EntityRestored;
use App\Facades\Permissions;
use App\Jobs\EntityUpdatedJob;
use App\Jobs\EntityWebhookJob;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Models\Image;
use App\Services\Maps\TilingTriggerService;

class EntityObserver
{
    public function created(Entity $entity)
    {
        // If the user has created a new entity but doesn't have the permission to read or edit it,
        // automatically create said permission.
        if (! auth()->user()->can('view', $entity)) {
            $this->grant($entity, Permission::View->value);
        }
        if (! auth()->user()->can('update', $entity)) {
            $this->grant($entity, Permission::Update->value);
        }
        // Refresh the model because adding permissions to the child means we have a new relation
        if (Permissions::granted() && $entity->hasChild()) {
            $entity->unsetRelation('child');
            $entity->reloadChild();
        }

        if ($entity->campaign->premium()) {
            EntityWebhookJob::dispatch($entity, auth()->user(), WebhookAction::CREATED->value);
        }

        if ($entity->isMap() && $entity->image_uuid) {
            $this->maybeTriggerTiling($entity);
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

    protected function grant(Entity $entity, int $action): CampaignPermission
    {
        $permission = new CampaignPermission;
        $permission->entity_id = $entity->id;
        $permission->entity_type_id = $entity->type_id;
        $permission->campaign_id = $entity->campaign_id;
        $permission->user_id = auth()->user()->id;
        $permission->action = $action;
        $permission->access = true;
        $permission->save();
        Permissions::grant($entity);

        return $permission;
    }

    public function updating(Entity $entity): void
    {
        if ($entity->isDirty('image_uuid') && $entity->isMap()) {
            $entity->map->height = null;
            $entity->map->width = null;
            $entity->map->saveQuietly();

            $this->maybeTriggerTiling($entity);
        }
    }

    /**
     * Queue a few jobs whenever an entity gets updated
     */
    public function updated(Entity $entity)
    {
        EntityUpdatedJob::dispatch($entity);

        if ($entity->campaign->premium()) {
            EntityWebhookJob::dispatch($entity, auth()->user(), WebhookAction::EDITED->value);
        }
    }

    public function deleted(Entity $entity)
    {
        // When an entity is soft-deleted, we just want some webhooks to trigger,
        // not actually delete the entity and its image.
        if ($entity->trashed()) {
            if ($entity->campaign->premium()) {
                EntityWebhookJob::dispatch($entity, auth()->user(), WebhookAction::DELETED->value);
            }

            return;
        }

        // Todo: Why is this not handled by the database?
        $entity->permissions()->delete();
        $entity->widgets()->delete();
    }

    public function restored(Entity $entity)
    {
        EntityRestored::dispatch($entity, auth()->user());
    }
}
