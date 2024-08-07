<?php

namespace App\Services\Entity;

use App\Models\Entity;

class RecoveryService
{
    /** Number of total recovered entities */
    protected int $count = 0;

    /**
     */
    public function recover(array $ids): int
    {
        $this->count = 0;
        foreach ($ids as $id) {
            if ($this->entity($id)) {
                $this->count++;
            }
        }

        return $this->count;
    }


    /**
     */
    public function count(): int
    {
        return $this->count;
    }

    /**
     * Restore an entity and it's child
     * @return bool if the restore worked
     */
    protected function entity(int $id): bool
    {
        $entity = Entity::onlyTrashed()->find($id);
        if (!$entity) {
            return false;
        }

        // @phpstan-ignore-next-line
        $child = $entity->child()->onlyTrashed()->first();
        if (!$child) {
            return false;
        }

        $entity->restore();

        // Refresh the child first to not re-trigger the entity creation on save
        $child->refresh();
        $child->restoreQuietly();
        return true;
    }
}
