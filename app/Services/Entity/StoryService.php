<?php


namespace App\Services\Entity;


use App\Http\Requests\ReorderStories;
use App\Models\Entity;
use App\Models\EntityNote;

class StoryService
{
    /** @var Entity */
    protected $entity;

    /**
     * @param Entity $entity
     * @return $this
     */
    public function entity(Entity $entity): self
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * @param array $data
     * @return bool
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
            if (!is_array($data) || $data === 'story') {
                continue;
            }
            $id = $data['id'];
            /** @var EntityNote $story */
            $story = $this->entity->notes->where('id', $id)->first();
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
            if (isset($data['visibility'])) {
               $story->visibility = $data['visibility'];
            }

            $story->position = $position;
            $story->savingObserver = false;
            $story->savedObserver = false;
            $story->save();
            $position++;
        }

        return true;
    }
}
