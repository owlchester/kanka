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

    public function recover(array $ids): array
    {
        $posts = [];
        foreach ($ids as $id) {
            $url = $this->post($id);
            if ($url) {
                $posts[$id] = $url;
            }
        }

        return $posts;
    }

    /**
     * Restore an entity post.
     */
    protected function post(int $id): mixed
    {
        /** @var ?Post $post */
        $post = Post::onlyTrashed()->find($id);
        if (! $post) {
            return null;
        }
        if ($post->entity->deleted_at) {
            return null;
        }
        $post->restore();
        $options = ['#post-' . $post->id];

        return $post->entity->url('show', $options);
    }
}
