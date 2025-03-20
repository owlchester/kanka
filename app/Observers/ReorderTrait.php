<?php

namespace App\Observers;

use App\Models\MapGroup;
use App\Models\MapLayer;
use App\Models\Post;
use App\Models\TimelineElement;

/**
 * Trait ReorderTrait
 */
trait ReorderTrait
{
    public function reorder(mixed $model)
    {
        $position = 1;

        if ($model instanceof MapGroup) {
            foreach ($model->map->groups()->orderBy('position')->get() as $group) {
                $group->position = $position;
                $group->updateQuietly();
                $position = $position + 1;
            }
        } elseif ($model instanceof MapLayer) {
            foreach ($model->map->layers()->orderBy('position')->get() as $layer) {
                $layer->position = $position;
                $layer->updateQuietly();
                $position = $position + 1;
            }
        } elseif ($model instanceof TimelineElement) {
            foreach ($model->era->elements()->orderBy('position')->orderBy('updated_at', 'DESC')->get() as $element) {
                $element->position = $position;
                $element->updateQuietly();
                $position = $position + 1;
            }
        } elseif ($model instanceof Post) {
            $this->reorderPosts($model);
        }
    }

    protected function reorderPosts(Post $model)
    {
        // Placing it first, this makes it a bit complicated
        $position = $model->position;

        // If it's placed after the entry (positive position)
        if ($model->position > 0) {
            /** @var Post[] $posts */
            $posts = $model->entity->posts()
                ->where('position', '>', 0)
                ->whereNot('id', $model->id)
                ->orderBy('position')
                ->get();
            foreach ($posts as $post) {
                // Ignore things that come "before". Could be moved into the query
                if ($post->position < $model->position) {
                    continue;
                }
                $position++;
                $post->position = $position;
                $post->updateQuietly();
            }
        } else {
            /** @var Post[] $posts */
            $posts = $model->entity->posts()
                ->where('position', '<', 0)
                ->whereNot('id', $model->id)
                ->orderByDesc('position')
                ->get();
            foreach ($posts as $post) {
                // Ignore things that come "after". Could be moved into the query
                if ($post->position > $model->position) {
                    continue;
                }
                $position--;
                $post->position = $position;
                $post->updateQuietly();
            }
        }
    }
}
