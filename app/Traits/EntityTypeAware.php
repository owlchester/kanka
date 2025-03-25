<?php

namespace App\Traits;

use App\Models\EntityType;

trait EntityTypeAware
{
    public EntityType $entityType;

    public function entityType(EntityType $entityType): self
    {
        $this->entityType = $entityType;

        return $this;
    }
}
