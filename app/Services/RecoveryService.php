<?php

namespace App\Services;

use App\Models\Entity;
use App\Models\Location;
use App\Models\MiscModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RecoveryService
{
    /** @var array Entity IDs to be deleted */
    protected array $entityIds = [];

    /** @var array Child IDs to be deleted */
    protected array $childIds = [];

    /** @var int Number of total deleted entities */
    protected int $count = 0;

    /**
     * @param array $ids
     * @return int
     */
    public function recover(array $ids): int
    {
        $count = 0;
        foreach ($ids as $id) {
            if ($this->entity($id)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Permanently delete old data
     * @return int deleted entities count
     * @throws \Exception
     */
    public function cleanup(): int
    {
        Entity::onlyTrashed()
            ->where('type', 'race')
            ->where('deleted_at', '<=', Carbon::now()->subDays(config('entities.hard_delete'))->toDateString())
            ->chunk(500, function ($entities) {
                DB::beginTransaction();
                try {
                    foreach ($entities as $entity) {
                        $this->trash($entity);
                    }
                    DB::commit();

                    dump('Trashed ' . count($entities) . ' entities.');
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            });

        return $this->count;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->count;
    }

    /**
     * Restore an entity and it's child
     * @param int $id
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
        //$child->savingObserver = false;
        $child->refresh();
        $child->restoreQuietly();
        return true;
    }

    /**
     * @param Entity $entity
     * @throws \Exception
     */
    public function trash(Entity $entity)
    {
        /** @var MiscModel $child */
        // @phpstan-ignore-next-line
        $child = $entity->child()->onlyTrashed()->first();
        $this->trashChild($entity, $child);

        $this->entityIds[] = $entity->id;
        $entity->forceDelete();

        ImageService::cleanup($child);


        $this->count++;
    }

    /**
     * @param Entity $entity
     * @param MiscModel|Location|null $child
     * @throws \Exception
     */
    protected function trashChild(Entity $entity, MiscModel $child = null)
    {
        if (empty($child)) {
            return false;
        }

        // Set the campaign scope to avoid hitting entities of other campaigns (this can happen with
        // nested trees)
        \App\Facades\CampaignLocalization::setConsoleCampaign($entity->campaign_id);

        // Update the parent_id / tree before
        if (method_exists($child, 'getParentIdName')) {
            $parentField = $child->getParentIdName();

            // Detach children of this entity. Usually this is already done in the model observer, because
            // if the parent is deleted in a node, the children aren't available.
            /** @var MiscModel $subChild */
            // @phpstan-ignore-next-line
            foreach ($child->children as $subChild) {
                // In console mode, we don't have the campaign_id restriction. We've had cases where this script
                // found entities form other campaigns.
                if ($subChild->campaign_id != $child->campaign_id) {
                    throw new \Exception(
                        'Found a subchild that doesn\'t share the campaign id. '
                        . $subChild->id . ' and ' . $child->id
                    );
                }
                $subChild->$parentField = null;
                $subChild->timestamps = false;
                $subChild->saveQuietly();
                dump('#' . $entity->id . ' child ' . $child->getEntityType() . ' #' . $child->id . ' untreed');
            }

            // Clean up the parent and tree to avoid the nested plugin to delete every child
            $child->$parentField = null;
            $child->_lft = null; // @phpstan-ignore-line
            $child->_rgt = null; // @phpstan-ignore-line

            $child->timestamps = false;
            $child->saveQuietly();
            $child->refresh();
        }


        $this->childIds[$child->getEntityType()][] = $child->id;

        // Cleanup any images attached to the child.
        ImageService::cleanup($child);

        if ($child instanceof Location && !empty($child->map)) {
            ImageService::cleanup($child, 'map');
        }

        $child->forceDelete();


        // Unset the campaign id limitation again
        \App\Facades\CampaignLocalization::setConsoleCampaign(0);

        return true;
    }
}
