<?php

namespace App\Services\Entity;

use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class RecoveryService
{
    use CampaignAware;
    use UserAware;

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
    protected function entity(int $id): ?string
    {
        /** @var ?Entity $entity */
        $entity = Entity::onlyTrashed()->find($id);
        if (! $entity) {
            return null;
        }

        $entity->restore();
        if ($entity->entityType->isCustom()) {
            return $entity->url();
        }

        // Sometimes the child is soft-deleted, sometimes not.
        // Honestly we shouldn't have soft-deleted children and just rely on the entity to reduce complexity.
        // @phpstan-ignore-next-line
        $child = $entity->child()->onlyTrashed()->first();
        if (! $child) {
            return $entity->url();
        }
        // Refresh the child first to not re-trigger the entity creation on save
        $child->refresh();
        $child->restoreQuietly();

        return $entity->url();
    }
}
