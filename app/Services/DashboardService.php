<?php


namespace App\Services;


use App\Models\Entity;

class DashboardService
{
    /** @var array IDs of entities displayed */
    protected $displayedEntities = [];

    /**
     * @param Entity $entity
     * @return $this
     */
    public function add(Entity $entity): self
    {
        $this->displayedEntities[] = $entity->id;
        return $this;
    }

    public function excluding(): array
    {
        return $this->displayedEntities;
    }
}
