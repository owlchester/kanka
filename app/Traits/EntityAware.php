<?php

namespace App\Traits;

use App\Models\Entity;

trait EntityAware
{
    public Entity $entity;

    public function entity(Entity $entity): self
    {
        $this->entity = $entity;

        return $this;
    }
}
