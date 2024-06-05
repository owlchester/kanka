<?php

namespace App\Services;

use App\Models\Entity;
use App\Models\Location;
use App\Models\MiscModel;
use App\Models\Post;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class RecoveryService
{
    /** @var array Entity IDs to be deleted */
    protected array $entityIds = [];

    /** @var array Post IDs to be deleted */
    protected array $postIds = [];

    /** @var array Child IDs to be deleted */
    protected array $childIds = [];

    /** @var int Number of total deleted entities */
    protected int $count = 0;

    /** @var int Number of total deleted posts */
    protected int $countPosts = 0;

    /**
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
     */
    public function recoverPosts(array $ids): int
    {
        $count = 0;
        foreach ($ids as $id) {
            if ($this->post($id)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Permanently delete old data
     * @return int deleted entities count
     * @throws Exception
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
                } catch (Exception $e) {
                    DB::rollBack();
                }
            });

        return $this->count;
    }

    /**
     */
    public function count(): int
    {
        return $this->count;
    }

    /**
     */
    public function countPosts(): int
    {
        return $this->countPosts;
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

    /**
     * Restore an entity and it's child
     * @return bool if the restore worked
     */
    protected function post(int $id): bool
    {
        $post = Post::onlyTrashed()->find($id);
        if (!$post) {
            return false;
        }
        if ($post->entity->deleted_at) {
            return false;
        }
        $post->restore();

        return true;
    }

    /**
     * @throws Exception
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
     * @throws Exception
     */
    public function trashPost(Post $post)
    {
        $this->postIds[] = $post->id;

        $post->forceDelete();
        $this->count++;
    }

    /**
     * @param MiscModel|Location|null $child
     * @throws Exception
     */
    protected function trashChild(Entity $entity, MiscModel $child = null)
    {
        if (empty($child)) {
            return false;
        }

        // Set the campaign scope to avoid hitting entities of other campaigns (this can happen with
        // nested modules)
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
                dump('#' . $entity->id . ' child ' . $child->getEntityType() . ' #' . $child->id . ' untreed');
            }

            // Clean up the parent and tree to avoid the nested plugin to delete every child
            $child->$parentField = null;

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
