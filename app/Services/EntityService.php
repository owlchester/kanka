<?php

namespace App\Services;

class EntityService
{
    /**
     * @var array
     */
    protected $entities = [];

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
        ];
    }

    public function entities()
    {
        return $this->entities;
    }
}