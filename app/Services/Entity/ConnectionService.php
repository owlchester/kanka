<?php


namespace App\Services\Entity;


use App\Models\Entity;
use Illuminate\Support\Arr;

class ConnectionService
{
    /**
     * @var Entity
     */
    protected $entity;

    protected $ids = [];

    protected $reasons = [];

    /**
     * @param Entity $entity
     * @return $this
     */
    public function entity(Entity $entity): self
    {
        $this->entity = $entity;
        return $this;
    }

    public function connectionsText(int $entityId): string
    {
        return implode(', ', $this->reasons[$entityId]);
    }

    public function connections()
    {
        // Prepare ids for pagination
        $this->prepareIds();


        return Entity::whereIn('id', $this->ids)
            ->acl()
            ->orderBy('name')
            ->paginate();
    }

    protected function prepareIds()
    {
        // Do stuff
        $entityHook = 'init' . $this->entity->entityType();
        if (method_exists($this, $entityHook)) {
            $this->$entityHook();
        } else {
            $this->loadMaps()
                ->loadTimelines()
                ->loadQuests();
        }
    }

    protected function initCharacter()
    {

        $this->loadMaps()
            ->loadQuests()
            ->loadItems()
            ->loadJournals()
            ->loadTimelines()
            ->loadDicerolls()
        ;
    }

    protected function loadQuests(): self
    {
        $elements = $this->entity->quests()->with(['quest', 'quest.entity'])->has('quest')->get();
        foreach ($elements as $sub) {
            $entity = $sub->quest->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities/relations.connections.quest_element');
        }
        return $this;
    }

    protected function loadTimelines(): self
    {
        $elements = $this->entity->timelines()->with(['timeline', 'timeline.entity'])->has('timeline')->get();
        foreach ($elements as $sub) {
            $entity = $sub->timeline->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities/relations.connections.timeline_element');
        }
        return $this;
    }

    protected function loadMaps(): self
    {
        $elements = $this->entity->mapMarkers()->with(['map', 'map.entity'])->has('map')->get();
        foreach ($elements as $sub) {
            $entity = $sub->map->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities/relations.connections.map_point');
        }
        return $this;
    }

    protected function loadDicerolls(): self
    {
        $elements = $this->entity->child->diceRolls()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('characters.show.tabs.dice_rolls');
        }
        return $this;
    }

    protected function loadConversations(): self
    {
        $elements = $this->entity->child->conversations()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('characters.show.tabs.conversations');
        }
        return $this;
    }

    protected function loadItems(): self
    {
        $elements = $this->entity->child->items()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('characters.show.tabs.items');
        }
        return $this;
    }

    protected function loadJournals(): self
    {
        $elements = $this->entity->child->journals()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('characters.show.tabs.journals');
        }
        return $this;
    }
}
