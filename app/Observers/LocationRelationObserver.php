<?php

namespace App\Observers;

use App\Campaign;
use App\Location;
use App\Models\LocationRelation;
use App\Traits\RelationTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class LocationRelationObserver
{
    use RelationTrait;

    /**
     * @param LocationRelation $character
     */
    public function created(LocationRelation $relation)
    {
        $this->createRelation($relation);
    }
}
