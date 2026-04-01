<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Facades\ImportIdMapper;
use App\Models\Entity;
use App\Models\Item;
use App\Models\ItemCreator;

class ItemMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'item_id', 'character_id', 'creator_id', 'created_at', 'updated_at', 'location_id'];

    protected string $className = Item::class;

    protected string $mappingName = 'items';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('item_id');
    }

    public function second(): void
    {
        // @phpstan-ignore method.notFound
        $this
            ->loadModel()
            ->foreign('locations', 'location_id')
            ->importCreators()
            ->saveModel()
            ->legacyCreator()
            ->entitySecond();
    }

    protected function importCreators(): self
    {
        if (empty($this->data['itemCreators'])) {
            return $this;
        }

        foreach ($this->data['itemCreators'] as $pivot) {
            if (! ImportIdMapper::hasEntity($pivot['creator_id'])) {
                continue;
            }

            $foreignID = ImportIdMapper::getEntity($pivot['creator_id']);
            $creator = new ItemCreator;
            $creator->item_id = $this->model->id;
            $creator->creator_id = $foreignID;
            $creator->save();
        }

        return $this;
    }

    /**
     * Backward compatibility: old exports have creator_id on the item instead of itemCreators pivot
     */
    protected function legacyCreator(): self
    {
        if (empty($this->data['creator_id']) || ! empty($this->data['itemCreators'])) {
            return $this;
        }

        if (! ImportIdMapper::hasEntity($this->data['creator_id'])) {
            return $this;
        }

        $foreignID = ImportIdMapper::getEntity($this->data['creator_id']);
        $creator = new ItemCreator;
        $creator->item_id = $this->model->id;
        $creator->creator_id = $foreignID;
        $creator->save();

        return $this;
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $entityIds) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            $parentEntity = Entity::where('entity_id', $this->mapping[$parent])
                ->where('type_id', config('entities.ids.item'))
                ->first();
            if (! $parentEntity) {
                continue;
            }
            $entities = Entity::whereIn('id', $entityIds)->get();
            foreach ($entities as $entity) {
                $entity->parent_id = $parentEntity->id;
                $entity->saveQuietly();
            }
        }

        return $this;
    }
}
