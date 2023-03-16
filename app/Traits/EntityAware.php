<?php

namespace App\Traits;

use App\Models\Entity;

/**
 * Trait for campaign aware services
 */
trait EntityAware
{
    public Entity $entity;

    /**
     * @param Entity $entity
     * @return $this
     */
    public function entity(Entity $entity): self
    {
        $this->entity = $entity;
        return $this;
    }
}
