<?php

namespace App\Observers;

use App\Events\Posts\PostCreated;
use App\Events\Posts\PostDeleted;
use App\Events\Posts\PostRestored;
use App\Events\Posts\PostUpdated;
use App\Models\Post;

class PostObserver
{
    use ReorderTrait;

    public function saving(Post $post)
    {
        $settings = $post->settings;
        if (request()->has('settings[collapse]')) {
            if ((bool) request()->get('settings[collapse]')) {
                $settings['collapse'] = true;
            } else {
                unset($settings['collapse']);
            }
        }
        $post->settings = $settings;
    }

    public function created(Post $post)
    {
        PostCreated::dispatch($post, auth()->user());
    }

    public function updated(Post $post)
    {
        // Don't log updates if just did one (typically when creating, restoring or bulk editing)
        if ($post->isDirty('deleted_at')) {
            return;
        }

        PostUpdated::dispatch($post, auth()->user());
    }

    public function saved(Post $post)
    {
        if (request()->filled('position')) {
            $this->reorder($post);
        }
        // When adding or changing a post to an entity, we want to update the
        // last updated date to reflect changes in the dashboard.
        $post->entity->touchSilently();
    }

    public function deleted(Post $post)
    {
        PostDeleted::dispatch($post, auth()->user());

        // When deleting a post, we want to update the entity's last update
        // for the dashboard. Careful of this when deleting an entity, we could be
        // entering a non-ending loop.
        if ($post->entity) {
            $post->entity->touchSilently();
        }
    }

    public function restored(Post $post)
    {
        PostRestored::dispatch($post, auth()->user());
    }
}
