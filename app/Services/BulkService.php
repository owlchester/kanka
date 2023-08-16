<?php

namespace App\Services;

use App\Datagrids\Bulks\Bulk;
use App\Exceptions\TranslatableException;
use App\Models\Relation;
use App\Models\Tag;
use App\Services\Entity\TagService;
use App\Services\Entity\TransformService;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use App\Models\MiscModel;
use Exception;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;

class BulkService
{
    protected EntityService $entityService;

    protected PermissionService $permissionService;

    protected TransformService $transformService;

    /** @var string Entity name */
    protected string $entityName;

    /** @var array Ids of entities */
    protected $ids;

    /** @var int Total entities submitted for update */
    protected int $total = 0;

    /** @var int Total entities that were updated */
    protected int $count = 0;

    /**
     * BulkService constructor.
     * @param EntityService $entityService
     * @param PermissionService $permissionService
     */
    public function __construct(EntityService $entityService, PermissionService $permissionService, TransformService $transformService)
    {
        $this->entityService = $entityService;
        $this->permissionService = $permissionService;
        $this->transformService = $transformService;
    }

    /**
     * @param string $entityName
     * @return $this
     */
    public function entity(string $entityName): self
    {
        $this->entityName = $entityName;
        return $this;
    }

    /**
     * @param array $ids
     * @return $this
     */
    public function entities(array $ids = []): self
    {
        $this->ids = $ids;
        return $this;
    }

    /**
     * Total updated entities submitted (can be different from the total that was updated)
     * @return int
     */
    public function total(): int
    {
        return $this->total;
    }

    /**
     * Delete several entities
     * @return int
     * @throws Exception
     */
    public function delete(): int
    {
        $model = $this->getEntity();
        foreach ($this->ids as $id) {
            $entity = $model->find($id);
            if (auth()->user()->can('delete', $entity)) {
                //dd($entity->descendants);
                if (request()->delete_mirrored && $entity->mirror) {
                    $entity->mirror->delete();
                    $this->count++;
                }
                $entity->delete();
                $this->count++;
            }
        }

        return $this->count;
    }

    /**
     * @return array
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
     * @param array $permissions
     * @param bool $override
     * @return int number of updated entities
     */
    public function permissions(array $permissions = [], bool $override = true): int
    {
        $model = $this->getEntity();

        foreach ($this->ids as $id) {
            $entity = $model->findOrFail($id);
            if (auth()->user()->can('update', $entity)) {
                $this->permissionService->change($permissions, $entity->entity, $override);
                $this->count++;
            }
        }

        return $this->count;
    }

    /**
     * @param int $campaignId
     * @return int
     * @throws TranslatableException
     */
    public function copyToCampaign(int $campaignId): int
    {
        $model = $this->getEntity();

        // First we make sure we have access to the new campaign.
        $campaign = auth()->user()->campaigns()->where('campaign_id', $campaignId)->first();
        if (empty($campaign)) {
            throw new TranslatableException('crud.move.errors.unknown_campaign');
        }

        $options = [
            'campaign' => $campaignId,
            'copy' => 'on'
        ];

        foreach ($this->ids as $id) {
            $entity = $model->findOrFail($id);
            if (auth()->user()->can('update', $entity)) {
                if ($this->entityService->move($entity->entity, $options)) {
                    $this->count++;
                }
            }
        }

        return $this->count;
    }

    /**
     * @param string|null $type
     * @return int
     * @throws TranslatableException
     */
    public function transform(string $type = null): int
    {
        if (empty($type)) {
            throw new TranslatableException('entities/transform.bulk.errors.unknown_type');
        }

        // Validate the type
        $validTypes = config('entities.classes');
        unset($validTypes['menu_link']);
        unset($validTypes['relation']);
        if (!isset($validTypes[$type])) {
            throw new TranslatableException('entities/transform.bulk.errors.unknown_type');
        }

        $model = $this->getEntity();
        foreach ($this->ids as $id) {
            $entity = $model->findOrFail($id);
            if (auth()->user()->can('update', $entity)) {
                $this->transformService
                    ->child($entity)
                    ->transform($type);
                $this->count++;
            }
        }

        return $this->count;
    }

    /**
     * @param array $fields
     * @param Bulk $bulk
     * @return int
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
            if (is_array($value) && !empty($value)) {
                $filledFields[$field] = $value;
            } elseif (!empty($value)) {
                $filledFields[$field] = trim($value);
            }
        }

        // Purify name
        if (Arr::has($filledFields, 'name')) {
            $filledFields['name'] = Purify::clean($filledFields['name']);
        }

        // Loop on boolean fields that can be true, false or null
        foreach ($bulk->booleans() as $field) {
            // Field wasn't provided in request, ignore
            if (!Arr::has($fields, $field)) {
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
            if (!Arr::has($fields, $relation)) {
                continue;
            }
            foreach ($fields[$relation] as $foreignID) {
                if (!isset($filledForeigns[$relation])) {
                    $filledForeigns[$relation] = [];
                }
                $filledForeigns[$relation][] = $foreignID;
            }
        }

        // Private
        if (isset($fields['is_private']) && $fields['is_private'] !== null) {
            $filledFields['is_private'] = $fields['is_private'] === "0";
        }

        // Active
        if (isset($fields['is_active']) && $fields['is_active'] !== null) {
            $filledFields['is_active'] = $fields['is_active'] === "1";
        }

        // List of fields that can have +/- math operations, like a character's age
        $maths = $bulk->maths();

        // Handle tags differently
        unset($filledFields['tags']);
        $tagIds = Arr::get($fields, 'tags', []);

        if ($this->entityName === 'relations') {
            $mirrorOptions = [];
            $mirrorOptions['unmirror'] = (bool) Arr::get($fields, 'unmirror', '0');
            $mirrorOptions['update_mirrored'] = (bool) Arr::get($fields, 'update_mirrored', '0');
            return $this->updateRelations($filledFields, $mirrorOptions);
        }

        // Todo: move model fetch above to actually use with()
        foreach ($this->ids as $id) {
            /** @var MiscModel $entity */
            $entity = $model->with('entity', 'entity.tags')->findOrFail($id);
            $this->total++;
            if (!auth()->user()->can('update', $entity)) {
                // Can't update this? Technically not possible since bulk editing is only available
                // for admins, but better safe than sorry
                continue;
            }
            $entityFields = $filledFields;

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
            $entity->updateQuietly($entityFields);
            // We need to manually call the tree calculation in case the parent was changed to properly rebuild
            if (method_exists($entity, 'forcePendingAction')) {
                $entity->forcePendingAction(); // Usually called in the saving event
                $entity->updateQuietly();
            }

            // Foreign belongsTo loop
            foreach ($filledForeigns as $relation => $ids) {
                $entity->{$relation}()->syncWithoutDetaching($ids);
            }

            // We have to still update the entity object (except for menu links)
            // Todo: refactor into a trait or function
            if (!empty($entity->entity)) {
                $realEntity = $entity->entity;

                $realEntity->is_private = $entity->is_private;
                $realEntity->name = $entity->name;
                $realEntity->save();
            }

            $this->count++;

            // No tags? We're done
            if (empty($fields['tags'])) {
                continue;
            }

            /** @var Collection $existingTags */
            $tagAction = Arr::get($fields, 'bulk-tagging', 'add');
            if ($tagAction === 'remove') {
                $entity->entity->tags()->detach($tagIds);
            } else {
                $existingTags = $entity->entity->tags->pluck('id')->toArray();

                /** @var TagService $tagService */
                $tagService = app()->make(TagService::class);
                $tagService->user(auth()->user());

                // Exclude existing tags to avoid adding a tag several times
                $addTagIds = [];
                foreach ($tagIds as $number => $id) {
                    if (!in_array($id, $existingTags)) {
                        /** @var Tag|null $tag */
                        $tag = Tag::find($id);
                        // Create the tag if the user has permission to do so
                        if (empty($tag) && $tagService->isAllowed()) {
                            $tag = $tagService->create($id, $entity->campaign_id);
                            $tagIds[$number] = $tag->id;
                        }

                        if (!empty($tag)) {
                            $addTagIds[] = $tag->id;
                        }
                    }
                }
                // If we have tags to add
                if (!empty($tagIds)) {
                    $entity->entity->tags()->attach($addTagIds);
                }
            }
        }

        return $this->count;
    }

    /**
     * Bulk apply attribute templates
     * @param string $template
     * @return int
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function templates($template): int
    {
        $model = $this->getEntity();

        /** @var AttributeService $service */
        $service = app()->make('App\Services\AttributeService');

        $entities = $model->with(['entity', 'campaign'])->whereIn('id', $this->ids)->get();

        foreach ($entities as $entity) {
            if (auth()->user()->can('update', $entity)) {
                $service->apply($entity->entity, $template);
                $this->count++;
            }
        }

        return $this->count;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function getEntity()
    {
        $entity = $this->entityService->getClass($this->entityName);
        if (empty($entity)) {
            throw new Exception("Unknown entity name {$this->entityName}.");
        }

        /** @var MiscModel|null $model */
        $model = new $entity();
        if (empty($model)) {
            throw new Exception("Couldn't create a class from {$entity}.");
        }

        return $model;
    }

    /**
     * @param array $filledFields
     * @param array $mirrorOptions
     * @return int
     */
    protected function updateRelations(array $filledFields, $mirrorOptions)
    {
        $relations = Relation::whereIn('id', $this->ids)->get();

        // If the colour is empty, unset it
        if (empty($filledFields['colour'])) {
            unset($filledFields['colour']);
        }

        /** @var Relation $relation */
        foreach ($relations as $relation) {
            $this->total++;
            if (!auth()->user()->can('update', $relation)) {
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
                if (!$mirrorOptions['update_mirrored']) {
                    $this->count++;
                    $this->total++;
                }
            }
            $relation->update($filledFields);
            $this->count++;
        }
        return $this->count;
    }
}
