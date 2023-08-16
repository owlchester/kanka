<?php

namespace App\Services\Entity;

class PopularService
{
    /** @var array|string[] Popular entity types */
    protected array $popularEntityTypes = [
        'characters',
        'locations',
        'races',
        'items',
        'organisations',
    ];

    public function get(): array
    {
        return $this->popularEntityTypes;
    }
}
