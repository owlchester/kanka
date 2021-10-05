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
        $ids = $request->get('entity_note_id');
        if (empty($ids)) {
            return false;
        }

        $position = 0;
        $types = $request->get('entity_types');
        $storyPosition = array_search('story', $types);
        $position -= $storyPosition;

        foreach ($ids as $id) {
            /** @var EntityNote $story */
            $story = $this->entity->notes->where('id', $id)->first();
            if (empty($story)) {
                continue;
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
