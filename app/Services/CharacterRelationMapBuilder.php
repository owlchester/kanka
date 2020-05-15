<?php

namespace App\Services;

use App\Models\Character;
use App\Models\MiscModel;

/**
 * Class CharacterRelationMapBuilder
 * @package App\Services
 */
class CharacterRelationMapBuilder
{
    /**
     * The character
     * @var Character
     */
    protected $character;

    /**
     * Entities that already exist
     * @var array
     */
    protected $entities = [];

    /**
     * Final map for d3 plugin
     * @var array
     */
    protected $map = [
        'nodes' => [],
        'links' => [],
    ];

    /**
     * @param Character $character
     */
    public function build(Character $character)
    {
        $this->character = $character;
        $this->buildNodes();
        $this->buildLinks();

        return $this->map;
    }

    /**
     *
     */
    protected function buildNodes()
    {
        $group = 1;
        $this->addNode($this->character, $group);
        $relationMemberDistance = 125;

        // Family
        if ($this->character->family) {
            // Add family node
            $this->addNode($this->character->family);
            // Add relation between character and family
            $this->addLink($this->character, $this->character->family);

            foreach ($this->character->family->members as $char) {
                $this->addNode($char, $group);
                $this->addLink($char, $char->family, $relationMemberDistance);
            }
        }
        // Organisations
        foreach ($this->character->organisations as $orgMember) {
            $this->addNode($orgMember->organisation);
            $this->addLink($this->character, $orgMember->organisation);
            $group++;
            foreach ($orgMember->organisation->members as $char) {
                $this->addNode($char->character, $group);
                $this->addLink($char->character, $orgMember->organisation, 150);
            }
        }
        // Quests
        foreach ($this->character->quests as $quest) {
            $group++;
            $this->addNode($quest);
            $this->addLink($this->character, $quest);
            foreach ($quest->characters as $char) {
                $this->addNode($char->character, $group);
                $this->addLink($char->character, $quest, $relationMemberDistance);
            }
        }
        // Location
        if (!empty($this->character->location)) {
            $group++;
            $this->addNode($this->character->location);
            $this->addLink($this->character, $this->character->location);
            foreach ($this->character->location->characters as $char) {
                $this->addNode($char, $group);
                $this->addLink($char, $this->character->location, $relationMemberDistance);
            }
        }
        // Relations
        $group++;
        foreach ($this->character->entity->relationships as $relation) {
            $this->addNode($relation->target->child, $group);
            $this->addLink($relation->target->child, $this->character, $relationMemberDistance);
        }
    }

    protected function buildLinks()
    {
    }

    /**
     * Add a character to the nodes
     * @param Character $character
     */
    protected function addNode(MiscModel $entity, $group = 1)
    {
        $key = $this->entityKey($entity);
        // We already have this entity, we're good.
        if (in_array($key, $this->entities)) {
            return true;
        }

        $data = [
            'id' => $key,
            'name' => $entity->name,
            'image' => $entity->getImageUrl(),
            'link' => $entity->getLink(),
            'group' => $group,
            'type' => __('entities.' . $entity->getEntityType())
        ];
        $this->map['nodes'][] = $data;

        $this->entities[] = $key;
    }

    /**
     * @param MiscModel $source
     * @param MiscModel $target
     * @param int $distance
     */
    protected function addLink(MiscModel $source, MiscModel $target, $distance = 300)
    {
        $this->map['links'][] = [
            'source' => $this->entityKey($source),
            'target' => $this->entityKey($target),
            'distance' => $distance
        ];
    }

    /**
     * @param MiscModel $entity
     * @return string
     */
    protected function entityKey(MiscModel $entity)
    {
        return $entity->getEntityType() . '-' . $entity->id;
    }
}
