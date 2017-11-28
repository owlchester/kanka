<?php

namespace App\Services;

class EntityService
{
    /**
     * @var array
     */
    protected $entities = [];

    /**
     * EntityService constructor.
     */
    public function __construct()
    {
        $this->entities = [
            'characters' => 'App\Character',
            'events' => 'App\Models\Event',
            'families' => 'App\Family',
            'items' => 'App\Item',
            'journals' => 'App\Journal',
            'locations' => 'App\Location',
            'notes' => 'App\Note',
            'organisations' => 'App\Organisation',
            'quests' => 'App\Models\Quest',
        ];
    }

    /**
     * Get the entities
     *
     * @return array
     */
    public function entities()
    {
        return $this->entities;
    }
}
