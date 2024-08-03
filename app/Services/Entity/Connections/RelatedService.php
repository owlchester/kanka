<?php

namespace App\Services\Entity\Connections;

use App\Models\Character;
use App\Models\Conversation;
use App\Models\Entity;
use App\Models\Family;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Map;
use App\Models\Organisation;
use App\Models\Race;
use App\Traits\EntityAware;

class RelatedService
{
    use EntityAware;

    protected array $ids = [];

    protected array $reasons = [];

    protected string $order = 'name';

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
            ->with('image')
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
                ->loadQuests()
                ->loadAuthoredJournals()
            ;
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
            ->loadTimelines()
            ->loadDicerolls()
            ->loadAuthoredJournals()
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
            ->loadAuthoredJournals()
            ->loadRaces()
        ;
    }

    protected function initMap()
    {
        $this->loadMapMarkers()
            ->loadMaps()
            ->loadParentMaps()
            ->loadLocation()
            ->loadTimelines()
            ->loadAuthoredJournals()
            ->loadQuests()
        ;
    }


    protected function initRace()
    {
        $this
            ->loadChildRaces()
            ->loadLocations()
        ;
    }

    protected function initOrganisation()
    {
        $this
            ->loadMapMarkers()
            ->loadLocations()
            ->loadTimelines()
            ->loadQuests()
            ->loadAuthoredJournals()
        ;
    }

    /**
     * @return $this
     */
    protected function loadQuests(): self
    {
        $elements = $this->entity->quests()->with(['quest', 'quest.entity'])->has('quest')->get();
        foreach ($elements as $sub) {
            $entity = $sub->quest->entity;
            if (empty($entity)) {
                continue;
            }
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
            if (empty($entity)) {
                continue;
            }
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
            if (empty($entity)) {
                continue;
            }
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities/relations.connections.map_point');
        }
        return $this;
    }

    protected function loadMaps(): self
    {
        /** @var Map $parent */
        $parent = $this->entity->child;
        $elements = $parent->maps()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities.map');
        }
        return $this;
    }

    protected function loadParentMaps(): self
    {
        /** @var Map $parent */
        $parent = $this->entity->child;
        $elements = $parent->map()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('maps.fields.map');
        }
        return $this;
    }

    protected function loadDicerolls(): self
    {
        /** @var Character $parent */
        $parent = $this->entity->child;
        $elements = $parent->diceRolls()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities.dice_roll');
        }
        return $this;
    }

    protected function loadConversations(): self
    {
        /** @var Character $parent */
        $parent = $this->entity->child;
        $elements = $parent->conversations()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            /** @var Conversation $sub */
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities.conversation');
        }
        return $this;
    }

    protected function loadItems(): self
    {
        /** @var Item $parent */
        $parent = $this->entity->child;
        $elements = $parent->items()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities.item');
        }
        return $this;
    }

    protected function loadJournals(): self
    {
        /** @var Journal $parent */
        $parent = $this->entity->child;
        $elements = $parent->journals()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities.journal');
        }
        return $this;
    }

    protected function loadAuthoredJournals(): self
    {
        $elements = $this->entity->authoredJournals()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('journals.fields.author');
        }
        return $this;
    }

    protected function loadFamilies(): self
    {
        /** @var Family $parent */
        $parent = $this->entity->child;
        $elements = $parent->families()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities.family');
        }
        return $this;
    }

    protected function loadOrganisations(): self
    {
        /** @var Organisation $parent */
        $parent = $this->entity->child;
        $elements = $parent->organisations()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities.organisation');
        }
        return $this;
    }

    protected function loadRaces(): self
    {
        /** @var Race $parent */
        $parent = $this->entity->child;
        $elements = $parent->races()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities.race');
        }
        return $this;
    }

    protected function loadChildRaces(): self
    {
        /** @var Race $parent */
        $parent = $this->entity->child;
        $elements = $parent->races()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities.race');
        }
        return $this;
    }

    protected function loadLocations(): self
    {
        /** @var Location $parent */
        $parent = $this->entity->child;
        $elements = $parent->locations()->with(['entity'])->has('entity')->get();
        foreach ($elements as $sub) {
            $entity = $sub->entity;
            $this->ids[] = $entity->id;
            $this->reasons[$entity->id][] = __('entities.location');
        }
        return $this;
    }

    /**
     * Load the entity's location if it has one
     * @return $this
     */
    protected function loadLocation(): self
    {
        if (
            !isset($this->entity->child->location) ||
            empty($this->entity->child->location) ||
            empty($this->entity->child->location->entity)
        ) {
            return $this;
        }

        $entity = $this->entity->child->location->entity;
        $this->ids[] = $entity->id;
        $this->reasons[$entity->id][] = __('entities.location');

        return $this;
    }
}
