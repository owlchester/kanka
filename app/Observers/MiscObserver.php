<?php

namespace App\Observers;

use App\Facades\CampaignLocalization;
use App\Facades\EntityCache;
use App\Facades\Mentions;
use App\Models\Entity;
use App\Models\Location;
use App\Models\MiscModel;
use App\Observers\Concerns\Copiable;
use App\Services\Entity\LogService;
use App\Services\EntityMappingService;
use App\Services\ImageService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

abstract class MiscObserver
{
    use Copiable;
    use PurifiableTrait;

    /**Service to build the mention "map" of the entity */
    protected EntityMappingService $entityMappingService;

    /** Service for logging changes to an entity */
    protected LogService $logService;

    public function __construct(EntityMappingService $entityMappingService, LogService $logService)
    {
        $this->entityMappingService = $entityMappingService;
        $this->logService = $logService;
    }

    /**
     */
    public function saving(MiscModel $model)
    {
        $model->slug = Str::slug($model->name, '');
        if (empty($model->campaign_id)) {
            $model->campaign_id = CampaignLocalization::getCampaign()->id;
            Log::info('Had to get the campaign_id magically for ' . $model->getTable() . ':' . $model->name);
        }
        $model->name = trim($model->name); // Remove empty spaces in names
        //$model->name = strip_tags($model->name);

        // If we're from the "move" service, we can skip this part.
        // Or if we are deleting, we don't want to re-do the whole set foreign ids to null
        if (request()->isMethod('delete') === true) {
            return;
        }

        $attributes = $model->getAttributes();
        if (array_key_exists('entry', $attributes)) {
            $model->entry = $this->purify(Mentions::codify($model->entry));
            // If we created new elements, the bounds are out of sync, so
            // we need to re-calculate this entity's bounds
            if (Mentions::hasNewEntities() && method_exists($model, 'recalculateTreeBounds')) {
                $model->recalculateTreeBounds();
            }
        }

        // Is private hook for non-admin (who can't set is_private)
        if (!isset($model->is_private)) {
            $model->is_private = false;
        }
    }

    /**
     */
    public function saved(MiscModel $model)
    {
        // Whenever a misc model is saved, we need to make sure it has an associated entity with it.
        // If none exists, we need to create one. Otherwise, we need to update it.
        $entity = $model->entity;
        if (empty($entity)) {
            $entity = new Entity([
                'entity_id' => $model->id,
                'campaign_id' => $model->campaign_id,
            ]);
        }
        $entity->is_private = $model->is_private;
        $entity->name = $model->name;
        $entity->type_id = $model->entityTypeId();
        ImageService::handle($entity, 'w/' . $entity->campaign_id);

        // Once saved, refresh the model so that we can call $model->entity
        if ($entity->save()) {
            // Handle image. Let's use a service for this.

            // Take care of mentions for the entity.
            $this->syncMentions($model, $entity);
            $model->refresh();

            // Clear some cache
            EntityCache::clearSuggestion($model);


        }
    }

    /**
     */
    public function created(MiscModel $model)
    {
        // Created a new sub entity? Create the parent entity.
        $entity = $model->createEntity();

        $this->copy($entity);
    }

    /**
     */
    public function deleted(MiscModel $model)
    {
        // Soft-delete the entity
        if ($model->entity) {
            $model->entity->delete();
        }

        // If soft deleting, don't really delete the image
        // @phpstan-ignore-next-line
        if ($model->trashed()) {
            return;
        }

        ImageService::cleanup($model);
    }

    /**
     */
    public function updated(MiscModel $model)
    {
        // We make an extra write to the db when doing this, but we always want the entity's updated_at to be in
        // sync with the model. For example if we just change the description, which is on the sub entity, we
        // still want the entity to be alerted. This is used for the recently modified dashboard widget.

        // Check if the entity exists, because it won't while moving an entity from one type to another.
        if ($model->entity) {
            // We touch the entity but we don't want a log to be generated just yet
            $model->entity->withoutUpdateLog()->touch();

            // If the updated_at is the same as the created_at, we don't need to create a log.
            //if ($model->entity->created_at->is($model->entity->updated_at)) {
            //    return;
            //}

            // Updated log. We do this here to have the dirty attributes of the child
            $this->logService
                ->entity($model->entity)
                ->user(auth()->user())
                ->model($model)
                ->logUpdate();
        }
    }

    /**
     * When saving an entity, we can to update our mentions if they have been changed
     */
    protected function syncMentions(MiscModel $model, Entity $entity)
    {
        //$this->entityMappingService->verbose = true;
        // If the entity's entry has changed, we need to re-build it's map.
        if ($model->isDirty('entry')) {
            $this->entityMappingService->silent()->mapEntity($entity);
        }
    }
}
