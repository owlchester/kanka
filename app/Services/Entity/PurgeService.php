<?php

namespace App\Services\Entity;

use App\Facades\CampaignLocalization;
use App\Facades\CharacterCache;
use App\Facades\EntityCache;
use App\Facades\Images;
use App\Models\Entity;
use App\Models\Location;
use App\Models\MiscModel;
use Exception;

class PurgeService
{
    /** @var array Entity IDs to be deleted */
    protected array $entityIds = [];

    /** @var array Child IDs to be deleted */
    protected array $childIds = [];

    /** @var int Number of total deleted entities */
    protected int $count = 0;

    public function count(): int
    {
        return $this->count;
    }

    /**
     * @throws Exception
     */
    public function trash(Entity $entity): void
    {
        EntityCache::campaign($entity->campaign);

        if ($entity->hasChild()) {
            /** @var MiscModel $child */
            // @phpstan-ignore-next-line
            $child = $entity->child()->onlyTrashed()->first();
            $this->trashChild($entity, $child);
        }

        $this->entityIds[] = $entity->id;
        $entity->forceDelete();

        if (isset($child)) {
            Images::model($child)->field('image')->cleanup();
        }

        $this->count++;
    }

    /**
     * @throws Exception
     */
    protected function trashChild(Entity $entity, ?MiscModel $child = null)
    {
        if (empty($child)) {
            return false;
        }

        // Set the campaign scope to avoid hitting entities of other campaigns (this can happen with
        // nested modules)
        // This probably is no longer the case since.
        CampaignLocalization::setConsoleCampaign($entity->campaign_id);

        // Detach children of this entity via entities.parent_id
        foreach ($entity->children as $childEntity) {
            if ($childEntity->campaign_id != $entity->campaign_id) {
                throw new Exception(
                    'Found a child entity that doesn\'t share the campaign id. '
                    . $childEntity->id . ' and ' . $entity->id
                );
            }
            $childEntity->parent_id = null;
            $childEntity->timestamps = false;
            $childEntity->saveQuietly();
            dump('#' . $entity->id . ' child entity #' . $childEntity->id . ' untreed');
        }

        // Clean up the parent to avoid cascading deletes
        $entity->parent_id = null;
        $entity->timestamps = false;
        $entity->saveQuietly();

        $this->childIds[$entity->entityType->code][] = $child->id;

        // Cleanup any images attached to the child.
        Images::model($child)->field('image')->cleanup();

        if ($child instanceof Location && ! empty($child->map)) {
            Images::model($child)->field('map')->cleanup();
        }

        CharacterCache::campaign($entity->campaign);
        $child->forceDelete();

        // Unset the campaign id limitation again
        CampaignLocalization::setConsoleCampaign(0);

        return true;
    }
}
