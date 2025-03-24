<?php

namespace App\Services\Entity;

use App\Facades\CharacterCache;
use App\Facades\EntityCache;
use App\Models\Entity;
use App\Models\Location;
use App\Models\MiscModel;
use App\Facades\Images;
use Exception;

class PurgeService
{
    /** @var array Entity IDs to be deleted */
    protected array $entityIds = [];

    /** @var array Child IDs to be deleted */
    protected array $childIds = [];

    /** @var int Number of total deleted entities */
    protected int $count = 0;

    /**
     */
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

        /** @var MiscModel $child */
        if ($entity->hasChild()) {
            // @phpstan-ignore-next-line
            $child = $entity->child()->onlyTrashed()->first();
            $this->trashChild($entity, $child);
        }

        $this->entityIds[] = $entity->id;
        $entity->forceDelete();

        if ($entity->hasChild()) {
            Images::cleanup($child);
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
        \App\Facades\CampaignLocalization::setConsoleCampaign($entity->campaign_id);

        // Update the parent_id / tree before
        if (method_exists($child, 'getParentKeyName')) {
            $parentField = $child->getParentKeyName();

            // Detach children of this entity. Usually this is already done in the model observer, because
            // if the parent is deleted in a node, the children aren't available.
            /** @var MiscModel $subChild */
            // @phpstan-ignore-next-line
            foreach ($child->children as $subChild) {
                // In console mode, we don't have the campaign_id restriction. We've had cases where this script
                // found entities form other campaigns.
                if ($subChild->campaign_id != $child->campaign_id) {
                    throw new Exception(
                        'Found a subchild that doesn\'t share the campaign id. '
                        . $subChild->id . ' and ' . $child->id
                    );
                }
                $subChild->$parentField = null;
                $subChild->timestamps = false;
                $subChild->saveQuietly();
                dump('#' . $entity->id . ' child ' . $entity->entityType->code . ' #' . $child->id . ' untreed');
            }

            // Clean up the parent and tree to avoid the nested plugin to delete every child
            $child->$parentField = null;

            $child->timestamps = false;
            $child->saveQuietly();
            $child->refresh();
        }


        $this->childIds[$entity->entityType->code][] = $child->id;

        // Cleanup any images attached to the child.
        Images::cleanup($child);

        if ($child instanceof Location && !empty($child->map)) {
            Images::cleanup($child, 'map');
        }

        CharacterCache::campaign($entity->campaign);
        $child->forceDelete();

        // Unset the campaign id limitation again
        \App\Facades\CampaignLocalization::setConsoleCampaign(0);

        return true;
    }
}
