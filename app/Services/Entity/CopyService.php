<?php

namespace App\Services\Entity;

use App\Models\Entity;
use App\Traits\EntityAware;
use App\Traits\RequestAware;

class CopyService
{
    use EntityAware;
    use RequestAware;

    protected Entity $source;

    public function copy(): void
    {
        if (!$this->request->filled('copy_source_id')) {
            return;
        }

        $this->source = Entity::find((int) $this->request->get('copy_source_id'));
        // Invalid source, or of a different type?
        if (empty($this->source) || $this->source->type_id !== $this->entity->type_id) {
            return;
        }

        $this->posts()
            ->links()
            ->abilities()
            ->inventory()
            ->permissions()
            ->reminders()
            ->map()
            ->quest()
            ->timeline()
        ;
    }

    protected function posts(): self
    {
        if (!$this->check('copy_posts')) {
            return $this;
        }
        foreach ($this->source->posts as $post) {
            $post->copyTo($this->entity);
        }
        return $this;
    }

    protected function links(): self
    {
        if (!$this->check('copy_links')) {
            return $this;
        }
        foreach ($this->source->assets()->link()->get() as $link) {
            $link->copyTo($this->entity);
        }
        return $this;
    }

    protected function abilities(): self
    {
        if (!$this->check('copy_abilities')) {
            return $this;
        }
        foreach ($this->source->abilities as $ability) {
            $ability->copyTo($this->entity);
        }
        return $this;
    }

    protected function permissions(): self
    {
        if (!$this->check('copy_permissions')) {
            return $this;
        }
        foreach ($this->source->permissions as $perm) {
            $perm->copyTo($this->entity, $this->source->entity_id, $this->entity->entity_id);
        }
        return $this;
    }

    protected function inventory(): self
    {
        if (!$this->check('copy_inventory')) {
            return $this;
        }
        foreach ($this->source->inventories as $inventory) {
            $inventory->copyTo($this->entity);
        }
        return $this;
    }

    protected function reminders(): self
    {
        if (!$this->check('copy_reminders')) {
            return $this;
        }
        foreach ($this->source->reminders as $reminder) {
            $reminder->copyTo($this->entity);
        }
        return $this;
    }

    protected function map(): self
    {
        if (!$this->source->isMap() || !$this->check('copy_elements')) {
            return $this;
        }
        $this->source->child->copyRelatedToTarget($this->entity->map);
        return $this;
    }

    protected function quest(): self
    {
        if (!$this->source->isQuest() || !$this->check('copy_elements')) {
            return $this;
        }
        foreach ($this->source->quest->elements as $sub) {
            $newSub = $sub->replicate();
            $newSub->quest_id = $this->entity->entity_id;
            $newSub->save();
        }
        return $this;
    }

    protected function timeline(): self
    {
        if (!$this->source->isTimeline() || !$this->check('copy_eras')) {
            return $this;
        }
        $copyElements = $this->check('copy_elements');
        foreach ($this->source->timeline->eras as $era) {
            $newEra = $era->replicate();
            $newEra->timeline_id = $this->entity->entity_id;
            $newEra->save();

            if (!$copyElements) {
                continue;
            }
            foreach ($era->elements as $element) {
                $newElement = $element->replicate();
                $newElement->timeline_id = $this->entity->entity_id;
                $newElement->era_id = $newEra->id;
                $newElement->save();
            }
        }

        return $this;
    }


    protected function check(string $field): bool
    {
        return $this->request->has($field) && $this->request->filled($field);
    }
}
