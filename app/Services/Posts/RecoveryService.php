<?php

namespace App\Services\Posts;

use App\Models\Post;

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

    /**
     */
    public function recover(array $ids): int
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
     * Restore an entity and it's child
     * @return bool if the restore worked
     */
    protected function post(int $id): bool
    {
        /** @var Post|null $post */
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
}
