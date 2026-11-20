<?php

namespace App\Datagrids\Bulks;

class Bulk
{
    public function __construct(
        protected array $fields = ['name', 'type', 'tags', 'private_choice', 'entity_image', 'entity_header'],
        protected array $booleans = [],
        protected array $foreignRelations = [],
        protected array $maths = [],
    ) {}

    public function fields(): array
    {
        return $this->fields;
    }

    public function booleans(): array
    {
        return $this->booleans;
    }

    public function foreignRelations(): array
    {
        return $this->foreignRelations;
    }

    public function maths(): array
    {
        return $this->maths;
    }
}
