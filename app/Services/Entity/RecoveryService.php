<?php

namespace App\Services\Entity;

use App\Models\Entity;

class RecoveryService
{
    /** Number of total recovered entities */
    protected int $count = 0;

    /**
     */
    public function recover(array $ids): array
    {
        $this->count = 0;
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
     */
    public function count(): int
    {
        return $this->count;
    }

    /**
     * Restore an entity and it's child
     * @return string if the restore worked
     */
    protected function entity(int $id): string
    {
        $entity = Entity::onlyTrashed()->find($id);
        if (!$entity) {
            return false;
        }

        // @phpstan-ignore-next-line
        $child = $entity->child()->onlyTrashed()->first();
        if (!$child) {
            return '';
        }

        $entity->restore();

        // Refresh the child first to not re-trigger the entity creation on save
        $child->refresh();
        $child->restoreQuietly();
        $this->count++;

        return $entity->url();
    }
}
