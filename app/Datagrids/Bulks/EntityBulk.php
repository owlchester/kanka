<?php

namespace App\Datagrids\Bulks;

class EntityBulk extends Bulk
{
    public function __construct()
    {
        parent::__construct(['name', 'type', 'parent_id', 'locations', 'status_id', 'tags', 'private_choice', 'entity_image', 'entity_header']);
    }
}
