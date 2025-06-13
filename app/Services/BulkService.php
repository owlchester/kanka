<?php

namespace App\Services;

use App\Datagrids\Bulks\Bulk;
use App\Exceptions\TranslatableException;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\MiscModel;
use App\Models\Relation;
use App\Observers\Concerns\SaveLocations;
use App\Services\Entity\MoveService;
use App\Services\Entity\TagService;
use App\Services\Entity\TransformService;
use App\Services\Permissions\BulkPermissionService;
use App\Traits\CampaignAware;
use App\Traits\EntityTypeAware;
use App\Traits\RequestAware;
use App\Traits\UserAware;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;

class BulkService
{
    use CampaignAware;
    use EntityTypeAware;
    use RequestAware;
    use SaveLocations;
    use UserAware;

    /** Ids of entities */
    protected array $ids;

    /** Total entities submitted for update */
    protected int $total = 0;

    /** Total entities that were updated */
    protected int $count = 0;

    public function __construct(
        protected EntityService $entityService,
        protected BulkPermissionService $permissionService,
        protected TransformService $transformService,
        protected MoveService $moveService
    ) {}

    public function entities(array $ids = []): self
    {
        $this->ids = $ids;

        return $this;
    }

    /**
     * Total updated entities submitted (can be different from the total that was updated)
     */
    public function total(): int
    {
        return $this->total;
    }

    /**
     * Delete several entities
     *
     * @throws Exception
     */
    public function delete(): int
    {
        $model = $this->getEntity();
        if (isset($this->entityType)) {
            if ($this->entityType->isStandard() && ! $this->entityType->isBookmark()) {
                $with = ['entity', 'entity.entityType', 'entity.campaign'];
                if ($this->entityType->isNested()) {
                    $with[] = 'children';
                }
                $entities = $model->with($with)->has('entity')->whereIn('id', $this->ids)->get();
            } else {
                $entities = $model->whereIn('id', $this->ids)->get();
            }
        } else {
            $entities = $model->with('mirror')->whereIn('id', $this->ids)->get();
        }
        /** @var Entity|Relation $entity */
        foreach ($entities as $entity) {
            if (! $this->can('delete', $entity)) {
                continue;
            }
            if (request()->delete_mirrored && $entity->mirror) {
                $entity->mirror->delete();
                $this->count++;
            }
            $entity->delete();
            $this->count++;
        }

        return $this->count;
    }

    /**
     * @throws Exception
     */
    public function export(): array
    {
        $model = $this->getEntity();
        $entities = [];
        foreach ($this->ids as $id) {
            $entities[] = $model->findOrFail($id);
        }

        return $entities;
    }

    /**
     * Set permissions for several entities
     *
     * @return int number of updated entities
     */
    public function permissions(array $permissions = [], bool $override = true): int
    {
        $model = $this->getEntity();

        $with = [];
        if ($this->entityType->isStandard()) {
            $with = ['entity'];
        }
        $entities = $model->with($with)->whereIn('id', $this->ids)->get();
        foreach ($entities as $entity) {
            if (! $entity instanceof Entity) {
                $entity = $entity->entity;
            }
            if (! $this->can('update', $entity)) {
                continue;
            }
            $this->permissionService
                ->entity($entity)
                ->override($override)
                ->change($permissions);
            $this->count++;
        }

        return $this->count;
    }

    /**
     * @throws TranslatableException
     */
    public function copyToCampaign(Campaign $campaign): int
    {
        $model = $this->getEntity();

        // First we make sure we have access to the new campaign.
        // todo: move this to the request validator
        $check = $this->user->campaigns()->where('campaign_id', $campaign->id)->first();
        if (empty($check)) {
            throw new TranslatableException('crud.move.errors.unknown_campaign');
        }

        $this->moveService
            ->campaign($this->campaign)
            ->copy(true)
            ->to($campaign);

        $with = isset($this->entityType) && $this->entityType->isCustom() ? [
            'entityType', 'image', 'inventories', 'attributes',
        ] : [
            'entity',
            'entity.entityType',
            'entity.image',
            'entity.inventories',
            'entity.attributes',
        ];
        $entities = $model->with($with)->whereIn('id', $this->ids)->get();

        foreach ($entities as $entity) {
            if (! $entity instanceof Entity) {
                $entity = $entity->entity;
            }
            if (! $this->can('update', $entity)) {
                continue;
            }
            if ($this->moveService->entity($entity)->process()) {
                $this->count++;
            }
        }

        return $this->count;
    }

    /**
     * @throws TranslatableException
     */
    public function transform(EntityType $entityType): int
    {
        $this->transformService
            ->entityType($entityType)
            ->campaign($this->campaign);

        $model = $this->getEntity();
        $with = $this->entityType->isStandard() ? ['entity'] : [];

        foreach ($this->ids as $id) {
            $entity = $model->with($with)->findOrFail($id);
            if (! $this->can('update', $entity)) {
                continue;
            }

            if ($this->entityType->isCustom()) {
                $this->transformService->entity($entity);
            } else {
                $this->transformService->child($entity);
            }
            $this->transformService->transform();
            $this->count++;
        }

        return $this->count;
    }

    /**
     * @throws Exception
     */
    public function editing(array $fields, Bulk $bulk): int
    {
        $model = $this->getEntity();

        // Only get fields that can be bulk edited and with content
        $fillableFields = Arr::only($fields, $bulk->fields());
        $filledFields = [];
        $filledForeigns = [];
        foreach ($fillableFields as $field => $value) {
            if (is_array($value) && ! empty($value)) {
                $filledFields[$field] = $value;
            } elseif (! empty($value)) {
                $filledFields[$field] = mb_trim($value);
            }
        }

        // Purify name
        if (Arr::has($filledFields, 'name')) {
            $filledFields['name'] = Purify::clean($filledFields['name']);
        }

        // Loop on boolean fields that can be true, false or null
        foreach ($bulk->booleans() as $field) {
            // Field wasn't provided in request, ignore
            if (! Arr::has($fields, $field)) {
                continue;
            }
            $value = Arr::get($fields, $field);
            // If the field is a boolean type is_ or has_ and the value is null, we skip updating it
            if (Str::startsWith($field, ['is_', 'has_']) && $value === null) {
                // Do nothing
            } else {
                // We don't skip it for example for the relationship colour
                $filledFields[$field] = $value;
            }
        }

        // Loop on all the bulk fields that are foreign relations
        foreach ($bulk->foreignRelations() as $relation) {
            // Field wasn't provided in request, ignore
            if (! Arr::has($fields, $relation)) {
                continue;
            }
            foreach ($fields[$relation] as $foreignID) {
                if (! isset($filledForeigns[$relation])) {
                    $filledForeigns[$relation] = [];
                }
                $filledForeigns[$relation][] = $foreignID;
            }
        }

        // Private
        if (isset($fields['is_private']) && $fields['is_private'] !== null) {
            $filledFields['is_private'] = $fields['is_private'] === '0';
        }

        // Active
        if (isset($fields['is_active']) && $fields['is_active'] !== null) {
            $filledFields['is_active'] = $fields['is_active'] === '1';
        }

        // List of fields that can have +/- math operations, like a character's age
        $maths = $bulk->maths();

        // Handle tags differently
        unset($filledFields['tags']);
        $tagIds = Arr::get($fields, 'tags', []);

        // Handle locations differently
        unset($filledFields['locations']);
        $locationIds = Arr::get($fields, 'locations', []);

        // Handle images differently
        if (isset($filledFields['entity_image'])) {
            $imageUuid = $filledFields['entity_image'];
            unset($filledFields['entity_image']);
        }
        if (isset($filledFields['entity_header'])) {
            $headerUuid = $filledFields['entity_header'];
            unset($filledFields['entity_header']);
        }
        if (isset($filledFields['type'])) {
            $type = $filledFields['type'];
            unset($filledFields['type']);
        }

        if (! isset($this->entityType)) {
            $mirrorOptions = [];
            $mirrorOptions['unmirror'] = (bool) Arr::get($fields, 'unmirror', '0');
            $mirrorOptions['update_mirrored'] = (bool) Arr::get($fields, 'update_mirrored', '0');

            return $this->updateRelations($filledFields, $mirrorOptions);
        }

        $parent = method_exists($model, 'getParentKeyName') ? $model->getParentKeyName() : null;

        // Todo: move model fetch above to actually use with()
        foreach ($this->ids as $id) {
            /** @var MiscModel|Entity $entity */
            $with = $this->entityType->isStandard() ? ['entity', 'entity.tags'] : ['tags'];
            $entity = $model->with($with)->findOrFail($id);
            $this->total++;
            if (! $this->can('update', $entity)) {
                continue;
            }
            $entityFields = $filledFields;

            if (isset($entityFields[$parent]) && intval($entityFields[$parent]) == $entity->id) {
                unset($entityFields[$parent]);
            }

            // Handle math fields
            foreach ($maths as $math) {
                $mathField = Arr::get($entityFields, $math, false);
                if ($mathField !== false && Str::startsWith($mathField, ['+', '-']) && is_numeric($entity->{$math})) {
                    if (Str::startsWith($mathField, '+')) {
                        $entityFields[$math] = $entity->{$math} + (int) Str::after($mathField, '+');
                    } else {
                        $entityFields[$math] = $entity->{$math} - (int) Str::after($mathField, '-');
                    }
                }
            }
            $entity->update($entityFields);

            // Foreign belongsTo loop
            foreach ($filledForeigns as $relation => $ids) {
                $entity->{$relation}()->syncWithoutDetaching($ids);
            }

            // We have to still update the entity object (except for bookmarks)
            $realEntity = null;
            if ($this->entityType->isCustom()) {
                $realEntity = $entity;
                // @phpstan-ignore-next-line
            } elseif ($this->entityType->isStandard() && ! empty($entity->entity)) {
                $realEntity = $entity->entity;
            }
            // Todo: refactor into a trait or function
            if ($realEntity instanceof Entity) {
                if (isset($imageUuid)) {
                    $realEntity->image_uuid = $imageUuid;
                    // Changed the image, reset the focus
                    $realEntity->focus_x = null;
                    $realEntity->focus_y = null;
                }

                if (isset($headerUuid)) {
                    $realEntity->header_uuid = $headerUuid;
                }
                if (isset($type)) {
                    $realEntity->type = $type;
                }

                $realEntity->is_private = $entity->is_private;
                $realEntity->name = $entity->name;
                $realEntity->update();
            }

            $this->count++;

            $locationsAction = Arr::get($fields, 'bulk-locations', 'add');
            if ($locationsAction === 'remove') {
                $entity->locations()->detach($locationIds);
            } elseif (! empty($locationIds)) {
                $this->saveLocations($entity, $locationIds);
            }

            // No tags? We're done
            if (empty($fields['tags'])) {
                continue;
            }

            $tagAction = Arr::get($fields, 'bulk-tagging', 'add');
            if ($tagAction === 'remove') {
                $realEntity->tags()->detach($tagIds);
            } else {
                /** @var TagService $tagService */
                $tagService = app()->make(TagService::class);
                $tagService
                    ->user($this->user)
                    ->entity($realEntity)
                    ->withNew()
                    ->add($tagIds);
                $realEntity->touch();
            }
        }

        return $this->count;
    }

    /**
     * Bulk apply attribute templates
     *
     * @param  string  $template
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function templates(string|int $template): int
    {
        $model = $this->getEntity();

        /** @var AttributeService $service */
        $service = app()->make('App\Services\AttributeService');

        $with = isset($this->entityType) && $this->entityType->isCustom() ? [] : ['entity', 'entity.campaign'];
        $entities = $model->with($with)->whereIn('id', $this->ids)->get();

        foreach ($entities as $entity) {
            if (! $entity instanceof Entity) {
                $entity = $entity->entity;
            }
            if (! $this->can('update', $entity)) {
                continue;
            }
            $service->apply($entity, $template);
            $this->count++;
        }

        return $this->count;
    }

    /**
     * @throws Exception
     */
    protected function getEntity()
    {
        if (isset($this->entityType)) {
            if ($this->entityType->isCustom()) {
                return new Entity;
            }

            return $this->entityType->getClass();
        }

        return new Relation;
    }

    protected function updateRelations(array $filledFields, $mirrorOptions): int
    {
        $relations = Relation::whereIn('id', $this->ids)->get();

        // If the colour is empty, unset it
        if (empty($filledFields['colour'])) {
            unset($filledFields['colour']);
        }

        /** @var Relation $relation */
        foreach ($relations as $relation) {
            $this->total++;
            if (! $this->user->can('update', $relation)) {
                // Can't update this? Technically not possible since bulk editing is only available
                // for admins, but better safe than sorry
                continue;
            }
            // Same owner and target? no bueno
            if ($relation->owner_id == Arr::get($filledFields, 'target_id') || ($relation->target_id == Arr::get($filledFields, 'owner_id'))) {
                continue;
            }
            if ($mirrorOptions['update_mirrored'] && $relation->mirror) {
                $mirrorFields = Arr::except($filledFields, ['target_id', 'owner_id']);
                $relation->mirror->update($mirrorFields);
                $this->count++;
                $this->total++;
            }
            if ($mirrorOptions['unmirror'] && $relation->mirror) {
                $relation->mirror->update(['mirror_id' => null]);
                $filledFields['mirror_id'] = null;
                if (! $mirrorOptions['update_mirrored']) {
                    $this->count++;
                    $this->total++;
                }
            }
            $relation->update($filledFields);
            $this->count++;
        }

        return $this->count;
    }

    protected function can(string $action, $entity): bool
    {
        if (! isset($this->entityType) || ! $this->entityType->hasEntity() || $entity instanceof Entity) {
            return $this->user->can($action, $entity);
        }

        return $this->user->can($action, $entity->entity);
    }
}
