<?php

namespace App\Services\Entity;

use App\Http\Requests\ReorderStories;
use App\Models\Entity;
use App\Facades\Identity;
use App\Models\EntityLog;
use App\Models\Post;
use App\Traits\EntityAware;

class StoryService
{
    use EntityAware;

    /**
     */
    public function reorder(ReorderStories $request): bool
    {
        $posts = $request->get('posts');
        if (empty($posts)) {
            return false;
        }

        // If the story element isn't in first place, we need to have negative starting positions.
        $position = 0;
        $storyPosition = array_search('story', array_values($posts));
        $position -= $storyPosition;

        foreach ($posts as $id => $data) {
            // We only want to process posts
            if (!is_array($data) || $data == 'story' || $id === 'story') {
                continue;
            }
            $id = $data['id'];
            /** @var ?Post $story */
            $story = $this->entity->posts->where('id', $id)->first();
            if (empty($story)) {
                continue;
            }

            // Collapses status
            if (isset($data['collapsed'])) {
                $settings = $story->settings;
                if ($data['collapsed']) {
                    $settings['collapsed'] = true;
                } else {
                    unset($settings['collapsed']);
                }
                $story->settings = $settings;
            }
            if (isset($data['visibility_id'])) {
                $story->visibility_id = $data['visibility_id'];
            }

            // We want the first post after the story to always have the "1" position
            if ($position === 0) {
                $position = 1;
            }

            $story->position = $position;
            $story->timestamps = false;
            $story->saveQuietly();
            $position++;
        }
        $this->log();

        return true;
    }

    /**
     * Log the changes in the entity_logs table
     */
    private function log()
    {
        $log = new EntityLog();
        $log->entity_id = $this->entity->id;
        $log->created_by = auth()->user()->id;
        $log->impersonated_by = Identity::getImpersonatorId();
        $log->action = EntityLog::ACTION_REORDER_POST;
        $log->save();

        $this->entity->touchSilently();
        $this->entity->child->touchSilently();
    }
}
