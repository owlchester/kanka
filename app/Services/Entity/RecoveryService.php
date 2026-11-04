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

    protected function entity(int $id): ?string
    {
        /** @var ?Entity $entity */
        $entity = Entity::onlyTrashed()->find($id);
        if (! $entity) {
            return null;
        }

        $entity->restore();

        return $entity->url();
    }
}
