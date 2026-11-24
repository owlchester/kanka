<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Entity;
use App\Models\MiscModel;

abstract class StandardTreeMapper extends MiscMapper
{
    public function tree(): self
    {
        $mappedParents = array_intersect_key($this->mapping, $this->parents);
        if ($mappedParents === []) {
            return $this;
        }
        /** @var MiscModel $model */
        $model = new $this->className;
        $parentIds = Entity::query()
            ->where('campaign_id', $this->campaign->id)
            ->where('type_id', $model->entityTypeId())
            ->whereIntegerInRaw('entity_id', array_values($mappedParents))
            ->pluck('id', 'entity_id');

        $parentsByChild = [];
        foreach ($this->parents as $parent => $entityIds) {
            $parentId = $parentIds[$mappedParents[$parent] ?? 0] ?? null;
            if ($parentId === null) {
                continue;
            }
            foreach ($entityIds as $entityId) {
                $parentsByChild[$entityId] = $parentId;
            }
        }

        if ($parentsByChild !== []) {
            foreach (Entity::whereIntegerInRaw('id', array_keys($parentsByChild))->lazyById() as $entity) {
                $entity->parent_id = $parentsByChild[$entity->id];
                $entity->saveQuietly();
            }
        }

        return $this;
    }
}
