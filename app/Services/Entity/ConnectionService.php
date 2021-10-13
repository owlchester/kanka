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

    protected $order = 'name';

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
     * @param string|null $order
     * @return $this
     */
    public function order($order): self
    {
        if (!in_array($order, ['name', 'type'])) {
            return $this;
        }

        $this->order = $order;
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
            ->orderBy($this->order)
            ->paginate();
    }

    protected function prepareIds()
    {
        // Do stuff
        $entityHook = 'init' . $this->entity->entityType();
        if (method_exists($this, $entityHook)) {
            $this->$entityHook();
        } else {
            $this->loadMapMarkers()
                ->loadLocation()
                ->loadTimelines()
                ->loadQuests();
        }
    }

    /**
     * Load anything related to a character
     */
    protected function initCharacter()
    {
        $this->loadMapMarkers()
            ->loadQuests()
            ->loadItems()
            ->loadJournals()
            ->loadTimelines()
            ->loadDicerolls()
        ;
    }

    /**
     * Load anything related to a location
     */
    protected function initLocation()
    {
        $this->loadMapMarkers()
            ->loadQuests()
            ->loadItems()
            ->loadOrganisations()
            ->loadMaps()
            ->loadJournals()
            ->loadFamilies()
            ->loadTimelines()
        ;
    }

    protected function initMap()
    {
        $this->loadMapMarkers()
            ->loadMaps()
            ->loadParentMaps()
            ->loadLocation()
            ->loadTimelines()
            ->loadQuests();
    }

    /**
     * @return $this
     */
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

    protected function loadMapMarkers(): self
    {
        $elements = $this->entity->mapMarkers()->with(['map', 'map.entity'])->has('map')->get();
        foreach ($elements as $sub) {
            $entity = $sub->map->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities/relations.connections.map_point');
        }
        return $this;
    }

    protected function loadMaps(): self
    {
        $elements = $this->entity->child->maps()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities.map');
        }
        return $this;
    }

    protected function loadParentMaps(): self
    {
        $elements = $this->entity->child->map()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('maps.fields.map');
        }
        return $this;
    }

    protected function loadDicerolls(): self
    {
        $elements = $this->entity->child->diceRolls()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities.dice_roll');
        }
        return $this;
    }

    protected function loadConversations(): self
    {
        $elements = $this->entity->child->conversations()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities.conversation');
        }
        return $this;
    }

    protected function loadItems(): self
    {
        $elements = $this->entity->child->items()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities.item');
        }
        return $this;
    }

    protected function loadJournals(): self
    {
        $elements = $this->entity->child->journals()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities.journal');
        }
        return $this;
    }

    protected function loadFamilies(): self
    {
        $elements = $this->entity->child->families()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities.family');
        }
        return $this;
    }

    protected function loadOrganisations(): self
    {
        $elements = $this->entity->child->organisations()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities.organisation');
        }
        return $this;
    }

    /**
     * Load the entity's location if it has one
     * @return $this
     */
    protected function loadLocation(): self
    {
        if (!isset($this->entity->child->location) || empty($this->entity->child->location)) {
            return $this;
        }

        $entity = $this->entity->child->location->entity;
        $this->ids[] = $entity->id;
        $this->reasons[$entity->id][] = __('entities.location');

        return $this;
    }
}
