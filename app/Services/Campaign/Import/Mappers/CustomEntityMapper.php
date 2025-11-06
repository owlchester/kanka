<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Facades\EntityLogger;
use App\Facades\ImportIdMapper;
use App\Models\Entity;
use App\Models\EntityLocation;
use App\Services\EntityMappingService;
use Illuminate\Support\Facades\Log;

trait CustomEntityMapper
{
    protected array $mapping = [];

    protected array $parents = [];

    protected Entity $entity;

    protected EntityMappingService $entityMappingService;

    public function __construct(EntityMappingService $entityMappingService)
    {
        $this->entityMappingService = $entityMappingService;
    }

    protected function prepareEntity(): self
    {
        $this->entity();

        return $this;
    }

    protected function loadEntity(): self
    {
        $id = ImportIdMapper::getEntity($this->data['entity']['id']);
        $this->entity = Entity::where('id', $id)->firstOrFail();

        return $this;
    }

    protected function trackMappings(?string $parent = null): void
    {
        $this->mapping[$this->data['entity']['id']] = $this->entity->id;
        ImportIdMapper::putEntity($this->data['entity']['id'], $this->entity->id);
        if ($parent && ! empty($this->data['entity'][$parent])) {
            $this->parents[$this->data['entity'][$parent]][] = $this->entity->id;
        }
    }

    protected function entity(): void
    {
        $entityMapping = ['name', 'is_private', 'tooltip', 'is_template', 'is_attributes_private', 'focus_x', 'focus_y', 'entry', 'type'];
        $this->entity = new Entity;
        $this->entity->created_by = $this->user->id;
        $this->entity->updated_by = $this->user->id;
        $this->entity->campaign_id = $this->campaign->id;
        // Log::info(ImportIdMapper::getCustomEntityTypes());

        $this->entity->type_id = ImportIdMapper::getCustomEntityType($this->data['entity']['type_id']);
        foreach ($entityMapping as $field) {
            $this->entity->$field = $this->data['entity'][$field];
        }

        $this
            ->images()
            ->gallery();
        $this->entity->save();

        EntityLogger::entity($this->entity)->create();

        ImportIdMapper::putEntity($this->data['entity']['id'], $this->entity->id);

        $this
            ->assets()
            ->tags();
    }

    public function second(): void
    {
        $this
            ->entitySecond();
    }

    protected function entitySecond(): void
    {
        $this->entity->tooltip = $this->mentions($this->entity->tooltip);
        $this->entity->entry = $this->mentions($this->entity->entry);
        $this->entity->save();

        $this->posts()
            ->attributes()
            ->relations()
            ->reminders()
            ->abilities()
            ->inventory()
            ->locations();
    }

    protected function locations(): self
    {
        if (empty($this->data['entity']['entityLocations'])) {
            return $this;
        }

        foreach ($this->data['entity']['entityLocations'] as $data) {
            if (! ImportIdMapper::has('locations', $data['location_id'])) {
                continue;
            }
            $locID = ImportIdMapper::get('locations', $data['location_id']);
            $entityLoc = new EntityLocation;
            $entityLoc->entity_id = $this->entity->id;
            $entityLoc->location_id = $locID;
            $entityLoc->save();
        }

        return $this;
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $models = Entity::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->parent_id = $this->mapping[$parent];
                $model->saveQuietly();
            }
        }

        return $this;
    }

    protected function saveEntity(): self
    {
        $this->entity->save();
        $this->mapImageMentions($this->entity);

        return $this;
    }
}
