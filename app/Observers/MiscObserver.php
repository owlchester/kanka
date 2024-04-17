<?php

namespace App\Observers;

use App\Facades\EntityCache;
use App\Facades\EntityLogger;
use App\Facades\Mentions;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Observers\Concerns\Copiable;
use App\Services\EntityMappingService;
use App\Services\ImageService;
use Illuminate\Support\Str;

abstract class MiscObserver
{
    use Copiable;
    use PurifiableTrait;

    /**Service to build the mention "map" of the entity */
    protected EntityMappingService $entityMappingService;

    public function __construct(EntityMappingService $entityMappingService)
    {
        $this->entityMappingService = $entityMappingService;
    }

    /**
     */
    public function saving(MiscModel $model)
    {
        $model->slug = Str::slug($model->name, '');
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
        }

        // Is private hook for non-admin (who can't set is_private)
        if (!isset($model->is_private)) {
            $model->is_private = false;
        }
    }


    /**
     */
    public function created(MiscModel $model)
    {
        // Created a new sub entity? Create the parent entity.
        $entity = $model->createEntity();

        $this->copy($entity);

        EntityCache::clearSuggestion($model);
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
        if (!$model->entity) {
            throw new \Exception('Model with no entity?');
        }
        EntityLogger::model($model);

            // Take care of mentions for the entity.
        $this->syncMentions($model, $model->entity);

        // Clear some cache
        EntityCache::clearSuggestion($model);
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
