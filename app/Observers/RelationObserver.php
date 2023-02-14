<?php

namespace App\Observers;

use App\Models\Relation;

class RelationObserver
{
    /**
     * @param Relation $relation
     */
    public function creating(Relation $relation)
    {
    }
}
