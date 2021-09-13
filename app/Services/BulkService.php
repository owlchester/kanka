<?php

namespace App\Services;

use App\Datagrids\Bulks\Bulk;
use App\Exceptions\TranslatableException;
use App\Models\Relation;
use App\Models\Tag;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\MiscModel;
use Exception;
use Illuminate\Support\Str;

class BulkService
{
    /**
     * @var EntityService
     */
    protected $entityService;

    /**
     * @var PermissionService
     */
    protected $permissionService;

    /** @var string Entity name */
    protected $entityName;

    /** @var array Ids of entities */
    protected $ids;

    /** @var int Total entities submitted for update */
    protected $total = 0;

    /**
     * BulkService constructor.
     * @param EntityService $entityService
     * @param PermissionService $permissionService
     */
    public function __construct(EntityService $entityService, PermissionService $permissionService)
    {
        $this->entityService = $entityService;
        $this->permissionService = $permissionService;
    }

    /**
     * @param string $entityName
     * @return $this
     */
    public function entity(string $entityName)
    {
        $this->entityName = $entityName;
        return $this;
    }

    /**
     * @param array $ids
     * @return $this
     */
    public function entities(array $ids = [])
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
     * @param string $entityName
     * @param array $ids
     * @return int
     * @throws Exception
     */
    public function delete()
    {
        $model = $this->getEntity();

        $count = 0;
        foreach ($this->ids as $id) {
            $entity = $model->find($id);
            if (Auth::user()->can('delete', $entity)) {
                //dd($entity->descendants);
                $entity->delete();
                $count++;
            }
        }

        return $count;
    }

    /**
     * @param $entityName
     * @param array $ids
     * @return array
     * @throws Exception
     */
    public function export()
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
     * @param array $users
     * @param array $roles
     * @return int number of updated entities
     */
    public function permissions(array $permissions = [], bool $override = true): int
    {
        $count = 0;
        $model = $this->getEntity();

        foreach ($this->ids as $id) {
            $entity = $model->findOrFail($id);
            if (Auth::user()->can('update', $entity)) {
                $this->permissionService->change($permissions, $entity->entity, $override);
                $count++;
            }
        }

        return $count;
    }

    /**
     * @param int $campaignId
     * @return int
     * @throws TranslatableException
     */
    public function copyToCampaign(int $campaignId): int
    {
        $count = 0;
        $model = $this->getEntity();

        // First we make sure we have access to the new campaign.
        $campaign = Auth::user()->campaigns()->where('campaign_id', $campaignId)->first();
        if (empty($campaign)) {
            throw new TranslatableException('crud.move.errors.unknown_campaign');
        }

        $options = [
            'campaign' => $campaignId,
            'copy' => 'on'
        ];

        foreach ($this->ids as $id) {
            $entity = $model->findOrFail($id);
            if (Auth::user()->can('update', $entity)) {
                $this->entityService->move($entity->entity, $options);
                $count++;
            }
        }

        return $count;
    }

    /**
     * @param array $fields
     * @param Bulk $bulk
     * @return int
     * @throws Exception
     */
    public function editing(array $fields, Bulk $bulk): int
    {
        $count = 0;
        $model = $this->getEntity();

        // Only get fields that can be bulk edited and with content
        $fillableFields = Arr::only($fields, $bulk->fields());
        $filledFields = [];
        foreach ($fillableFields as $field => $value) {
            if (!empty($value)) {
                $filledFields[$field] = $value;
            }
        }

        foreach ($bulk->mappings() as $field) {
            if (Arr::has($fields, $field)) {
                $value = Arr::get($fields, $field);
                if (Str::startsWith($field, 'is_') && $value === null) {
                    // Do nothing
                } else {
                    $filledFields[$field] = $value;
                }
            }
        }

        // Private
        if (isset($fields['is_private']) && $fields['is_private'] !== null) {
            $filledFields['is_private'] = $fields['is_private'] === "0";
        }

        // Mathable fields
        $maths = $bulk->maths();

        // Handle tags differently
        unset($filledFields['tags']);
        $tagIds = Arr::get($fields, 'tags', []);

        if ($this->entityName === 'relations') {
            return $this->updateRelations($filledFields);
        }

        // Todo: move model fetch above to actually use with()
        foreach ($this->ids as $id) {
            /** @var MiscModel $entity */
            $entity = $model->with('entity', 'entity.tags')->findOrFail($id);
            if (!Auth::user()->can('update', $entity)) {
                // Can't update this? Technically not possible since bulk editing is only available
                // for admins, but better safe than sorry
                $this->total++;
                continue;
            }
            $entity->savingObserver = false;
            $entityFields = $filledFields;

            // Handle math fields
            foreach ($maths as $math) {
                $mathField = Arr::get($entityFields, $math, false);
                if ($mathField !== false && Str::startsWith($mathField, ['+', '-']) && is_numeric($entity->{$math})) {
                    if (Str::startsWith($mathField, '+')) {
                        $entityFields[$math] = $entity->{$math} + (int) Str::after($mathField, '+');
                    } else {
                        $entityFields[$math] = $entity->{$math} - (int)Str::after($mathField, '-');
                    }
                }
            }

            // Age can be manage differently (math)

            $entity->update($entityFields);

            // We have to still update the entity object
            $realEntity = $entity->entity;

            $realEntity->is_private = $entity->is_private;
            $realEntity->name = $entity->name;
            $realEntity->save();

            $count++;

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
                $addTagIds = $tagIds;
                // Exclude existing tags to avoid adding a tag several times
                if (!empty($existingTags)) {
                    $addTagIds = [];
                    foreach ($tagIds as $tag) {
                        if (!in_array($tag, $existingTags)) {
                            $addTagIds[] = $tag;
                        }
                    }
                }
                // If we have tags to add
                if (!empty($tagIds)) {
                    $entity->entity->tags()->attach($addTagIds);
                }
            }
        }

        return $count;
    }

    /**
     * Bulk apply attribute templates
     * @param string $template
     * @return int
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function templates($template): int
    {
        $count = 0;
        $model = $this->getEntity();

        /** @var AttributeService $service */
        $service = app()->make('App\Services\AttributeService');

        $entities = $model->with(['entity', 'campaign'])->whereIn('id', $this->ids)->get();

        foreach ($entities as $entity) {
            if (Auth::user()->can('update', $entity)) {
                $service->apply($entity->entity, $template);
                $count++;
            }
        }

        return $count;
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

        $model = new $entity();
        if (empty($model)) {
            throw new Exception("Couldn't create a class from {$this->entity}.");
        }

        return $model;
    }

    /**
     * @param array $filledFields
     * @return int
     */
    protected function updateRelations(array $filledFields)
    {
        $relations = Relation::whereIn('id', $this->ids)->get();
        $count = 0;
        foreach ($relations as $relation) {
            $this->total++;
            if (!Auth::user()->can('update', $relation)) {
                // Can't update this? Technically not possible since bulk editing is only available
                // for admins, but better safe than sorry
                continue;
            }
            // Same owner and target? no bueno
            if ($relation->owner_id == Arr::get($filledFields, 'target_id') || ($relation->target_id == Arr::get($filledFields, 'owner_id'))) {
                continue;
            }

            $relation->update($filledFields);
            $count++;
        }

        return $count;
    }
}
