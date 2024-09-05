<?php

namespace App\Services\Entity;

use App\Models\Entity;

class RecoveryService
{
    /**
     */
    public function recover(array $ids): array
    {
        $entities = [];
        foreach ($ids as $id) {
            $url = $this->entity($id);
            if ($url) {
                $entities[$id] = $url;
            }
        }

        return $entities;
    }

    /**
     * Restore an entity and it's child
     */
    protected function entity(int $id): mixed
    {
        $entity = Entity::onlyTrashed()->find($id);
        if (!$entity) {
            return null;
        }

        // @phpstan-ignore-next-line
        $child = $entity->child()->onlyTrashed()->first();
        if (!$child) {
            return null;
        }

        $entity->restore();

        // Refresh the child first to not re-trigger the entity creation on save
        $child->refresh();
        $child->restoreQuietly();

        return $entity->url();
    }
}
