<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Facades\EntityLogger;
use App\Facades\ImportIdMapper;
use App\Models\Entity;
use App\Services\EntityMappingService;
use Carbon\Carbon;

trait EntityMapper
{
    protected array $mapping = [];

    protected array $parents = [];

    protected Entity $entity;

    protected mixed $model;

    protected EntityMappingService $entityMappingService;

    public function __construct(EntityMappingService $entityMappingService)
    {
        $this->entityMappingService = $entityMappingService;
    }

    protected function prepareModel(): self
    {
        $this->model = app()->make($this->className);
        $this->model->campaign_id = $this->campaign->id;
        foreach ($this->data as $field => $value) {
            // @phpstan-ignore-next-line
            if (is_array($value) || in_array($field, $this->ignore)) {
                continue;
            }
            $this->model->$field = $value;
        }

        $this->model->saveQuietly();
        $this->entity();

        return $this;
    }

    protected function loadModel(): self
    {
        $builder = app()->make($this->className);
        $id = ImportIdMapper::get($this->mappingName, $this->data['id']);
        $this->model = $builder->where('id', $id)->with('entity')->firstOrFail();
        $this->entity = $this->model->entity;

        return $this;
    }

    protected function trackMappings(?string $parent = null): void
    {
        $this->mapping[$this->data['id']] = $this->model->id;
        ImportIdMapper::put($this->mappingName, $this->data['id'], $this->model->id);
        if ($parent && ! empty($this->data[$parent])) {
            $this->parents[$this->data[$parent]][] = $this->model->id;
        }
    }

    protected function entity(): void
    {
        $mapping = ['name', 'is_private', 'campaign_id'];
        $entityMapping = ['tooltip', 'is_template', 'is_attributes_private', 'focus_x', 'focus_y', 'entry', 'type', 'type_id'];
        $this->entity = new Entity;
        $this->entity->entity_id = $this->model->id;
        $this->entity->created_by = $this->user->id;
        $this->entity->updated_by = $this->user->id;
        foreach ($mapping as $field) {
            $this->entity->$field = $this->model->$field;
        }
        // Old exports might not have this info so we call back on the model hardcoded ids
        if (empty($this->entity->type_id)) {
            $this->entity->type_id = $this->model->entityTypeId();
        }
        foreach ($entityMapping as $field) {
            $this->entity->$field = $this->data['entity'][$field];
        }

        if (isset($this->data['entity']['archived_at'])) {
            $this->entity->archived_at = Carbon::now();
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
            ->loadModel()
            ->entitySecond();
    }

    protected function entitySecond(): void
    {
        $this->entity = $this->model->entity;

        $this->entity->tooltip = $this->mentions($this->entity->tooltip);
        $this->entity->entry = $this->mentions($this->entity->entry);
        $this->entity->save();

        $this->posts()
            ->attributes()
            ->relations()
            ->reminders()
            ->abilities()
            ->inventory();
    }

    protected function foreign(string $model, string $field): self
    {
        if (empty($this->data[$field])) {
            return $this;
        }
        if ($model === 'entities') {
            if (! ImportIdMapper::hasEntity($this->data[$field])) {
                return $this;
            }
            $foreignID = ImportIdMapper::getEntity($this->data[$field]);
        } else {
            if (! ImportIdMapper::has($model, $this->data[$field])) {
                return $this;
            }
            $foreignID = ImportIdMapper::get($model, $this->data[$field]);
        }
        if (! $foreignID) {
            return $this;
        }
        $this->model->$field = $foreignID;

        return $this;
    }

    protected function pivot(string $relation, string $model, string $field): self
    {
        // Check if import has old location_id and migrate it to new locations pivot table system, currently only happens with organisations
        if ($relation == 'pivotLocations' && isset($this->data['location_id']) && ! in_array(['location_id' => $this->data['location_id']], $this->data[$relation])) {
            $this->data[$relation][] = ['location_id' => $this->data['location_id']];
        }
        foreach ($this->data[$relation] as $pivot) {
            if (! ImportIdMapper::has($model, $pivot[$field])) {
                continue;
            }
            $foreignID = ImportIdMapper::get($model, $pivot[$field]);
            if (array_key_exists('is_private', $pivot)) {
                $this->model->{$model}()->attach($foreignID, ['is_private' => $pivot['is_private']]);
            } else {
                $this->model->{$model}()->attach($foreignID);
            }
        }

        return $this;
    }

    /**
     * Import locations through the entity_locations pivot table
     */
    protected function entityLocations(): self
    {
        // Handle old location_id field from legacy exports
        if (isset($this->data['location_id']) && ImportIdMapper::has('locations', $this->data['location_id'])) {
            $foreignID = ImportIdMapper::get('locations', $this->data['location_id']);
            $this->entity->locations()->attach($foreignID);
        }

        // Handle pivotLocations data from exports
        if (isset($this->data['pivotLocations'])) {
            foreach ($this->data['pivotLocations'] as $pivot) {
                if (! ImportIdMapper::has('locations', $pivot['location_id'])) {
                    continue;
                }
                $foreignID = ImportIdMapper::get('locations', $pivot['location_id']);
                // Avoid duplicates (e.g., if location_id was already handled above)
                if (! $this->entity->locations()->where('entity_locations.location_id', $foreignID)->exists()) {
                    $this->entity->locations()->attach($foreignID);
                }
            }
        }

        return $this;
    }

    protected function saveModel(): self
    {
        $this->model->save();
        $this->mapImageMentions($this->model);

        return $this;
    }
}
